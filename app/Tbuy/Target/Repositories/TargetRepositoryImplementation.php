<?php

namespace App\Tbuy\Target\Repositories;

use App\Tbuy\Target\DTOs\TargetDTO;
use App\Tbuy\Target\DTOs\TargetStatusDTO;
use App\Tbuy\Target\Enums\Status;
use App\Tbuy\Target\Enums\Targetable;
use App\Tbuy\Target\Models\Target;
use Illuminate\Database\Eloquent\Collection;

class TargetRepositoryImplementation implements TargetRepository
{
    public function get(): Collection
    {
        return Target::query()
            ->with(['audience', 'targetable'])
            ->get();
    }

    public function create(TargetDTO $dto): Target
    {
        $target = new Target([
            'audience_id' => $dto->audience_id,
            'targetable_type' => $this->getTargetableValue($dto->targetable_type),
            'targetable_id' => $dto->targetable_id,
            'link' => $dto->link,
            'duration' => $dto->duration,
            'status' => Status::NEW,
            'started_at' => $dto->started_at,
            'finished_at' => $dto->finished_at
        ]);
        $target = $this->addTranslations($dto, $target);
        $target->save();

        return $target->load(['audience', 'targetable']);
    }

    public function show(Target $target): Target
    {
        return $target->load(['audience', 'targetable']);
    }

    public function update(TargetDTO $dto, Target $target): Target
    {
        $target->fill([
            'audience_id' => $dto->audience_id,
            'targetable_type' => $this->getTargetableValue($dto->targetable_type),
            'targetable_id' => $dto->targetable_id,
            'link' => $dto->link,
            'duration' => $dto->duration,
            'started_at' => $dto->started_at,
            'finished_at' => $dto->finished_at
        ]);
        $target = $this->addTranslations($dto, $target);
        $target->save();

        return $target->load(['audience', 'targetable']);
    }

    public function delete(Target $target): void
    {
        $target->delete();
    }

    public function changeStatus(TargetStatusDTO $dto, Target $target): Target
    {
        $target->fill([
            'status' => $dto->status
        ]);
        $target->save();

        return $target->load(['audience', 'targetable']);
    }

    public function incrementViews(Target $target): void
    {
        $target->increment('views', 1);
        $target->save();
    }

    private function addTranslations(TargetDTO $dto, Target $target): Target
    {
        return $target->setTranslations('name', $dto->name);
    }

    private function getTargetableValue($type): string
    {
        $cases = Targetable::cases();
        $index = array_search($type, array_column($cases, 'name'));

        return $cases[$index]->value;
    }
}
