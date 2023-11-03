<?php

namespace App\Tbuy\User\Repositories;

use App\Tbuy\User\DTOs\ChangePasswordDTO;
use App\Tbuy\User\DTOs\UserDTO;
use App\Tbuy\MenuUserPermission\DTOs\MenuUserDTO;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository
{
    public function get(): Collection;

    public function store(UserDTO $dto): User;

    public function update(User $user, UserDTO $dto): User;

    public function delete(User $user): void;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function setMenu(MenuUserDTO $payload): User;

    public function changePassword(User $user, ChangePasswordDTO $payload): bool;
}

