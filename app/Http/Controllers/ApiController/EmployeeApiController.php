<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\admin\LoginAdmin;
use App\Models\employee\LoginEmployee;
use Illuminate\Support\Facades\DB;
// /public_html/app/Models/admin    
use App\Helpers\ReturnHelpers;
use App\Helpers\ApiResponse;
use App\Http\Resources\Api\EmployeeResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;
use Session;
use Validator;
// /Http/Resources/Api

class EmployeeApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $emp = EmployeePersonalDetail::all();
        if ($emp) {
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection($emp)->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id' => 'required',
            'branch_id' => 'required',
            'employee_type' => 'required',
            'name' => 'required',
            'emp_id' => 'required',
            'mobile_no' => 'required',
            'email' => 'required',
            'branch' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'dob' => 'required',
            'doj' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
            // 'photo' => 'required',
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
                EmployeePersonalDetail::where('emp_mobile_number', $request->mobile_no)
                    ->get()
                    ->first()
            ) {
                $data['msg'] = 'Mobile number already exists';
                return response()->json(['result' => [$data], 'status' => false]);
            }
            // Employee Personal Detail Table
            $emp = new EmployeePersonalDetail();
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max size as needed
            ]);
            $image = $request->file('image');
            $path = public_path('business_logo/');
            $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
            $emp->emp_id = $request->emp_id;
            $emp->business_id = $request->business_id;
            $emp->branch_id = $request->branch_id;
            $emp->employee_type = $request->employee_type;
            $emp->emp_name = $request->name;
            $emp->emp_mobile_number = $request->mobile_no;
            $emp->emp_email = $request->email;
            // $emp->emp_branch = $request->branch;
            $emp->department_id = $request->department;
            $emp->designation_id = $request->designation;
            $emp->emp_date_of_birth = $request->dob;
            $emp->emp_date_of_joining = $request->doj;
            $emp->emp_gender = $request->gender;
            $emp->emp_address = $request->address;
            $emp->emp_country = $request->country;
            $emp->emp_state = $request->state;
            $emp->emp_city = $request->city;
            $emp->emp_pin_code = $request->pin_code;
            $emp->profile_photo = $imageName;

            // LoginEmployee Table
            $emplogin = new LoginEmployee();
            $emplogin->business_id = $request->business_id;
            $emplogin->name = $request->name;
            $emplogin->email = $request->email;
            $emplogin->country_code = $request->country_code;
            $emplogin->phone = $request->mobile_no;
            // return true;
            if ($emp->save() && $emplogin->save()) {
                return ReturnHelpers::jsonApiReturn(EmployeeResource::collection(EmployeePersonalDetail::where('emp_id', $request->emp_id)->get()));
            }
            return response()->json(['result' => [], 'status' => false]);
        }
    }

    public function show($emp_id)
    {
        // return true; 
        $emp = EmployeePersonalDetail::where('emp_id', $emp_id)->first();
        // return $emp;
        if ($emp) {
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([$emp])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }
    public function update(Request $request, $emp_id)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $emp_id)->first();
        $emp->business_id = $request->business_id ?? $emp->business_id;
        $emp->branch_id = $request->branch_id ?? $emp->branch_id;
        $emp->employee_type = $request->employee_type ?? $emp->employee_type;
        $emp->emp_name = $request->name ?? $emp->emp_name;
        $emp->emp_id = $request->emp_id ?? $emp->emp_id;
        $emp->emp_mobile_number = $request->mobile_no ?? $emp->emp_mobile_number;
        $emp->emp_email = $request->email ?? $emp->emp_email;
        // $emp->emp_branch = $request->branch ?? $emp->emp_branch;
        $emp->department_id = $request->department ?? $emp->department_id;
        $emp->designation_id = $request->designation ?? $emp->designation_id;
        $emp->emp_date_of_birth = $request->dob ?? $emp->emp_date_of_birth;
        $emp->emp_date_of_joining = $request->doj ?? $emp->emp_date_of_joining;
        $emp->emp_gender = $request->gender ?? $emp->emp_gender;
        $emp->emp_address = $request->address ?? $emp->emp_address;
        $emp->emp_country = $request->country ?? $emp->emp_country;
        $emp->emp_state = $request->state ?? $emp->emp_state;
        $emp->emp_city = $request->city ?? $emp->emp_city;
        $emp->emp_pin_code = $request->pin_code ?? $emp->emp_pin_code;
        $emp->profile_photo = $request->photo ?? $emp->profile_photo;

        $emplogin = LoginEmployee::where('emp_id', $emp_id)->first();
        $emplogin->business_id = $request->business_id ?? $emplogin->business_id;
        $emplogin->name = $request->name ?? $emplogin->name;
        $emplogin->email = $request->email ?? $emplogin->email;
        $emplogin->country_code = $request->country_code ?? $emplogin->country_code;
        $emplogin->phone = $request->mobile_no ?? $emplogin->phone;

        if ($emp->save() && $emplogin->update()) {
            // return true;
            // $emplogin->update();
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([$emp])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function destroy($emp_id)
    {
        $emp = EmployeePersonalDetail::where('emp_id', $emp_id)->first();
        $emplogin = LoginEmployee::where('emp_id', $emp_id)->first();
        if ($emp) {
            $emp->delete();
            $emplogin->delete();
            return response()->json(['result' => true, 'status' => true, 'msg' => 'Delete Successfully!']);
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function bemployee($business_id)
    {
        $emp = EmployeePersonalDetail::where('business_id', $business_id)->get();
        // return $emp;
        if ($emp) {
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection(EmployeePersonalDetail::where('business_id', $business_id)->get()));
        }
        return response()->json(['result' => [], 'status' => false]);
    }

    public function allemployee($business_id)
    {
        return ApiResponse::allBranch($business_id);
        // return ApiResponse::allEmployeeList($business_id);

        // allEmployeeList
    }
    
    public function departmenttoallEmployeeList($branch_id)
    {
        // return true;
        return ApiResponse::allBranch($branch_id);
        // return ApiResponse::allBranch($branch_id);

        // $emp = EmployeePersonalDetail::where('business_id', $business_id)->get();
    }
}
