<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $user = Auth::user();

        // Kalau user belum login, langsung tolak
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        
        // explode + trim + lowercase
        $roles = array_map(fn($r) => strtolower(trim($r)), explode('|', $roles));
        $userRole = strtolower($user->role ?? '');

        // debug cek isi
        \Log::info('Role middleware', [
            'route_roles' => $roles,
            'user_role'   => $userRole,
        ]);

        if (!$user || !in_array($userRole, $roles, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
