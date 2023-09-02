<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return true;
        // Check the login token here.
        $token = $request->header('Authorization');
        return $token;
        $check = DB::table('login_admin')->where('api_token'.'='.$token)
        if ($check) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);

    }
}
