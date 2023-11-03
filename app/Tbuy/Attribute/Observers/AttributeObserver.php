<?php

namespace App\Tbuy\Attribute\Observers;

use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\AttributeValue\Models\AttributeValue;

class AttributeObserver
{
    public function deleting(Attribute $attribute): void
    {
        $attribute->values->each(fn(AttributeValue $value) => $value->delete());
    }
}
