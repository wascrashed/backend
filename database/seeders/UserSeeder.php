<?php

namespace Database\Seeders;

use App\Tbuy\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Overtrue\LaravelFavorite\Favorite;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)
            ->has($this->favoriteFactory(10),'favorites')
            ->create();
    }

    private function favoriteFactory(mixed $count = null, array $state = []): Factory
    {
        $factory = Factory::factoryForModel(Favorite::class);

        return $factory
            ->count(is_numeric($count) ? $count : null)
            ->state(is_callable($count) || is_array($count) ? $count : $state);

    }
}
