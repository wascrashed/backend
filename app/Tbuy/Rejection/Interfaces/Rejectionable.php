<?php

namespace App\Tbuy\Rejection\Interfaces;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Rejectionable extends Arrayable
{
    public function rejections(): MorphMany;
}
