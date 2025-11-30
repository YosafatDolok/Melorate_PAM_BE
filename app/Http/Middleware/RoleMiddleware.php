<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role = 'admin')
    {
        // Check if user is logged in
        if (! $request->user()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        // Check role
        if ($role === 'admin' && $request->user()->role_id !== 1) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
