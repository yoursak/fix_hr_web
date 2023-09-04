<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ApiLoginCheck
{
    /**ssss
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    use HasApiTokens;
    public function handle(Request $request, Closure $next)
    {
     
        // Check the login token here.
        $token = $request->header('Authorization');
        $accept = $request->header('Accept');
        $check = DB::table('login_admin')->where('api_token','=',$token)->first();
        if ($check && $accept) {
         
            return $next($request);
        }else{
        return response()->json(['error' => 'Unauthorized'], 401);
        }

    }
}
