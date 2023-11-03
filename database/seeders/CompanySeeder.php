<?php

namespace Database\Seeders;

use App\Jobs\ParseFakeImageJob;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\DTOs\CompanyStatusDTO;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Complaint\Models\Complaint;
use App\Tbuy\Filial\Models\Filial;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\Reason\Models\Reason;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var RejectionRepository $rejectionRepository */
        $rejectionRepository = app(RejectionRepository::class);
        Company::factory(50)
            ->has(
                Company::factory(5)->has(
                    Brand::factory(5), 'brands'),
                'children')
            ->has(Filial::factory(5), 'filials')
            ->has(Brand::factory(5), 'brands')
            ->has(Complaint::factory(mt_rand(1, 20)), 'complaints')
            ->create();

        Company::all()
            ->each(function (Company $company) use ($rejectionRepository) {
                if ($company->status->isRejected()) {

                    $reason_id = Reason::query()->inRandomOrder()->first()->id;
                    $user_id = User::query()->inRandomOrder()->first()->id;
                    $dto = new CompanyStatusDTO('rejected', $reason_id);

                    $rejectionRepository->create($company, $dto, $user_id);
                }

                $randomNumber = array_rand([1, 2, 3, 4]);

                //ParseFakeImageJob::dispatch($company, MediaLibraryCollection::COMPANY_LOGO)->delay(2);

//                for ($i = 0; $i < $randomNumber; $i++) {
//                    $company->addMediaFromString(Str::uuid()->toString())
//                        ->toMediaCollection(MediaLibraryCollection::COMPANY_BRAND_DOCUMENT->value, 'public');
//                }

//                $company->addMediaFromString(Str::uuid()->toString())
//                        ->toMediaCollection(MediaLibraryCollection::COMPANY_INN_DOCUMENT->value, 'public');
//
//                $company->addMediaFromString(Str::uuid()->toString())
//                    ->toMediaCollection(MediaLibraryCollection::COMPANY_STATE_REGISTER_DOCUMENT->value, 'public');
//
//                $company->addMediaFromString(Str::uuid()->toString())
//                    ->toMediaCollection(MediaLibraryCollection::COMPANY_PASSPORT_DOCUMENT->value, 'public');
            });
    }
}
