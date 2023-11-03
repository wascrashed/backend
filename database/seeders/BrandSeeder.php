<?php

namespace Database\Seeders;

use App\Tbuy\Brand\DTOs\BrandStatusDTO;
use App\Tbuy\Brand\Models\BrandCategory;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Reason\Models\Reason;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var RejectionRepository $rejectionRepository */
        $rejectionRepository = app(RejectionRepository::class);
        Brand::query()->get()
            ->each(function (Brand $brand) use ($rejectionRepository) {
                if ($brand->status->isRejected()) {

                    $reason_id = Reason::query()->inRandomOrder()->first()->id;
                    $user_id = User::query()->inRandomOrder()->first()->id;
                    $dto = new BrandStatusDTO('rejected', $reason_id);

                    $rejectionRepository->create($brand, $dto, $user_id);
                }
            });

        BrandCategory::factory(200)->create();
    }
}
