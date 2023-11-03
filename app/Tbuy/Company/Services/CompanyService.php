<?php

namespace App\Tbuy\Company\Services;

use App\Tbuy\Company\DTOs\CompanyClientDTO;
use App\Tbuy\Company\DTOs\CompanyDataConfirmationDTO;
use App\Tbuy\Company\DTOs\CompanyDTO;
use App\Tbuy\Company\DTOs\CompanyFilterDTO;
use App\Tbuy\Company\DTOs\CompanyStatusDTO;
use App\Tbuy\Company\DTOs\CompanyUpdateDTO;
use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyService
{
    public function get(CompanyFilterDTO $filters): Collection;

    public function store(CompanyDTO $dto): Company;

    public function update(Company $company, CompanyUpdateDTO $dto): Company;

    public function delete(Company $company): bool;

    public function toggleStatus(Company $company, CompanyStatusDTO $payload): Company;

    public function clientUpdate(Company $company, CompanyClientDTO $payload): Company;

    public function getAuthCompany(): Company;

    public function score(Company $company, ?int $score): Company;

    public function getEmployees(Company $company): Collection;

    public function dataConfirmationCompany(Company $company, CompanyDataConfirmationDTO $payload): Company;
}
