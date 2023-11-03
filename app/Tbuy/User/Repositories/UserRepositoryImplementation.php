<?php

namespace App\Tbuy\User\Repositories;

use App\Tbuy\MenuUserPermission\DTOs\MenuUserDTO;
use App\Tbuy\User\DTOs\ChangePasswordDTO;
use App\Tbuy\User\Exceptions\UserNotFoundException;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\DTOs\UserDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImplementation implements UserRepository
{
    /**
     * @throws UserNotFoundException
     */
     public function get(): Collection
    {
        return User::all();
    }

    public function store(UserDTO $dto): User
    {
        $user = new User();
        // Заполните модель User данными из DTO $dto
        $user->name = $dto->name;
        $user->email = $dto->email;
        $user->password = bcrypt($dto->password); // Сохраните хэшированный пароль
        // Сохраните модель User в базе данных
        $user->save();

        return $user;
    }

    public function update(User $user, UserDTO $dto): User
    {
    // Обновите модель User данными из DTO $dto
    $user->name = $dto->name;
    $user->email = $dto->email;

    if (!empty($dto->password)) {
        $user->password = bcrypt($dto->password); // Обновите хэшированный пароль
    }

    // Сохраните модель User в базе данных
    $user->save();

    return $user;
}
    public function delete(User $user): void
    {
        // Удалите модель User из базы данных
        $user->delete();
    }
    public function setMenu(MenuUserDTO $payload): User
    {
        $user = $this->findById($payload->user_id);

        if (!$user) {
            throw new UserNotFoundException('User not found');
        }

        $user->menus()->sync($payload->menu);

        return $user;
    }

    public function findById(int $id): ?User
    {
        /** @var User $user */
        $user = User::query()->find($id);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        /** @var User $user */
        $user = User::query()->where('email', '=', $email)->first();

        return $user;
    }

    public function changePassword(User $user, ChangePasswordDTO $payload): bool
    {
        $user->password = Hash::make($payload->password);
        return $user->save();
    }
}
