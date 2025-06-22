<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect('/home'); // Change '/home' to your preferred authenticated redirect path
            }
        }

        return $next($request);
    }
}
// This middleware checks if the user is authenticated and redirects them to a specified path if they are.
// You can customize the redirect path by changing the '/home' value in the return statement.
// This is useful for preventing authenticated users from accessing the login or registration pages.