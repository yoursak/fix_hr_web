<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use DB;
use App\Mail\AuthMailer;
use Illuminate\Support\Facades\Hash;

class CreateBusinessController extends Controller
{
    
    public function index(){
        // $permission  = array('View','Create','Update','Delete');
        // foreach ($permission as $key => $value) {
        //     dd($value);
        // }
        return view("auth.admin.registration");
    }

    public function otp(){
        return view("auth.admin.otp2");
    }

    public function create(){

        $businessCat = DB::table("business_categories_list")->get();
        $businessType = DB::table("business_type_list")->get();
        return view("auth.admin.business",compact("businessType","businessCat"));
    }

    public function verify(Request $request){

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
        ]);
        // Get the uploaded image file
        $image = $request->file('image');
        $path = public_path('business_logo/');
        $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
        $request->image->move($path, $imageName);

        
        if($request->has("email")){
            $otp = rand(100000, 999999);
            $details = [
                'name' => 'User',
                'title' => 'OTP Genrated',
                'body' => ' Your FixHR Business Registration one time PIN is: ' . "$otp",
            ];
            $sendMail = Mail::to($request->email)->send(new AuthMailer($details));
    
            if (isset($sendMail)) {

                $request->session()->put('firstEmail', $request->email);
                $business = DB::table("pending_admins")->insert([
                    "emp_email"=> $request->email,
                    'otp'=> $otp
                ]);
                if ($business) {
                    return redirect("signup/otp")->with("success","");
                }
            }
        }elseif ($request->has("otp")) {
            $pending = DB::table("pending_admins")->where([
                "emp_email"=>$request->session()->get('firstEmail'),
                'otp'=> $request->otp
            ])->first();

            // dd($pending);
            if (isset($pending)) {
                return redirect("signup/create")->with("success","");
            }else {
                $request->session()->flash('top');
                return back();
            }
        }elseif ($request->has("bname")) {
            // dd($request->all());


            $business_id = md5($request->name.$request->bname.$request->gst);
            $created = DB::table("business_details_list")->insert([
                "business_id"=> $business_id,
                "business_categories"=> $request->businessCategory,
                "business_type"=> $request->businessType,
                "client_name"=> $request->name,
                "business_email"=> Session()->get('firstEmail'),
                "business_name"=> $request->bname,
                "business_logo"=>  $imageName,
                "mobile_no"=> $request->phone,
                "country"=> $request->country,
                "state"=> $request->state,
                "city"=> $request->city,
                "pin_code"=> $request->pin,
                "gstnumber"=> $request->gst,
                "business_address"=> $request->address,
            ]);

            $admin = DB::table("login_admin")->insert([
                "user"=> 'Owner',
                "business_id"=> $business_id,
                "name"=> $request->name,
                "email"=> $request->Session()->get('firstEmail'),
                "country_code"=> '+91',
                'phone'=> $request->phone,
            ]);

            $emp = DB::table('employee_personal_details')->insert([
                'business_id' => $business_id,
                'employee_type' => 1,
                'emp_name' => $request->name,
                'emp_id' => $request->bname[0].$request->bname[1].'001',
                'emp_mobile_number' => $request->phone,
                'emp_email' => Session()->get('firstEmail'),
            ]);

            $loginEmp = DB::table('login_employee')->insert([
                'emp_id' => $request->bname[0].$request->bname[1].'001',
                'business_id' => $business_id,
                'name' => $request->name,
                'email' => Session()->get('firstEmail'),
                'country_code'=> '+91',
                'phone' => $request->mobile_number,
            ]);

            //Creting Permissions
            $modules = DB::table('sidebar_menu')->get();
            $permission  = array('View','Create','Update','Delete');

            foreach ($modules as $key => $module) {
                $i = 0;
                foreach ($permission as $key => $value) {
                    $addPermit = DB::table('permissions')->insert([
                        'name'=> $permission[$i++],
                        'description'=> $request->bname,
                        'module_id'=> $module->menu_id,
                        'business_id'=> $business_id,
                    ]);
                }
            }

            if ($addPermit) {
                foreach ($modules as $key => $Module) {
                    $j = 0;
                    foreach ($permission as $key => $permit) {
                        $assignPermit = DB::table('model_has_permissions')->insert([
                            'model_id'=> $request->bname[0].$request->bname[1].'001',
                            'module_id'=> $Module->menu_id,
                            'model_type'=> 'Owner',
                            'permission_name'=> $Module->menu_name.'.'.$permit,
                            'business_id'=> $business_id,
                        ]);
                    }
                }
            }

            $pending = DB::table('pending_admins')->where('emp_email',Session()->get('firstEmail'))->delete();

            if ($created && $admin && $pending && $emp) {
                return redirect("/admin")->with("success","");
            }
        }else {
            return back();
        }
    }
}
