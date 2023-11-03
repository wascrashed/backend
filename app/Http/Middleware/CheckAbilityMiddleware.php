<?php

namespace App\Http\Middleware;

use App\Tbuy\User\Models\User;
use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckAbilityMiddleware
{
    public function handle($request, Closure $next, $permission, $guard = null)
    {
        $authGuard = app('auth')->guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {
            /** @var User $user */
            $user = $authGuard->user();
            if ($user->hasPermissionTo($permission, $guard)) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
