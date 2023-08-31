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

        // if(Session::has('business_id')){
        //     return redirect('/');
        // }else{
        //     if ($request->email) {
        //         $User = Login_Admin::where('email', $request->email)->first();
        //         if ($User) {
        //             $otp = rand(100000, 999999);
        //             $details = [
        //                 'name' => $User->name,
        //                 'title' => 'OTP Genrated',
        //                 'body' => ' Your FixHR Admin Login one time PIN is: ' . "$otp",
        //             ];
        //             $sendMail = Mail::to($request->email)->send(new AuthMailer($details));
    
        //             if ($sendMail) {
        //                 $User->update(['otp' => $otp]);
        //                 return $next($request);
        //             }
        //         }else{
        //             session()->flash('Fail', 'You had entered wrong Email....!!');
        //             return back();
        //         }
        //     }else if($request->otp) {
        //         $check_otp = Login_Admin::where('otp', $request->otp)->first();
        //         if (isset($check_otp)) {
        //             Session::put('business_id', $check_otp->business_id);
        //             Session::put('login_role', $check_otp->user);
        //             Session::put('login_name', $check_otp->name);
        //             Session::put('login_email', $check_otp->email);
        //         }
        //     }
        //     return $next($request);
        // }
    }
}