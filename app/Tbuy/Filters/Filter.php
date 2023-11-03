<?php

namespace App\Tbuy\Filters;

abstract class Filter
{
    public function __construct(protected string|null $column = null)
    {
    }
}
