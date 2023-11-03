<?php

namespace Database\Factories;

use App\Tbuy\Community\Models\Community;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\DTOs\CoordinateDTO;
use App\Tbuy\Filial\DTOs\ScheduleDTO;
use App\Tbuy\Filial\Enums\WorkDay;
use App\Tbuy\Filial\Models\Filial;
use App\Tbuy\Region\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Filial>
 */
class FilialFactory extends Factory
{
    protected $model = Filial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'ru' => $this->faker->word,
                'en' => $this->faker->word,
                'hy' => $this->faker->word
            ],
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'coordinates' => new CoordinateDTO(...$this->faker->localCoordinates),
            'schedule' => [
                new ScheduleDTO("9:00", "18:00", WorkDay::MONDAY),
                new ScheduleDTO("9:00", "18:00", WorkDay::TUESDAY),
                new ScheduleDTO("9:00", "18:00", WorkDay::WEDNESDAY),
                new ScheduleDTO("9:00", "18:00", WorkDay::THURSDAY),
                new ScheduleDTO("9:00", "18:00", WorkDay::FRIDAY),
                new ScheduleDTO("9:00", "16:00", WorkDay::SATURDAY),
            ],
            'is_main' => $this->faker->boolean(10),
            'company_id' => Company::query()->inRandomOrder()->first()->id,
            'region_id' => Region::query()->inRandomOrder()->first()->id,
            'community_id' => Community::query()->inRandomOrder()->first()->id
        ];
    }
}
