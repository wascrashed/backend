<?php

namespace App\Tbuy\Attribute\Services;

use App\Tbuy\Attribute\DTOs\AttributeDTO;
use App\Tbuy\Attribute\Models\Attribute;
use Illuminate\Database\Eloquent\Collection;

interface AttributeService
{
    public function get(): Collection;

    public function create(AttributeDTO $payload): Attribute;

    public function update(Attribute $attribute, AttributeDTO $payload): Attribute;

    public function delete(Attribute $attribute): void;
}
