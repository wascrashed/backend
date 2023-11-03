<?php

namespace App\Tbuy\User\Services;

use App\Tbuy\User\DTOs\UserDTO;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserService
{
    public function get(): Collection;

    public function store(UserDTO $dto): User;

    public function update(User $user, UserDTO $payload): User;

    public function delete(User $user): void;

    public function findByEmail(string $email): User;

    public function expendBalance(User $user, float|int $price): User;
}
