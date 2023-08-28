<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\admin\Login_Admin;

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
        if ($request->session()->has('business_id')) {
            return redirect('/admin');
        }
        $check_otp = Login_Admin::where('otp', $request->otp)->first();
        $User = Login_Admin::where('email', $request->email)->first();
        if ($User) {
            // dd($User);
            $otp = rand(100000, 999999);
            $User->update(['otp' => $otp]);
            $request->session()->put('business_id', $User->business_id);
            $request->session()->put('login_role', $User->user);
            $request->session()->put('login_name', $User->name);
            $request->session()->put('login_email', $User->email);
            return $next($request);
        } elseif ($check_otp) {
            return $next($request);
        } else {
            session()->flash('Fail', 'You had entered wrong Credential....!!');
            return redirect('/login');
        }

    }
}