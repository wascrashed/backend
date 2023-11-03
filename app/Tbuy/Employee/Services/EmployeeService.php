<?php

namespace App\Tbuy\Employee\Services;

use App\Tbuy\Employee\DTOs\EmployeeDTO;
use App\Tbuy\Employee\DTOs\EmployeeFilterDTO;
use App\Tbuy\Employee\DTOs\EmployeeLoginDTO;
use App\Tbuy\Employee\Models\CompanyEmployee;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeService
{
    public function list(EmployeeFilterDTO $dto): Collection;

    public function create(EmployeeDTO $dto): CompanyEmployee;

    public function update(CompanyEmployee $employee, EmployeeDTO $dto): CompanyEmployee;

    public function delete(CompanyEmployee $employee): void;

    public function loadRelations(CompanyEmployee $employee): CompanyEmployee;

    public function login(EmployeeLoginDTO $dto): CompanyEmployee|null;
}
