<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IsUserBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('username', ($request->input('username')))->first();
        if ($user && $user->banned){
            Auth::logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->back()->dangerBanner(
                __('Votre compte a été banni.'),
            );
        }
        return $next($request);
    }
}
