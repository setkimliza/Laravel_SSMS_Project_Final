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
        return view('auth.staff-login');
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
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome, Administrator ' . $staff->UserName . '!');
            } else {
                return redirect()->intended(route('stock.dashboard'))->with('success', 'Welcome, Stock Controller ' . $staff->UserName . '!');
            }
        }

        return back()->withErrors([
            'UserName' => 'Invalid staff username or password.',
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

        return redirect()->route('staff.login')->with('info', 'Staff session signed out.');
    }
}
