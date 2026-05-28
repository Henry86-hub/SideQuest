<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'You must sign in at the Guild Board first!');
        }

        $userRole = $request->user()->role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Dark fantasy-themed unauthorized response
        abort(403, 'HALT! You do not have the required rank (' . implode(', ', array_map('ucfirst', $roles)) . ') to enter this section of the Guild.');
    }
}
