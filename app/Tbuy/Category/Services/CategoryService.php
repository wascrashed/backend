<?php

namespace App\Tbuy\Category\Services;

use App\Tbuy\Category\DTOs\CategoryDTO;
use App\Tbuy\Category\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryService
{
    public function get(): Collection;

    public function store(CategoryDTO $dto): Category;

    public function update(Category $category, CategoryDTO $dto): Category;

    public function delete(Category $category): void;

    public function getChildLevel(Category $category): int;
}
