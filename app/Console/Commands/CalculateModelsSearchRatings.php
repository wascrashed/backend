<?php

namespace App\Console\Commands;

use App\Jobs\CalculateSearchRatings;
use Illuminate\Console\Command;

class CalculateModelsSearchRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:search-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates models search rating depends on their history';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new CalculateSearchRatings());
        $this->info('Successfully calculated');
    }
}
