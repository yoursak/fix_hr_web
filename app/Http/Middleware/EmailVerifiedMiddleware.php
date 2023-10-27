<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\Login_Admin;
use Illuminate\Support\Facades\Session;

class EmailVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // if (Session::get('business_id') != null && Session::get('user_type') != null) {
        // Session::put('business_id', 'e3d64177e51bdff82b499e116796fe74');
        // Session::put('user_type', 'onwer');
        if (Session::has('business_id') && Session::has('user_type')) {
            // print_r(Session::all());
            return $next($request);
        } else {
            return redirect('/login');
        }
        // if (Session::get('business_id')) {
        //     return $next($request);
        // } else {
        //     return redirect('/login');
        // }
    }
}