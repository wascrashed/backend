<?php

namespace App\Tbuy\AttributeValue\Repositories;

use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\AttributeValue\DTOs\AttributeValueDTO;
use App\Tbuy\AttributeValue\Models\AttributeValue;

class AttributeValueRepositoryImplementation implements AttributeValueRepository
{
    public function create(AttributeValueDTO $payload): AttributeValue
    {
        $attributeValue = new AttributeValue([
            'attribute_id' => $payload->attribute_id
        ]);
        $attributeValue = $this->addTranslation($attributeValue, $payload);

        $attributeValue->save();

        return $attributeValue;
    }

    public function update(AttributeValue $attributeValue, AttributeValueDTO $payload): AttributeValue
    {
        $attributeValue->fill([
            'attribute_id' => $payload->attribute_id,
        ]);
        $attributeValue = $this->addTranslation($attributeValue, $payload);

        $attributeValue->save();

        return $attributeValue;
    }

    public function delete(AttributeValue $attributeValue): ?bool
    {
        return $attributeValue->delete();
    }

    private function addTranslation(AttributeValue $attributeValue, AttributeValueDTO $payload): AttributeValue
    {
        $attributeValue->setTranslations('name', $payload->name);

        return $attributeValue;
    }
}
