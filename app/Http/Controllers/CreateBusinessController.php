<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use DB;
use App\Mail\AuthMailer;
use Illuminate\Support\Facades\Hash;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\StaticCountryModel;

class CreateBusinessController extends Controller
{
    public function index()
    {
        // $permission  = array('View','Create','Update','Delete');
        // foreach ($permission as $key => $value) {
        //     dd($value);
        // }

        return view('auth.admin.registration');
        // }
    }

    public function otp()
    {
        return view('auth.admin.otp2');
    }

    public function create()
    {
        $businessCat = DB::table('static_business_categories_list')->get();
        $businessType = DB::table('static_business_type_list')->get();
        $country = StaticCountryModel::all();
        // dd($country);
        return view('auth.admin.business', compact('businessType', 'businessCat', 'country'));
    }

    public function getstate(Request $request)
    {
        $states = DB::table('static_states')
            ->where('country_id', $request->country)
            ->orderBy('Name')
            ->get();

        return response()->json(['states' => $states]);
    }

    public function getCity(Request $request)
    {
        $City = DB::table('static_cities')
            ->where('state_id', $request->state)
            ->orderBy('Name')
            ->get();

        return response()->json(['city' => $City]);
    }

    public function verify(Request $request)
    {
        if ($request->has('email')) {
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
                $business = DB::table('pending_admins')->insert([
                    'emp_email' => $request->email,
                    'otp' => $otp,
                ]);
                if ($business) {
                    $load = DB::table('business_details_list')
                        ->where('business_email', Session::get('firstEmail'))
                        ->first();
                    if (isset($load)) {
                        Alert::warning('', 'This Email is Already Registered Kindly Enter Your New Email');
                        return redirect('signup');
                    } else {
                        Session::put('Progress', $request->email);
                        Alert::success('', 'OTP has been Send Successfully to Your Register Email');
                        return redirect('signup/otp');
                    }
                }
            }
        } elseif ($request->has('otp')) {
            $pending = DB::table('pending_admins')
                ->where([
                    'emp_email' => $request->session()->get('firstEmail'),
                    'otp' => $request->otp,
                ])
                ->first();

            // dd($pending);
            if (isset($pending)) {
                Alert::success('', "Your OTP has been Verified Successfully");
                return redirect('signup/create');
            } else {
                $request->session()->flash('top');
                return back();
            }
        } elseif ($request->has('bname')) {
            // dd($request->all());
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
            $created = DB::table('business_details_list')->insert([
                'business_id' => $business_id,
                'login_type' => 1,
                'call_back_id' => rand(10000, 99999),
                'business_logo' => $imageName,
                'business_categories' => $request->businessCategory,
                'client_name' => $request->name,
                'business_email' => Session()->get('firstEmail'),
                'business_name' => $request->bname,
                'business_type' => $request->businessType,
                'mobile_no' => $request->phone,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'business_address' => $request->address,
                'pin_code' => $request->pin,
                'gstnumber' => $request->gst,
            ]);

            $admin = DB::table('login_admin')->insert([
                'business_id' => $business_id,
                'static_role' => 1,
                'name' => $request->name,
                'email' => $request->Session()->get('firstEmail'),
                'country_code' => '+91',
                'phone' => $request->phone,
            ]);

            // $attendanceMode = DB::table('policy_attendance_mode')->insert([
            //     "business_id" => $business_id,
            //     "office_auto" => '0',
            //     "office_manual" => '0',
            //     "office_qr" => '0',
            //     "office_face_id" => '0',
            //     "office_selfie" => '0',
            //     "outdoor_auto" => '0',
            //     "outdoor_manual" => '0',
            //     "outdoor_selfie" => '0',
            //     "wfh_auto" => '0',
            //     "wfh_manual" => '0',
            //     "wfh_selfie" => '0'
            // ]);
            // Creating Roles & Permissions
            $modules = DB::table('static_sidebar_menu')->get();
            $permission = ['All', 'View', 'Create', 'Update', 'Delete'];

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


            $request->session()->put('email', $request->Session()->get('firstEmail'));
            $request->session()->put('user_type', 'owner');
            $request->session()->put('business_id', $business_id);
            $request->session()->put('model_id',  $request->bname[0] . $request->bname[1] . '001');
            $request->session()->put('login_role', '1');
            $request->session()->put('login_name', $request->name);
            $request->session()->put('login_email', $request->Session()->get('firstEmail'));
            $request->session()->put('login_business_image', $imageName);
            $pending = DB::table('pending_admins')
                ->where('emp_email', Session()->get('firstEmail'))
                ->delete();
            if (isset($created)) {
                // dd(session()->all());
                Alert::success('', "Business Created Successfully \n Now Your Business account Created");
                // return redirect('/login');
                return redirect('/setup/dashboard');
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
