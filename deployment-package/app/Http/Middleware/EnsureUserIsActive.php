<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->is_active) {
            Auth::logout();

            if ($request->expectsJson()) {
                abort(423, 'Account is inactive');
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been deactivated. Contact an administrator.',
            ]);
        }

        return $next($request);
    }
}
