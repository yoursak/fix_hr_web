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
        $masterEndgameId = DB::table('master_endgame_method')
            ->where('business_id', Session::get('business_id'))
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
            'emp_mname' => $request->mName,
            'emp_lname' => $request->lName,
            'emp_mobile_number' => $request->mobile_number,
            'emp_email' => $request->email_sd,
            'emp_date_of_birth' => $request->dob,
            'emp_gender' => $request->gender,
            'emp_country' => $request->country,
            'emp_state' => $request->state,
            'emp_city' => $request->city,
            'emp_pin_code' => $request->pincode,
            'emp_address' => $request->address,
            'emp_id' => $request->emp_id,
            'emp_shift_type' => $request->shift_type,
            'branch_id' => $request->branch_id1,
            'department_id' => $request->department_id1,
            'designation_id' => $request->designation_id1,
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
        $attendanceMethod = DB::table('attendance_methods')->get();

        $shiftAttendance = DB::table('attendance_shift_settings')
            ->join('attendance_shift_type', 'attendance_shift_settings.shift_type', '=', 'attendance_shift_type.id')
            ->where('business_id', Session::get('business_id'))
            ->select('attendance_shift_settings.id as attendance_id', 'attendance_shift_settings.shift_type_name', 'attendance_shift_type.name as attendance_shift_type_name')
            ->get();

        $DATA = DB::table('employee_personal_details')
            ->join('branch_list', 'employee_personal_details.branch_id', '=', 'branch_list.branch_id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->get();
        // dd($DATA);
        return view('livewire.employee-joining-form', compact('DATA', 'Branch', 'moduleName', 'permissions', 'shiftAttendance', 'attendanceMethod'));

        // return view('livewire.employee-joining-form');
    }
}
