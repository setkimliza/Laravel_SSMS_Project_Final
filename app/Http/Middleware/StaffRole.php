<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('staff.login')->with('error', 'Please log in to continue.');
        }

        $staff = Auth::guard('staff')->user();

        // If specific roles are passed, verify staff has at least one of them
        if (!empty($roles)) {
            $allowed = array_map('strtolower', $roles);
            if (!in_array(strtolower($staff->Role), $allowed)) {
                abort(403, 'Unauthorized access: You do not have permission to view this resource.');
            }
        }

        return $next($request);
    }
}
