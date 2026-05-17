<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        $roles = array_map('trim', explode(',', $role));

        if (! $user || (! $user->isAdmin() && ! in_array($user->role, $roles, true))) {
            abort(403);
        }

        return $next($request);
    }
}
