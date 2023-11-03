<?php

namespace App\Contracts;

interface SearchableContract
{
    public function searchableAs(): string;

    public function toSearchableArray(): array;
}
