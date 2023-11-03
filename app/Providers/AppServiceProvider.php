<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(str_contains(config('app.url'), "https")) {
            URL::forceScheme("https");
        }

        Factory::guessFactoryNamesUsing(function ($name) {
            $className = class_basename($name);
            return "Database\Factories\\{$className}Factory";
        });
    }
}
