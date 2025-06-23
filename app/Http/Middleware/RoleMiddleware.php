<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Allow if role matches any of the allowed roles
        if (in_array($user->role->name, $roles)) {
            return $next($request);
        }

        Log::warning('RoleMiddleware blocked access', [
            'user' => $user->email,
            'role' => $user->role->name,
            'allowed' => $roles
        ]);

        abort(403, 'Unauthorized');
    }

}
