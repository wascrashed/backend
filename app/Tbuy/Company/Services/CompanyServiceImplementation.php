<?php

namespace App\Tbuy\Company\Services;

use App\Tbuy\Company\DTOs\CompanyClientDTO;
use App\Tbuy\Company\DTOs\CompanyDataConfirmationDTO;
use App\Tbuy\Company\DTOs\CompanyDTO;
use App\Tbuy\Company\DTOs\CompanyFilterDTO;
use App\Tbuy\Company\DTOs\CompanyStatusDTO;
use App\Tbuy\Company\DTOs\CompanyUpdateDTO;
use App\Tbuy\Company\Enums\CacheKeys;
use App\Tbuy\Company\Events\CompanyRejected;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Company\Notifications\RegisteredSuccessfullyNotification;
use App\Tbuy\Company\Repositories\CompanyRepository;
use App\Tbuy\Employee\Models\CompanyEmployee;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\MediaLibrary\Repositories\MediaLibraryRepository;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use App\Tbuy\User\DTOs\UserDTO;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use App\Traits\HasSubscribers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection ;
class CompanyServiceImplementation implements CompanyService
{
    public function __construct(
        private readonly CompanyRepository      $companyRepository,
        private readonly MediaLibraryRepository $libraryRepository,
        private readonly RejectionRepository    $rejectionRepository,
        private readonly UserRepository         $userRepository
    )
    {
    }

    use HasSubscribers;

    public function get(CompanyFilterDTO $filters): Collection
    {
        return Cache::tags(CacheKeys::COMPANY_TAG->value)
            ->remember(
                CacheKeys::COMPANY_LIST->setKeys($filters),
                CacheKeys::ttl(),
                fn() => $this->companyRepository->get($filters)
            );
    }

    public function store(CompanyDTO $dto): Company
    {
        $company = DB::transaction(function () use ($dto) {

            $password = app()->environment('production') ? Str::password() : 'password';

            $user = $this->userRepository->store(new UserDTO(implode(' ', $dto->director->toArray()), $dto->email, $password));

            $dto->user_id = $user->id;

            $company = $this->companyRepository->create($dto);

            $user->notify(new RegisteredSuccessfullyNotification($password));

            $this->libraryRepository->addMedia(
                $company,
                $dto->inn_document,
                MediaLibraryCollection::COMPANY_INN_DOCUMENT
            );

            $this->libraryRepository->addMedia(
                $company,
                $dto->passport_document,
                MediaLibraryCollection::COMPANY_PASSPORT_DOCUMENT
            );

            $this->libraryRepository->addMedia(
                $company,
                $dto->state_register_document,
                MediaLibraryCollection::COMPANY_STATE_REGISTER_DOCUMENT
            );

            return $company->load([
                'brandDocument',
                'innDocument',
                'passportDocument',
                'stateRegisterDocument'
            ]);
        });

        Cache::tags(CacheKeys::COMPANY_TAG)->clear();

        return $company;
    }

    public function update(Company $company, CompanyUpdateDTO $dto): Company
    {
        $company = DB::transaction(function () use ($company, $dto) {
            $company = $this->companyRepository->update($company, $dto);

            if ($dto->brand_document) {
                $this->libraryRepository->delete($company, MediaLibraryCollection::COMPANY_BRAND_DOCUMENT);
                $this->libraryRepository->addMedia(
                    $company,
                    $dto->brand_document,
                    MediaLibraryCollection::COMPANY_BRAND_DOCUMENT
                );
            }

            if ($dto->inn_document) {
                $this->libraryRepository->delete($company, MediaLibraryCollection::COMPANY_INN_DOCUMENT);
                $this->libraryRepository->addMedia(
                    $company,
                    $dto->inn_document,
                    MediaLibraryCollection::COMPANY_INN_DOCUMENT
                );
            }

            if ($dto->passport_document) {
                $this->libraryRepository->delete($company, MediaLibraryCollection::COMPANY_PASSPORT_DOCUMENT);
                $this->libraryRepository->addMedia(
                    $company,
                    $dto->passport_document,
                    MediaLibraryCollection::COMPANY_PASSPORT_DOCUMENT
                );
            }

            if ($dto->state_register_document) {
                $this->libraryRepository->delete($company, MediaLibraryCollection::COMPANY_STATE_REGISTER_DOCUMENT);
                $this->libraryRepository->addMedia(
                    $company,
                    $dto->state_register_document,
                    MediaLibraryCollection::COMPANY_STATE_REGISTER_DOCUMENT
                );
            }

            return $company->load([
                'brandDocument',
                'innDocument',
                'passportDocument',
                'stateRegisterDocument'
            ]);
        });

        Cache::tags(CacheKeys::COMPANY_TAG)->clear();

        return $company;
    }

    public function delete(Company $company): bool
    {
        $isDeleted = $this->companyRepository->delete($company);

        if ($isDeleted) {
            Cache::tags(CacheKeys::COMPANY_TAG)->clear();
        }

        return $isDeleted;
    }

    public function toggleStatus(Company $company, CompanyStatusDTO $payload): Company
    {
        $company = DB::transaction(function () use ($company, $payload) {
            $company = $this->companyRepository->setStatus($company, $payload);

            if ($company->status->isRejected()) {
                $this->rejectionRepository->create($company, $payload, auth()->id());
            }

            if ($payload->status->isArchived()) {
                event(new CompanyRejected($company, $payload, auth()->id()));
            }

            return $company;
        });

        Cache::tags(CacheKeys::COMPANY_TAG)->clear();

        return $company;
    }

    public function clientUpdate(Company $company, CompanyClientDTO $payload): Company
    {
        $company = DB::transaction(function () use ($company, $payload) {
            $company = $this->companyRepository->update($company, $payload);

            if ($payload->logo) {
                if ($company->logo) {
                    $this->libraryRepository->delete($company, MediaLibraryCollection::COMPANY_LOGO);
                }

                $this->libraryRepository->addMedia($company, $payload->logo, MediaLibraryCollection::COMPANY_LOGO);
            }

            return $company->load('logo');
        });

        Cache::tags(CacheKeys::COMPANY_TAG)->clear();

        return $company;
    }

    public function getAuthCompany(): Company
    {
        /** @var User $user */
        $user = auth()->user();
        return $user->company->load('user');
    }

    public function purchasesRefunds(Company $company): float|int
    {
        return Cache::tags(CacheKeys::COMPANY_TAG->value)
            ->remember(
                CacheKeys::COMPANY_PURCHASE_REFUND->value,
                CacheKeys::ttl(),
                fn() => $this->companyRepository->purchasesRefunds($company)
            );
    }

    public function score(Company $company, ?int $score): Company
    {
        $company = DB::transaction(
            fn() => $this->companyRepository->score($company, $score)
        );

        Cache::tags(CacheKeys::COMPANY_TAG->value)->clear();

        return $company->load('ratings');
    }
    public function getEmployees(Company $company): Collection
    {
        $cacheKey = CacheKeys::COMPANY_EMPLOYEE_LIST->setKeys(['id' => $company->id]);

        return Cache::tags(CacheKeys::COMPANY_EMPLOYEE->value)->remember($cacheKey, CacheKeys::ttl(), function () use ($company) {

            return $this->companyRepository->getEmployeesByCompany($company);
        });
    }



    public function dataConfirmationCompany(Company $company, CompanyDataConfirmationDTO $payload): Company
    {
        $company = $this->companyRepository->updateFieldsDataConfirmation($company, $payload);
        Cache::tags(CacheKeys::COMPANY_TAG->value)->clear();

        return $company;
    }
}
