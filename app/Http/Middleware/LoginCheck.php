<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\login;

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
        // dd($request->otp);
        $check_otp = login::where('otp', $request->otp)->first();
        $User = login::where('email', $request->email)->first();
        // dd($User);
        if($User){
            $otp = rand(100000, 999999);
            $User->update(['otp' => $otp]);
<<<<<<< Updated upstream
            session()->put('user',$User);
=======
            // session()->put('user',$User);
>>>>>>> Stashed changes
            return $next($request);
        }elseif($check_otp) {
            return $next($request);
        }else{
            session()->flash('Fail', 'You had entered wrong Credential....!!');
            return redirect('/');
        }
    }
}
