<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * @param  string  $roles  Comma separated list of role names allowed
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        $allowed = collect(explode(',', $roles))
            ->map(fn ($role) => trim($role))
            ->filter()
            ->all();

        if (! $user->hasRole(...$allowed)) {
            abort(403);
        }

        return $next($request);
    }
}
