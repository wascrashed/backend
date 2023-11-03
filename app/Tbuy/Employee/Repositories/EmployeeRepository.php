<?php

namespace App\Tbuy\Employee\Repositories;

use App\Tbuy\Employee\DTOs\EmployeeDTO;
use App\Tbuy\Employee\DTOs\EmployeeFilterDTO;
use App\Tbuy\Employee\DTOs\EmployeeLoginDTO;
use App\Tbuy\Employee\Models\CompanyEmployee;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepository
{
    public function list(EmployeeFilterDTO $dto): Collection;

    public function create(User $user, EmployeeDTO $dto): CompanyEmployee;

    public function update(User $user, CompanyEmployee $employee, EmployeeDTO $dto): CompanyEmployee;

    public function delete(CompanyEmployee $employee): void;

    public function loadRelations(CompanyEmployee $employee): CompanyEmployee;

    public function login(EmployeeLoginDTO $dto): CompanyEmployee|null;

    public function findByCompanyIdAndUserId(int $company_id, int $user_id): ?CompanyEmployee;
}
