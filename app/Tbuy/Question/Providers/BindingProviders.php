<?php

namespace App\Tbuy\Question\Providers;
 
use App\Tbuy\Question\Services\QuestionService;
use App\Tbuy\Question\Services\QuestionServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingProviders extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(QuestionService::class, QuestionServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

