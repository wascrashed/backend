<?php

namespace App\Tbuy\User\Services\Auth;

use App\Tbuy\User\DTOs\ChangePasswordDTO;
use App\Tbuy\User\DTOs\ForgotPasswordDTO;
use App\Tbuy\User\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

interface AuthService
{
    public function login($payload): User|null;

    public function logout(Request $request): void;

    public function create($payload): User;

    public function getAuthUser(): Authenticatable;

    public function changePassword(User $user, ChangePasswordDTO $payload): bool;

    public function forgotPassword(ForgotPasswordDTO $payload): bool;
}
