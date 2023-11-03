<?php

namespace Database\Factories;

use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Comment\Models\Comment;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $commentableModel = $this->faker->randomElement([Product::class, Company::class, Brand::class, Bank::class]);

        $commentable = $commentableModel::query()->inRandomOrder()->first();

        return [
            'commentable_id' => $commentable->id,
            'commentable_type' => $commentableModel,
            'user_id' => User::query()->inRandomOrder()->first()?->id,
            'content' => $this->faker->paragraph,
        ];
    }
}
