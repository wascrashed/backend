<?php

namespace App\Tbuy\Employee\Providers;

use App\Tbuy\Attribute\Providers\ServiceProvider;
use App\Tbuy\Employee\Repositories\EmployeeRepository;
use App\Tbuy\Employee\Repositories\EmployeeRepositoryImplementation;
use App\Tbuy\Employee\Services\EmployeeService;
use App\Tbuy\Employee\Services\EmployeeServiceImplementation;

class BindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EmployeeService::class, EmployeeServiceImplementation::class);
        $this->app->bind(EmployeeRepository::class, EmployeeRepositoryImplementation::class);
    }
}
