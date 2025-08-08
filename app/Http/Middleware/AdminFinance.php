<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminFinance
{
    public function handle(Request $request, Closure $next)
    {
        $role = auth()->user()->role_id ?? null;
        if ($role === 1 || $role === 2) {
            return $next($request);
        }
        abort(403, 'Akses ditolak');
    }
}