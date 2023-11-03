<?php

namespace App\Tbuy\User\Services;

use App\Tbuy\User\DTOs\UserDTO;
use App\Tbuy\User\Enums\CacheKey;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserServiceImplementation implements UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function get(): Collection
    {
        return Cache::remember(CacheKey::USER_LIST->value, CacheKey::ttl(), function () {
            return $this->userRepository->get();
        });
    }

    public function store(UserDTO $dto): User
    {
        $user = $this->userRepository->store($dto);

        Cache::forget(CacheKey::USER_LIST->value);

        return $user;
    }

    public function update(User $user, UserDTO $payload): User
    {
        $user = $this->userRepository->update($user, $payload);

        Cache::forget(CacheKey::USER_LIST->value);

        return $user;
    }

    public function delete(User $user): void
    {
        $this->userRepository->delete($user);

        Cache::forget(CacheKey::USER_LIST->value);
    }

    public function findByEmail(string $email): User
    {
        /** @var User $user */
        $user = User::query()->where('email', $email)->firstOrFail();

        return $user;
    }

    public function expendBalance(User $user, float|int $price): User
    {
        $user->fill([
            'balance' => $user->balance - $price
        ]);
        $user->save();

        return $user;
    }
}
