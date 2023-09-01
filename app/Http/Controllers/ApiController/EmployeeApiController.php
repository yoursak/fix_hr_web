<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\employee\LoginEmployee;
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
            $emp->business_id = $request->business_id;
            $emp->branch_id = $request->branch_id;
            $emp->employee_type = $request->employee_type;
            $emp->emp_name = $request->name;
            $emp->emp_id = $request->emp_id;
            $emp->emp_mobile_number = $request->mobile_no;
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

            // LoginEmployee Table
            $emplogin = new LoginEmployee();
            $emplogin->business_id = $request->business_id;
            $emplogin->name = $request->name;
            $emplogin->email = $request->email;
            $emplogin->country_code = $request->country_code;
            $emplogin->phone = $request->mobile_no;
            if ($emp->save() && $emplogin->save()) {
                return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([EmployeePersonalDetail::find($emp->id)])->all());
            }
            return response()->json(['result' => [], 'status' => false]);
        }
    }

    public function show($emp_id)
    {
        $emp = EmployeePersonalDetail::find($emp_id);
        // return $emp;
        if ($emp) {
            return ReturnHelpers::jsonApiReturn(EmployeeResource::collection([$emp])->all());
        }
        return response()->json(['result' => [], 'status' => false]);
    }
    public function update(Request $request, $id)
    {
        $emp = EmployeePersonalDetail::find($id);
        $emp->business_id = $request->business_id ?? $emp->business_id;
        $emp->branch_id = $request->branch_id ?? $emp->branch_id;
        $emp->employee_type = $request->employee_type ?? $emp->employee_type;
        $emp->emp_name = $request->name ?? $emp->emp_name;
        $emp->emp_id = $request->emp_id ?? $emp->emp_id;
        $emp->emp_mobile_number = $request->mobile_no ?? $emp->emp_mobile_number;
        $emp->emp_email = $request->email ?? $emp->emp_email;
        $emp->emp_branch = $request->branch ?? $emp->emp_branch;
        $emp->emp_department = $request->department ?? $emp->emp_department;
        $emp->emp_designation = $request->designation ?? $emp->emp_designation;
        $emp->emp_date_of_birth = $request->dob ?? $emp->emp_date_of_birth;
        $emp->emp_date_of_joining = $request->doj ?? $emp->emp_date_of_joining;
        $emp->emp_gender = $request->gender ?? $emp->emp_gender;
        $emp->emp_address = $request->address ?? $emp->emp_address;
        $emp->emp_country = $request->country ?? $emp->emp_country;
        $emp->emp_state = $request->state ?? $emp->emp_state;
        $emp->emp_city = $request->city ?? $emp->emp_city;
        $emp->emp_pin_code = $request->pin_code ?? $emp->emp_pin_code;
        $emp->profile_photo = $request->photo ?? $emp->profile_photo;

        $emplogin = LoginEmployee::find($id);
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

    public function destroy($id)
    {
        $emp = EmployeePersonalDetail::find($id);
        $emplogin = LoginEmployee::find($id);
        if ($emp) {
            $emp->delete();
            $emplogin->delete();
            return response()->json(['result' => true, 'status' => true, 'msg' => 'Delete Successfully!']);
        }
        return response()->json(['result' => [], 'status' => false]);
    }
}
