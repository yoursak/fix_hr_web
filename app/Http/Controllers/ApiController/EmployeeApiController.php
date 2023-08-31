<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\EmployeePersonalDetail;
use Illuminate\Support\Facades\DB;
use App\Helpers\ReturnHelpers;
use App\Http\Resources\Api\EmployeeResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Support\Facades\Validator;

use Validator;
// /Http/Resources/Api

class EmployeeApiController extends Controller
{
    public function index()
    {
        //     public function index()
        // {
        //     $data = CompanyDetail::all();
        //     return ReturnHelpers::jsonApiReturn(CompanyResource::collection($data)->all());
        // }
        $emp = EmployeePersonalDetail::all();
        if ($emp) {
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection($emp)->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_type' => 'required',
            'business_id' => 'required',
            'emp_name' => 'required',
            'emp_id' => 'required',
            'emp_mobile_number' => 'required',
            'emp_email' => 'required',
            'emp_branch' => 'required',
            'emp_department' => 'required',
            'emp_designation' => 'required',
            'emp_date_of_birth' => 'required',
            'emp_date_of_joining' => 'required',
            'emp_gender' => 'required',
            'emp_address' => 'required',
            'emp_country' => 'required',
            'emp_state' => 'required',
            'emp_city' => 'required',
            'emp_pin_code' => 'required',
            'profile_photo' => 'required',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->all();
            $response = [
                'status' => false,
                'message' => $errorMessage,
            ];
            return response()->json($response, 401);
        } else {
            if (
                EmployeePersonalDetail::where('emp_email', $request->email)
                    ->get()
                    ->first()
            ) {
                $data['msg'] = 'Email address already exists';
                return response()->json(['result' => [$data], 'status' => false]);
            } elseif (
                EmployeePersonalDetail::where('emp_mobile_number', $request->mobile_number)
                    ->get()
                    ->first()
            ) {
                $data['msg'] = 'Mobile number already exists';
                return response()->json(['result' => [$data], 'status' => false]);
            }
            $emp = new EmployeePersonalDetail();
            $emp->business_id = $request->business_id;
            $emp->branch_id = $request->branch_id;
            $emp->employee_type = $request->employee_type;
            $emp->emp_name = $request->emp_name;
            $emp->emp_id = $request->emp_id;
            $emp->emp_mobile_number = $request->mobile_number;
            $emp->emp_email = $request->email;
            $emp->emp_branch = $request->branch;
            $emp->emp_department = $request->department;
            $emp->emp_designation = $request->designation;
            $emp->emp_date_of_birth = $request->dob;
            $emp->emp_date_of_joining = $request->doj;
            $emp->emp_gender = $request->gender;
            $emp->emp_address = $request->address;
            $emp->emp_country = $request->country;
            $emp->emp_state = $request->state;
            $emp->emp_city = $request->city;
            $emp->emp_pin_code = $request->pin_code;
            $emp->profile_photo = $request->photo;
            // $emp->emp_department = $request->department;
            // $emp->emp_department = $request->department;
            if (true) {
                // $emp_unique_id = '';
                // $data = CompanyDetail::where('emp_unique_id','!=','')->orWhere('emp_unique_id','!=',null)->where('emp_id',$emp->emp_id)->get()->last();
                // if(isset($data)){
                //     $emp_unique_id = $data->emp_unique_id;
                // }
                // $emp->emp_unique_id = alphaNumericGenerator(4,'FQ','',$emp_unique_id);
                // $emp->save();
                // $data1 = CompanyDetail::find($emp->emp_id);
                // $data = array('data' => $data1);
                // $email=$request->email;
                // Mail::send('getdemo1', $data, function ($message)use($email){
                //     $message->to($email,'Fix-Q')->subject('Your Unique-ID');
                //     $message->from('no-reply@fixingdots.com','No-Reply Fixingdots');
                // });
                return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([EmployeePersonalDetail::find($emp->id)])->all());
                return $emp;
            }

            return response()->json(['result' => [], 'status' => false]);
        }
    }

    // public function store(Request $request)
    // {
    // public function AddEmployee(Request $request){
    //     dd($request->session()->get('business_id'));
    //     DB::table('employee_personal_details')->insert([
    //     // 'business_id' => $request->session()->get('business_id'),
    //     'employee_type' => $request->employee_type,
    //     'emp_name' => $request->name,
    //     'emp_id' => $request->emp_id,
    //     'emp_mobile_number' => $request->mobile_number,
    //     'emp_email' => $request->email,
    //     'emp_branch' => $request->branch,
    //     'emp_department' => $request->department,
    //     'emp_designation' => $request->designation,
    //     'emp_date_of_birth' => $request->dob,
    //     'emp_date_of_joining' => $request->doj,
    //     'emp_gender' => $request->gender,
    //     'emp_address' => $request->address,
    //     'emp_country' => $request->country,
    //     'emp_state' => $request->state,
    //     'emp_city' => $request->city,
    //     'emp_pin_code' => $request->pincode,
    //     'profile_photo' => $request->photo,
    //     'created_at' => now(),
    //     'updated_at' => now()
    // ]);

    // DB::table('login_employee')->insert([
    //     'business_id' =>$request->business_id,
    //     'name' => $request->name,
    //     'email' => $request->email,
    //     'country_code' => $request->countrycode,
    //     'phone' => $request->mobile_number,
    //     'otp' => $request->otp,
    //     'created_at' => now(),
    //     'updated_at' => now()
    // ]);
    // return "Table '$tableName' has been created.";
    // return redirect('admin/employee');
    // return response()->json(["Employee Detail" =>$request->all()]);
    // }

    public function show($id)
    {
        $emp = DB::table('employee_personal_details')->find($id);
        if ($emp) {
            // return response()->json(['Employee Detail' => $emp]);
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([$emp])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $emp = EmployeePersonalDetail::find($id);
        if ($cat->delete()) {
            return ReturnHelpers::jsonApiReturn(true);
        }
        return response()->json(['result' => [], 'status' => false]);
    }
}
