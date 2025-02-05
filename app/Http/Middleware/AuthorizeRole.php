<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Authentication required. Please log in to access this resource.',
            ], 401);
        }

        if ($request->user()->role !== $role) {
            return response()->json([
                'error' => 'Access denied. You do not have the required permissions to access this resource.',
            ], 403);
        }

        return $next($request);
    }
}
