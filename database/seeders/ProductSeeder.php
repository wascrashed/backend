<?php

namespace Database\Seeders;

use App\Jobs\ParseFakeImageJob;
use App\Tbuy\Attributable\Models\Attributable;
use App\Tbuy\Complaint\Models\Complaint;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\Product\DTOs\ProductToggleStatusDTO;
use App\Tbuy\Product\Enums\ProductStatus;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Reason\Models\Reason;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var RejectionRepository $rejectionRepository */
        $rejectionRepository = app(RejectionRepository::class);
        Product::factory(100)
            ->has(Complaint::factory(3), 'complaints')
            ->has(Attributable::factory(5), 'attributesList')
            ->create()
            ->each(function (Product $product) use ($rejectionRepository) {
                if ($product->status->isRejected()) {

                    $reason_id = Reason::query()->inRandomOrder()->first()->id;
                    $user_id = User::query()->inRandomOrder()->first()->id;
                    $dto = new ProductToggleStatusDTO(ProductStatus::REJECTED, $reason_id);

                    $rejectionRepository->create($product, $dto, $user_id);
                }
//                ParseFakeImageJob::dispatch($product, MediaLibraryCollection::PRODUCT_MEDIA)->delay(2);
//                ParseFakeImageJob::dispatch($product, MediaLibraryCollection::PRODUCT_MEDIA)->delay(2);
//                ParseFakeImageJob::dispatch($product, MediaLibraryCollection::PRODUCT_MEDIA)->delay(2);
//                ParseFakeImageJob::dispatch($product, MediaLibraryCollection::PRODUCT_MEDIA_MAIN)->delay(2);
            });
    }
}
