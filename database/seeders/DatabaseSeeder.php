<?php

namespace Database\Seeders;

use App\Tbuy\Banner\Models\Banner;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!app()->environment('production')) {
            $this->call(CommunitySeeder::class);
            $this->call(RegionSeeder::class);
            $this->call(ReasonSeeder::class);
            $this->call(AttributeSeeder::class);
            $this->call(CategorySeeder::class);
        }
        $this->call([
            ProductModerationMenuSeeder::class,
            MenuSeeder::class,
            ModelListSeeder::class,
            ModelFieldSeeder::class,
            ModelFieldReferenceSeeder::class,
            CountrySeeder::class,
            TariffSeeder::class,
            SearchableModelSeeder::class,
            SearchableFieldSeeder::class

        ]);
        if (!app()->environment('production')) {
            $this->call(CompanySeeder::class);
            $this->call(CompanyEmployeeSeeder::class);
            $this->call(BrandSeeder::class);
            $this->call(ProductSeeder::class);
            $this->call(VacancySeeder::class);
            $this->call(PurchaseSeeder::class);
            $this->call(RefundSeeder::class);
            $this->call(BankSeeder::class);
            $this->call(CreditApplicationSeeder::class);
            $this->call(TariffLogSeeder::class);
            $this->call(SocialEntrySeeder::class);
            $this->call(GradeSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(BankRatingHistorySeeder::class);
            $this->call(PromotionSeeder::class);
            $this->call(BasketSeeder::class);
            $this->call(CommentSeeder::class);
            $this->call(AudienceSeeder::class);
            $this->call(BannerSeeder::class);
            $this->call(TargetSeeder::class);
            $this->call(TemplatesSeeder::class);
        }

    }
}
