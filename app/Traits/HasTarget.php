<?php

namespace App\Traits;

use App\Tbuy\Target\Models\Target;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasTarget
{
    public function target(): MorphOne
    {
        return $this->morphOne(Target::class, 'targetable');
    }
}
