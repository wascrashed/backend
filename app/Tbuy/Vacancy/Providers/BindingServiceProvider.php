<?php

namespace App\Tbuy\Vacancy\Providers;

use App\Tbuy\Vacancy\Repositories\VacancyCategory\VacancyCategoryRepository;
use App\Tbuy\Vacancy\Repositories\VacancyCategory\VacancyCategoryRepositoryImplementation;
use App\Tbuy\Vacancy\Repositories\VacancyRepository;
use App\Tbuy\Vacancy\Repositories\VacancyRepositoryImplementation;
use App\Tbuy\Vacancy\Services\VacancyCategory\VacancyCategoryService;
use App\Tbuy\Vacancy\Services\VacancyCategory\VacancyCategoryServiceImplementation;
use App\Tbuy\Vacancy\Services\VacancyService;
use App\Tbuy\Vacancy\Services\VacancyServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(VacancyRepository::class, VacancyRepositoryImplementation::class);
        $this->app->bind(VacancyService::class, VacancyServiceImplementation::class);

        $this->app->bind(VacancyCategoryRepository::class, VacancyCategoryRepositoryImplementation::class);
        $this->app->bind(VacancyCategoryService::class, VacancyCategoryServiceImplementation::class);
    }

    public function boot(): void
    {
    }
}
