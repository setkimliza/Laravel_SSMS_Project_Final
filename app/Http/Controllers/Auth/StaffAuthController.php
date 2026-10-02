<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
    /**
     * Show staff login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('staff')->check()) {
            $staff = Auth::guard('staff')->user();
            return $staff->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('stock.dashboard');
        }
        return response()
            ->view('auth.staff-login')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }

    /**
     * Handle staff login attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'UserName' => ['required', 'string'],
            'Password' => ['required', 'string'],
        ]);

        if (Auth::guard('staff')->attempt(['UserName' => $credentials['UserName'], 'password' => $credentials['Password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $staff = Auth::guard('staff')->user();

            if ($staff->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome, Administrator ' . $staff->UserName . '!');
            } else {
                return redirect()->route('stock.dashboard')->with('success', 'Welcome, Stock Controller ' . $staff->UserName . '!');
            }
        }

        return back()->with('error', 'Incorrect credentials entered. Default credentials are — Admin: "admin" (Password: 123) or Stock: "stock" (Password: 123).')
            ->withErrors([
                'UserName' => 'Invalid username or password. Valid accounts: admin / 123 or stock / 123.',
            ])->onlyInput('UserName');
    }

    /**
     * Log staff member out.
     */
    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('staff.login')
            ->with('info', 'Staff session signed out.')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }
}
