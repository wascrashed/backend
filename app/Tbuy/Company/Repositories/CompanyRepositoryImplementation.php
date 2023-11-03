<?php

namespace App\Tbuy\Company\Repositories;

use App\DTOs\BaseDTO;
use App\Tbuy\Company\DTOs\CompanyDataConfirmationDTO;
use App\Tbuy\Company\DTOs\CompanyDTO;
use App\Tbuy\Company\DTOs\CompanyFilterDTO;
use App\Tbuy\Company\DTOs\CompanyStatusDTO;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Purchase\Models\ProductPurchase;
use App\Tbuy\Refund\Models\Refund;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CompanyRepositoryImplementation implements CompanyRepository
{
    const COEFFICIENT = 500;

    public function get(CompanyFilterDTO $payload): Collection
    {
        return Company::query()
            ->filter($payload->toArray())
            ->when($payload->status?->isRejected(),
                fn(Builder $builder) => $builder->with('rejections',
                    fn(MorphMany $b) => $b->with('reason')->without('rejectionable')
                )
            )
            ->with([
                'logo',
                'brands',
                'ratings',
                'children',
                'brandDocument',
                'innDocument',
                'passportDocument',
                'stateRegisterDocument'
            ])
            ->get();
    }

    public function create(CompanyDTO $payload): Company
    {
        $company = new Company((array)$payload);
        $company->save();

        return $company;
    }

    public function update(Company $company, BaseDTO $payload): Company
    {
        $company->fill(array_filter((array)$payload));
        $company->save();

        return $company;
    }

    public function delete(Company $company): bool
    {
        return $company->delete();
    }

    public function setStatus(Company $company, CompanyStatusDTO $payload): Company
    {
        $company->fill([
            'status' => $payload->status
        ]);
        $company->save();

        return $company;
    }

    public function getById(int $companyId): Company
    {
        /** @var Company $company */
        $company = Company::query()
            ->with([
                'children',
                'brandDocument',
                'innDocument',
                'passportDocument',
                'stateRegisterDocument'
            ])
            ->find($companyId);

        return $company;
    }

    /**
     * @param Company $company
     * @return float|int
     */
    public function purchasesRefunds(Company $company): float|int
    {
        $productIds = $company->load('products')->products->pluck('id')->toArray();
        $purchases = ProductPurchase::query()->whereIn('product_id', $productIds)->count();
        $refunds = Refund::query()->whereIn('product_id', $productIds)->count();

        return ($purchases / ($refunds == 0 ? 1 : $refunds)) * self::COEFFICIENT;
    }

    public function score(Company $company, ?int $score): Company
    {
        $company->ratings()
            ->detach([
                'user_id' => auth()->id()
            ]);

        if ($score) {
            $company->ratings()->attach(['user_id' => auth()->id()], ['rating' => $score]);
        }

        return $company;
    }

    public function updateFieldsDataConfirmation(Company $company, CompanyDataConfirmationDTO $payload): Company
    {
        $company->update([
            'bank_account' => $payload->bank_account,
            'tariff_conditions_accepted_at' => $payload->tariff_conditions_accepted_at,
            'basic_agreement_accepted_at' => $payload->basic_agreement_accepted_at,
        ]);

        return $company->fresh();
    }
    public function getEmployeesByCompany(Company $company): Collection
    {
        return $company->employees;
    }
}
