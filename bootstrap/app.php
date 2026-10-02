<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'staff/login',
            'staff/logout',
            'login',
            'logout',
        ]);

        $middleware->alias([
            'staff.role' => \App\Http\Middleware\StaffRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 419) {
                $request->session()->regenerateToken();

                if ($request->is('staff/*') || $request->is('admin/*') || $request->is('stock/*') || $request->routeIs('staff.*') || $request->routeIs('admin.*') || $request->routeIs('stock.*')) {
                    return redirect()->route('staff.login')
                        ->with('error', 'Your session expired or was reset. Please sign in again.')
                        ->withInput($request->except('Password', 'password', '_token'));
                }

                return redirect()->route('login')
                    ->with('error', 'Your session expired or was reset. Please sign in again.')
                    ->withInput($request->except('Password', 'password', '_token'));
            }
        });
    })->create();
