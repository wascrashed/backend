<?php

namespace App\Jobs;

use App\Contracts\SearchRatingableContract;
use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Models\Company;
use App\Traits\SearchRatingable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateSearchRatings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $models = [];

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->models = config('search-ratings.models');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->models as $model) {
            /**
             * @var SearchRatingable $model
             */
            if ((new $model()) instanceof SearchRatingableContract) {
                foreach ($model::query()->cursor() as $item) {
                    $rating = $item->calculateSearchRating();

                    $item->searchRating()->updateOrCreate([], ['rating' => $rating]);
                }
            }
        }
    }
}
