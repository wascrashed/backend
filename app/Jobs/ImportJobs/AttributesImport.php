<?php

namespace App\Jobs\ImportJobs;

use App\Tbuy\Attribute\Models\Attribute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AttributesImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Collection $attributes
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

        $forInsert = $this->attributes->map(function ($attribute) use ($date) {
            return [
                'id' => $attribute->id,
                'name' => [
                    'ru' => $attribute->main_filter_name_ru,
                    'en' => $attribute->main_filter_name_en,
                    'hy' => $attribute->main_filter_name_am
                ],
                'created_at' => $date,
                'updated_at' => $date,
            ];
        })->toArray();

        Attribute::query()->insert($forInsert);
    }
}
