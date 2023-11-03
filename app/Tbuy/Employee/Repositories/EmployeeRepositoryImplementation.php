<?php

namespace App\Tbuy\Employee\Repositories;

use App\Tbuy\Employee\DTOs\EmployeeDTO;
use App\Tbuy\Employee\DTOs\EmployeeFilterDTO;
use App\Tbuy\Employee\DTOs\EmployeeLoginDTO;
use App\Tbuy\Employee\Models\CompanyEmployee;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class EmployeeRepositoryImplementation implements EmployeeRepository
{

    public function list(EmployeeFilterDTO $dto): Collection
    {
        return CompanyEmployee::query()
            ->with('user')
            ->filter($dto->toArray())
            ->get();
    }

    public function create(User $user, EmployeeDTO $dto): CompanyEmployee
    {
        return CompanyEmployee::query()->create([
            'user_id' => $user->id,
            'company_id' => $dto->company_id,
            'username' => $dto->username,
            'password' => bcrypt($dto->password),
        ])->load('user');
    }

    public function update(User $user, CompanyEmployee $employee, EmployeeDTO $dto): CompanyEmployee
    {
        $employee->fill([
            'user_id' => $user->id,
            'company_id' => $dto->company_id,
            'username' => $dto->username
        ]);
        $employee->save();

        return $employee;
    }

    public function delete(CompanyEmployee $employee): void
    {
        $employee->delete();
    }

    public function loadRelations(CompanyEmployee $employee): CompanyEmployee
    {
        return $employee->load([
            'user',
            'company'
        ]);
    }

    public function login(EmployeeLoginDTO $dto): CompanyEmployee|null
    {
        return CompanyEmployee::query()
            ->where('company_id', $dto->company_id)
            ->whereHas('user', function (Builder $builder) use ($dto) {
                return $builder->where('users.email', $dto->email);
            })
            ->get()
            ->filter(function (CompanyEmployee $employee) use ($dto) {
                return Hash::check($dto->password, $employee->user->password);
            })
            ->first();
    }

    public function findByCompanyIdAndUserId(int $company_id, int $user_id): ?CompanyEmployee
    {
        return CompanyEmployee::query()
            ->where('company_id', '=', $company_id)
            ->where('user_id', '=', $user_id)
            ->first();
    }
}
