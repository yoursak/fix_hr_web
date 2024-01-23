<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use DB;
use App\Mail\AuthMailer;
use Illuminate\Support\Facades\Hash;
use Session;
use RealRashid\SweetAlert\Facades\Alert;

class CreateBusinessController extends Controller
{

    public function index()
    {
        // $permission  = array('View','Create','Update','Delete');
        // foreach ($permission as $key => $value) {
        //     dd($value);
        // }


        return view("auth.admin.registration");
        // }
    }

    public function otp()
    {

        return view("auth.admin.otp2");
    }

    public function create()
    {

        $businessCat = DB::table("static_business_categories_list")->get();
        $businessType = DB::table("static_business_type_list")->get();
        return view("auth.admin.business", compact("businessType", "businessCat"));
    }

    public function verify(Request $request)
    {



        if ($request->has("email")) {
            $otp = rand(100000, 999999);
            $details = [
                'name' => 'User',
                'title' => 'OTP Genrated',
                'body' => ' Your FixHR Business Registration one time PIN is: ' . "$otp",
            ];
            $sendMail = Mail::to($request->email)->send(new AuthMailer($details));
            // isset($sendMail)
            if (isset($sendMail)) {

                $request->session()->put('firstEmail', $request->email);
                $business = DB::table("pending_admins")->insert([
                    "emp_email" => $request->email,
                    'otp' => $otp
                ]);
                if ($business) {
                    $load = DB::table('business_details_list')->where('business_email', Session::get('firstEmail'))->first();
                    if (isset($load)) {
                        Alert::warning('', 'Email is Found Kindly Register New Your Business  Email');
                        return redirect("signup");
                    } else {
                        Alert::success('', 'Otp has been Send Successfully to Your Register Email');
                        return redirect("signup/otp");
                    }
                }
            }
        } else if ($request->has("otp")) {
            $pending = DB::table("pending_admins")->where([
                "emp_email" => $request->session()->get('firstEmail'),
                'otp' => $request->otp
            ])->first();

            // dd($pending);
            if (isset($pending)) {
                // Alert::success('', '');

                return redirect("signup/create");
            } else {
                $request->session()->flash('top');
                return back();
                // return redirect("signup");
                // return redirect("signup/otp");


            }
        } elseif ($request->has("bname")) {

            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                // Adjust max size as needed
            ]);
            // Get the uploaded image file
            $image = $request->file('image');
            $path = public_path('business_logo/');
            $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
            $request->image->move($path, $imageName);

            $business_id = md5($request->name . $request->bname . $request->gst);
            $created = DB::table("business_details_list")->insert([
                "business_id" => $business_id,
                "call_back_id" => rand(10000, 99999),
                "business_logo" => $imageName,
                "business_categories" => $request->businessCategory,
                "client_name" => $request->name,
                "business_email" => Session()->get('firstEmail'),
                "business_name" => $request->bname,
                "business_type" => $request->businessType,
                "mobile_no" => $request->phone,
                "city" => $request->city,
                "state" => $request->state,
                "country" => $request->country,
                "business_address" => $request->address,
                "pin_code" => $request->pin,
                "gstnumber" => $request->gst,
            ]);

            $admin = DB::table("login_admin")->insert([
                "business_id" => $business_id,
                "name" => $request->name,
                "email" => $request->Session()->get('firstEmail'),
                "country_code" => '+91',
                'phone' => $request->phone,
            ]);

            // Creating Roles & Permissions
            $modules = DB::table('static_sidebar_menu')->get();
            $permission = array('All','View', 'Create', 'Update', 'Delete');

            foreach ($modules as $key => $module) {
                $i = 0;
                foreach ($permission as $key => $value) {
                    $addPermit = DB::table('permissions')->insert([
                        'name' => $permission[$i++],
                        'description' => $request->bname,
                        'module_id' => $module->menu_id,
                        'business_id' => $business_id,
                    ]);
                }
            }

            if ($addPermit) {
                foreach ($modules as $key => $Module) {
                    $j = 0;
                    foreach ($permission as $key => $permit) {
                        $assignPermit = DB::table('model_has_permissions')->insert([
                            'model_id' => $request->bname[0] . $request->bname[1] . '001',
                            'module_id' => $Module->menu_id,
                            'model_type' => '0',
                            'permission_name' => $Module->menu_name . '.' . $permit,
                            'business_id' => $business_id,
                        ]);
                    }
                }
            }

            $pending = DB::table('pending_admins')->where('emp_email', Session()->get('firstEmail'))->delete();
            if (isset($created)) {
                Alert::success('', "Create Successfully Business \n Now Your Business account Created");

                return redirect('/login');
            } else {

                Alert::info('', "Not Create Business \n Please Check Your Details!");
                return back();
            }
            // return redirect('/');
        } else {

            return back();
        }
    }
}
