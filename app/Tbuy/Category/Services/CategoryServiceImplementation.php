<?php

namespace App\Tbuy\Category\Services;

use App\Tbuy\Category\DTOs\CategoryDTO;
use App\Tbuy\Category\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Tbuy\Purchase\Models\ProductPurchase;

class CategoryServiceImplementation implements CategoryService
{
    public function get(): Collection
    {
        return Category::all();
    }

    public function store(CategoryDTO $dto): Category
    {
        return Category::create($dto->toArray());
    }

    public function update(Category $category, CategoryDTO $dto): Category
    {
        $category->fill($dto->toArray());
        $category->save();

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    public function getChildLevel(Category $category): int
    {
        $category = $category->loadMissing('grandParent');

        return $this->incrementRatio($category->grandParent, 1);
    }

    private function incrementRatio(?Category $grandParent, int $ratio): int
    {
        if (!$grandParent) {
            return $ratio;
        }

        return $this->incrementRatio($grandParent->grandParent, $ratio + 1);
    }
}
