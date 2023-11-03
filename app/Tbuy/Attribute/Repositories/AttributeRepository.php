<?php

namespace App\Tbuy\Attribute\Repositories;

use App\Tbuy\Attribute\DTOs\AttributeDTO;
use App\Tbuy\Attribute\Models\Attribute;
use Illuminate\Database\Eloquent\Collection;

interface AttributeRepository
{
    public function get(): Collection;

    public function findById(int $attribute_id): Attribute;

    public function create(AttributeDTO $payload): Attribute;

    public function update(Attribute $attribute, AttributeDTO $payload): Attribute;

    public function delete(Attribute $attribute): void;
}
