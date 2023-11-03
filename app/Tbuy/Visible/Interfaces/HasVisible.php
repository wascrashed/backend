<?php

namespace App\Tbuy\Visible\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface HasVisible
{
    public function visibleFields(): MorphOne;
}
