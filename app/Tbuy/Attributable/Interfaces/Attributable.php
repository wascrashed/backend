<?php

namespace App\Tbuy\Attributable\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Attributable
{
    public function attributesList(): MorphMany;
}
