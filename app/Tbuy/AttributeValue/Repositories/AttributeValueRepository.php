<?php

namespace App\Tbuy\AttributeValue\Repositories;

use App\Tbuy\AttributeValue\DTOs\AttributeValueDTO;
use App\Tbuy\AttributeValue\Models\AttributeValue;

interface AttributeValueRepository
{
    public function create(AttributeValueDTO $payload): AttributeValue;

    public function update(AttributeValue $attributeValue, AttributeValueDTO $payload): AttributeValue;

    public function delete(AttributeValue $attributeValue): ?bool;
}
