<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (! $user) {
            return redirect('/login');
        }

        if ($user->role !== 'admin') {
            abort(403, 'Forbidden - Admins only');
        }

        return $next($request);
    }
}
