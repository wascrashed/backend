<?php

namespace Database\Seeders;

use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\CreditApplication\Enums\Status;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use Illuminate\Database\Seeder;

class CreditApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CreditApplication::factory(5)->create()->each(function (CreditApplication $credit) {
            $banks = Bank::query()->inRandomOrder()->take(random_int(1, 5))->get();
            foreach ($banks as $bank) {
                $statusKey = array_rand(Status::cases());
                $credit->banks()->attach($bank, [
                    'status' => Status::cases()[$statusKey]->value,
                    'sum' => $credit->requested_sum + random_int($credit->requested_sum * 0.1, $credit->requested_sum * 0.4),
                ]);
            }
        });
    }
}
