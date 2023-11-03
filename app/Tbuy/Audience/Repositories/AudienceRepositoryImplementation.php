<?php

namespace App\Tbuy\Audience\Repositories;

use App\Tbuy\Audience\DTOs\AudienceDTO;
use App\Tbuy\Audience\Models\Audience;
use Illuminate\Database\Eloquent\Collection;

class AudienceRepositoryImplementation implements AudienceRepository
{
    public function get(): Collection
    {
        return Audience::query()
            ->with(['company', 'country', 'region'])
            ->get();
    }

    public function create(AudienceDTO $dto): Audience
    {
        $audience = new Audience([
            'company_id' => $dto->company_id,
            'country_id' => $dto->country_id,
            'region_id' => $dto->region_id,
            'gender' => $dto->gender,
            'age' => $dto->age,
        ]);
        $audience = $this->addTranslations($dto, $audience);
        $audience->save();

        return $audience->load(['company', 'country', 'region']);
    }

    public function show(Audience $audience): Audience
    {
        return $audience->load(['company', 'country', 'region']);
    }

    public function update(AudienceDTO $dto, Audience $audience): Audience
    {
        $audience->fill([
            'country_id' => $dto->country_id,
            'company_id' => $dto->company_id,
            'region_id' => $dto->region_id,
            'gender' => $dto->gender,
            'age' => $dto->age,
        ]);
        $audience = $this->addTranslations($dto, $audience);
        $audience->save();

        return $audience->load(['company', 'country', 'region']);
    }

    public function delete(Audience $audience): void
    {
        $audience->delete();
    }

    private function addTranslations(AudienceDTO $dto, Audience $audience): Audience
    {
        return $audience->setTranslations('name', $dto->name);
    }
}
