<?php

namespace App\Jobs;

use App\Tbuy\AttributeValue\Models\AttributeValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AttributeValueImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected readonly Collection $attributeValues
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $date = now()->toDateTimeString();

        $forInsert = $this->attributeValues->map(function ($value) use ($date) {
            return [
                'name' => [
                    'ru' => $value->filtr_name_ru,
                    'en' => $value->filtr_name_en,
                    'hy' => $value->filtr_name_am
                ],
                'attribute_id' => $value->main_filtr_id,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        })->toArray();

        AttributeValue::query()->insert($forInsert);
    }
}
