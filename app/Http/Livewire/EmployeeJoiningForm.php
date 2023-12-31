<?php

namespace App\Http\Livewire;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\employee\EmployeePersonalDetail;
use App\Helpers\Central_unit;
use App\Models\PolicyMasterEndgameMethod;
use App\Models\StaticEmployeeJoinMaritalType;
use App\Models\StaticEmployeeJoinCategoryCaste;
use App\Models\StaticEmployeeJoinBloodGroup;
use App\Models\StaticEmployeeJoinGovtDocType;
use App\Models\StaticEmployeeJoinGenderType;



class EmployeeJoiningForm extends Component
{
    public function AddEmployee(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $itemm = DB::table('employee_personal_details')
            ->where('emp_id', $request->emp_id)
            ->first();
        if ($itemm) {
            Alert::error('Employee Not Added', 'Employee Id is alerady exist.');
            // return redirect('admin/employee');
            return back();
        }

        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // Adjust max size as needed
        ]);

        // Get the uploaded image file
        $image = $request->file('image');

        // Generate a unique image name
        $imageName = date('d-m-Y') . '_' . md5(time()) . '.' . $image->getClientOriginalExtension();

        // Move the uploaded image to the desired directory
        $image->move(public_path('employee_profile/'), $imageName);

        // dd($request);
        $masterEndgameId = PolicyMasterEndgameMethod::where('business_id', Session::get('business_id'))
            ->where('method_switch', 1)
            ->select('id')
            ->first();

        

        // dd($masterEndgameId->id);
        $added = DB::table('employee_personal_details')->insert([
            'business_id' => $request->session()->get('business_id'),
            'master_endgame_id' => $masterEndgameId->id,
            'employee_type' => $request->employee_type,
            'employee_contractual_type' => $request->contractualtype != null ? $request->contractualtype : '0',
            'emp_name' => $request->name,
            'emp_rotational_shift_type_item' => $request->rotational_item_name != null ? $request->rotational_item_name : '0',
            'emp_mname' => $request->mName,
            'emp_lname' => $request->lName,
            'emp_mobile_number' => $request->mobile_number,
            'emp_email' => $request->email_sd,
            'emp_date_of_birth' => $request->dob_dd,
            'emp_gender' => $request->gender,
            'emp_marital_status' => $request->marital_satatus_dd,
            'emp_country' => $request->country_dd,
            'emp_category' => $request->caste_dd,
            'emp_blood_group' => $request->blood_group_dd,
            'emp_gov_select_id' => $request->select_id_dd,
            'emp_gov_select_id_number' => $request->id_number_dd,
            'emp_nationality' => $request->nationality_dd,
            'emp_state' => $request->state_dd,
            'emp_city' => $request->city_dd,
            'emp_pin_code' => $request->pincode_dd,
            'emp_address' => $request->address_dd,
            'emp_id' => $request->emp_id,
            'emp_shift_type' => $request->shift_type_name,
            'emp_rotational_shift_type_item' => $request->rotational_type_name != null ? $request->rotational_type_name : '0',
            'branch_id' => $request->branch_id1,
            'department_id' => $request->department_id1,
            'designation_id' => $request->designation_id1,
            'emp_reporting_manager' => $request->reporting_manager_dd,
            'emp_date_of_joining' => $request->doj,
            'emp_attendance_method' => $request->attendance_method,
            'profile_photo' => $imageName,
        ]);

        $loginEmp = DB::table('login_employee')->insert([
            'emp_id' => $request->emp_id,
            'business_id' => $request->session()->get('business_id'),
            // 'name' => $request->name,
            'email' => $request->email_sd,
            'country_code' => '+91',
            'phone' => $request->mobile_number,
        ]);

        if (isset($added) && isset($loginEmp)) {
            Alert::success('Added Successfully', 'Your Employee Detail is Added Successfully');
            return redirect('admin/employee');
        }
        Alert::error('Not Updated', 'Your Employee Detail Updation is Fail');
        return redirect('admin/employee');
    }

    public function render()
    {
        $call = new Central_unit();
        $Branch = $call->BranchList();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $attendanceMethod = DB::table('static_attendance_methods')->get();

        $staticGender = StaticEmployeeJoinGenderType::get();
        $staticMarital = StaticEmployeeJoinMaritalType::get();
        $statciCategory = StaticEmployeeJoinCategoryCaste::get();
        $staticbloodGroup = StaticEmployeeJoinBloodGroup::get();
        $staticGovId = StaticEmployeeJoinGovtDocType::get();

        $shiftAttendance = DB::table('policy_attendance_shift_settings')
            ->join('static_attendance_shift_type', 'policy_attendance_shift_settings.shift_type', '=', 'static_attendance_shift_type.id')
            ->where('business_id', Session::get('business_id'))
            ->select('policy_attendance_shift_settings.id as attendance_id','static_attendance_shift_type.id as shift_type_id', 'policy_attendance_shift_settings.shift_type_name', 'static_attendance_shift_type.name as static_attendance_shift_type_name')
            ->get();
            // dd($shiftAttendance);    
        $DATA = DB::table('employee_personal_details')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->get();
        // dd($DATA);
        return view('livewire.employee-joining-form', compact('DATA', 'Branch', 'moduleName', 'permissions', 'shiftAttendance', 'attendanceMethod', 'staticGender', 'staticMarital', 'statciCategory', 'staticbloodGroup', 'staticGovId'));

        // return view('livewire.employee-joining-form');
    }
}
