<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        // Allow Admin to access everything
        if ($user->role->name === 'Admin' || $user->role->name === $role) {
            return $next($request);
        }

        abort(403);
    }
}
