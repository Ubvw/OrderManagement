<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $roleList = explode(',', $roles);
        if (in_array($user->role->name, $roleList) || $user->role->name === 'Admin') {
            return $next($request);
        }

        abort(403);
    }
}
