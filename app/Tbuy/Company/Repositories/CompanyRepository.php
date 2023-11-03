<?php

namespace App\Tbuy\Company\Repositories;

use App\DTOs\BaseDTO;
use App\Tbuy\Company\DTOs\CompanyDataConfirmationDTO;
use App\Tbuy\Company\DTOs\CompanyDTO;
use App\Tbuy\Company\DTOs\CompanyFilterDTO;
use App\Tbuy\Company\DTOs\CompanyStatusDTO;
use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepository
{
    public function get(CompanyFilterDTO $payload): Collection;

    public function create(CompanyDTO $payload): Company;

    public function update(Company $company, BaseDTO $payload): Company;

    public function delete(Company $company): bool;

    public function setStatus(Company $company, CompanyStatusDTO $payload): Company;

    public function getById(int $companyId): Company;

    public function purchasesRefunds(Company $company): float|int;

    public function score(Company $company, ?int $score): Company;

    public function getEmployeesByCompany(Company $company): Collection;

    public function updateFieldsDataConfirmation(Company $company, CompanyDataConfirmationDTO $payload): Company;
}
