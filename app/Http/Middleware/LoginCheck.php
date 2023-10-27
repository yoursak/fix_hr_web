<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\admin\Login_Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMailer;
use Session;

class LoginCheck
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
        if (Session::get('business_id') != null && Session::get('user_type') != null) {
            return redirect('/login');
        } else {
            return $next($request);
        }
        // else if (Session::get('business_id') != null && Session::get('user_type') != null && Session::get('branch_id') != null) {
        //     return redirect('/login');
        // } 
    }
}