<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admin\BranchList;
use App\Models\admin\LoginAdmin;
use App\Models\admin\DepartmentList;
use App\Models\admin\DesignationList;
use App\Models\admin\WeeklyHolidayList;
use App\Models\admin\SettingLeaveCategory;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Central_unit;

// Use Alert;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.setting');
    }


    // Attendance Mode setting functions 

    public function setAttendaceMode(Request $request)
    {
        // dd($request->all());
        $isPresent = DB::table('attendance_mode')->where('business_id', $request->session()->get('business_id'))->get();
        if ($isPresent->count() == 0) {
            $setMode = DB::table('attendance_mode')->insert([
                'business_id' => $request->session()->get('business_id'),
                'in_premises_auto' => $request->premisesIsAuto ? $request->premisesIsAuto : 0,
                'in_premises_qr' => $request->premisesIsAuto == 0 || null ? $request->premisesQR : 0,
                'in_premises_face_id' => $request->premisesIsAuto == 0 || null ? $request->premisesFaceId : 0,
                'in_premises_selfie' => $request->premisesIsAuto == 0 || null ? $request->premisesSelfie : 0,
                'outdoor_auto' => $request->outIsAuto ? $request->outIsAuto : 0,
                'outdoor_selfie' => $request->outIsAuto == 0 || null ? $request->outSelfie : 0,
                'wfh_auto' => $request->wfhIsAuto ? $request->wfhIsAuto : 0,
                'wfh_selfie' => $request->wfhIsAuto == 0 || null ? $request->wfhSelfie : 0,
                'updated_at' => now(),
            ]);

            if ($setMode) {
                Alert::success('Successfully Created', '');
            } else {
                Alert::error('Failed', '');
            }
        } else {
            $updateMode = DB::table('attendance_mode')->where(['business_id' => $request->session()->get('business_id')])->update([
                'business_id' => $request->session()->get('business_id'),
                'in_premises_auto' => $request->premisesIsAuto ? $request->premisesIsAuto : 0,
                'in_premises_qr' => $request->premisesIsAuto == 0 || null ? $request->premisesQR : 0,
                'in_premises_face_id' => $request->premisesIsAuto == 0 || null ? $request->premisesFaceId : 0,
                'in_premises_selfie' => $request->premisesIsAuto == 0 || null ? $request->premisesSelfie : 0,
                'outdoor_auto' => $request->outIsAuto ? $request->outIsAuto : 0,
                'outdoor_selfie' => $request->outIsAuto == 0 || null ? $request->outSelfie : 0,
                'wfh_auto' => $request->wfhIsAuto ? $request->wfhIsAuto : 0,
                'wfh_selfie' => $request->wfhIsAuto == 0 || null ? $request->wfhSelfie : 0,
                'updated_at' => now(),
            ]);

            if ($updateMode) {
                Alert::success('Successfully Updated', '');
            } else {
                Alert::error('Failed', '');
            }
        }

        return back();
    }

    // account setting
    public function account()
    {
        $accDetail = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];


        return view('admin.setting.account.account', compact('permissions', 'moduleName', 'accDetail'));
    }

    // sbussinesstype.update
    public function semailupdate(Request $request)
    {
        // dd($request->all());
        $branch = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['client_name' => $request->name]);
        // return $branch;
        return back();
    }

    public function saddressupdate(Request $request)
    {
        // dd($request->all());
        $branch = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update([
                'business_address' => $request->address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'pin_code' => $request->pincode,
            ]);
        // $branch = DB::table('business_details_list')->where('id', $request->editBranchId)->where('business_id', Session::get('business_id'))->update(['business_address' = $request->address, 'country' = $request->country , 'state' = $request->state , 'city' = $request->city , 'pincode' = $request->pincode]);
        // $branch->business_address = $request->address;
        // $branch->country = $request->country;
        // $branch->state = $request->state;
        // $branch->city = $request->city;
        // $branch->pincode = $request->pincode;
        // $branch->update();

        // return $branch;
        return back();
    }

    public function sbtypeupdate(Request $request)
    {
        // dd($request->all());
        $branch = DB::table('business_details_list')
            ->where('id', $request->editBtypeId)
            ->where('business_id', Session::get('business_id'))
            ->update(['business_type' => $request->select]);
        // return $branch;
        return back();
    }

    public function uploadlogo(Request $request)
    {
        // echo $request->file('image')->store('uploads');

        if ($request->image) {
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                // Adjust max size as needed
            ]);
            // Get the uploaded image file
            $image = $request->file('image');
            $path = public_path('business_logo/');
            $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
            $data = $request->image->move($path, $imageName);
            // return $data;
            // return $path;
            $data = DB::table('business_details_list')
                ->where('id', $request->editlogoId)
                ->where('business_id', Session::get('business_id'))
                ->update(['business_logo' => $imageName]);
            if ($data) {
                // return $data;
                return back();
            } else {
                return 'hasfail';
            }
            // $image  = new Image();
            // $image->name = $imageName;
            // $image->save();

            // Return a response with information about the uploaded image
            return response()->json([
                'message' => 'Image uploaded successfully.',
                'image_path' => $imageName,
            ]);
        }
        return back();

        //  else {
        //     return response()->json(['result' => [], 'status' => false], 404);
        // }

        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";

        // $image = $request->file('image');
        // $path = public_path('business_logo/');
        // $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->getClientOriginalExtension();
        // $request->image->move($path, $imageName);

        // $image  = new Image();
        // $image->name = $imageName;
        // $image->save();

        // Return a response with information about the uploaded image
        // return response()->json([
        //     'message' => 'Image uploaded successfully.',
        //     'image_path' => $imageName,
        // ]);
        // return $imageName;

        // $branch = DB::table('business_details_list')->where('id', $request->editlogo)->where('business_id', Session::get('business_id'))->update(['business_logo' => $request->logo]);
        // return $branch;
        // return back();
    }

    public function sbussinessnameupdate(Request $request)
    {
        // dd($request->all());
        $branch = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['business_name' => $request->business_name, 'business_categories' => $request->select]);
        // return $branch;
        return back();
    }
    // sphoneupdate
    public function sphoneupdate(Request $request)
    {
        // dd($request->all());
        $branch = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['mobile_no' => $request->phone]);
        // return $branch;
        return back();
    }

    public function nameupdate(Request $request)
    {
        // dd($request->all());
        $branch = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['client_name' => $request->name]);
        // return $branch;
        return back();
    }

    // business setting
    public function business()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];


        return view('admin.setting.business.business', compact('permissions', 'moduleName'));
    }
    public function admin()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.business.admin.admin_setting', compact('permissions', 'moduleName'));
    }
    public function branches()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.business.branches.branches', compact('permissions', 'moduleName'));
    }
    public function department()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $branchList = BranchList::all();
        $deparmentList = DepartmentList::all();

        $data = compact('deparmentList', 'branchList', 'permissions', 'moduleName');

        // <?=DB::table('department_list')->where('branch_id',$items->branch_id)->select('depart_name')->get()
        return view('admin.setting.business.department.department', $data);
    }
    public function designation(Request $request)
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $item = DesignationList::where('desig_id', $request->id)->first();

        // if($getvalue){
        //     return response()->json(["editDesignationResult"=>$getvalue]);
        // }

        return view('admin.setting.business.designation.designation', compact('item', 'permissions', 'moduleName'));
    }

    // designationDetails ajax list shows
    public function allDepartment(Request $request)
    {
        $get = DepartmentList::where('branch_id', $request->brand_id)->get();
        return response()->json(['department' => $get]);
    }
    public function allDesignation(Request $request)
    {
        $get = DB::table('designation_list')
            ->where('department_id', $request->depart_id)
            ->get();
        return response()->json(['designation' => $get]);
    }
    public function check(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $get = DB::table('employee_personal_details')
                ->where('department_id', $request->check_value)
                ->get();
            if ($get) {
                $i = 1;
                foreach ($get as $viewside) {
                    $output .=
                        '<tr>
                            <td>' .
                        $i .
                        '</td>
                            <td>' .
                        $viewside->emp_id .
                        '</td>
                            <td>' .
                        $viewside->emp_name .
                        '</td>
                            <td>' .
                        '<input type="checkbox">' .
                        '</td>
                        </tr>
                        ';
                    $i++;
                }
                return response()->json($output);
            }
            // return response()->json($request->check_value);
        }
    }
    public function allEmployeeFilter()
    {
        $get = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->when(request('branch_id'), function ($query, $branchId) {
                return $query->where('branch_id', $branchId);
            })
            ->when(request('depart_id'), function ($query, $departId) {
                return $query->where('department_id', $departId);
            })
            ->when(request('department_id'), function ($query, $designation) {
                return $query->where('department_id', $designation);
            })
            ->get();
        return response()->json(['employee' => $get]);
    }
    public function designationDetails(Request $request)
    {
        // return response()->json(['editDesignationResult'=>$getvalue]);
    }

    // addition functions
    public function AddBranch(Request $request)
    {
        $data = [
            'business_id' => $request->session()->get('business_id'),
            'branch_id' => md5($request->session()->get('business_id') . $request->branch),
            'branch_name' => $request->branch,
        ];
        $addBranch = DB::table('branch_list')->insert($data);

        if ($addBranch) {
            Alert::success('Added Success', 'Create Branch Successfully');
        }
        return redirect()->route('admin.branch');
    }

    public function AddDepartment(Request $request)
    {
        // dd($request);
        $department = new DepartmentList();
        $department->b_id=Session::get('business_id');
        $department->depart_name = $request->department;
        $department->branch_id = $request->branch;
        $department->status = 0;
        if ($department->save()) {
            Alert::success('Added Success', 'Create Department Name Successfully');
        }
        return redirect()->route('admin.department');
    }
    public function AddDesignation(Request $request)
    {
        $designation = new DesignationList();
        $designation->business_id = $request->session()->get('business_id');
        $designation->desig_name = $request->designation;
        $designation->department_id = $request->department;
        $designation->branch_id = $request->branch;

        if ($designation->save()) {
            Alert::success('Added Success', 'Create Designation Name Successfully');
        }
        return redirect()->route('admin.designation');
    }

    // update Functions
    public function UpdateBranch(Request $request)
    {
        $branch = DB::table('branch_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['branch_name' => $request->editbranch]);

        if ($branch) {
            Alert::success('Data Updated', 'Updated  Created');
            return redirect()->route('admin.branch');
        }
    }
    public function UpdateDepartment(Request $request)
    {
        $department = DepartmentList::where('depart_id', $request->editid)
            ->where('b_id', $request->session()->get('business_id'))
            ->update([
                'b_id' => $request->session()->get('business_id'),
                'branch_id' => $request->editbranch,
                'depart_name' => $request->editdepartment,
            ]);

        if ($department) {
            Alert::success('Data Designation Updated', 'Updated Designation Created');
        }
        return redirect()->route('admin.department');
    }
    public function UpdateDesignation(Request $request)
    {
        // dd($request->all());
        $designation = DesignationList::where('desig_id', $request->editid)
            ->where('business_id', $request->session()->get('business_id'))
            ->update([
                'business_id' => $request->session()->get('business_id'),
                'branch_id' => $request->editbranch,
                'department_id' => $request->editdepartment,
                'desig_name' => $request->editdesignation,
            ]);
        if ($designation) {
            Alert::success('Data Designation Updated', 'Updated Designation Created');
        }
        return redirect()->route('admin.designation');
    }

    // Delete Functions
    public function DeleteBranch($id)
    {
        $branchLList = DB::table('branch_list')
            ->where('id', $id)
            ->where('business_id', Session::get('business_id'))
            ->first();
        $departmentList = DB::table('department_list')
            ->where('branch_id', $branchLList->branch_id)
            ->first();
        if (isset($departmentList)) {
            // echo "DATA hy iska";
            Alert::warning('Data Persent', 'Department also  created');
        }
        if (!isset($departmentList)) {
            // echo "empty hy ayh";
            $roos = DB::table('branch_list')
                ->where('id', $id)
                ->delete();
            // if (isset($roos)) {
            Alert::success(' Delete Success', 'Your Added Delete Successfully');
            // }
        }
        return redirect()->route('admin.branch');
    }

    public function DeleteDepartment($departID)
    {
        $department = DB::table('department_list')
            ->where('depart_id', $departID)
            ->first();
        $designation = DB::table('designation_list')
            ->where('department_id', $department->depart_id)
            ->first();

        if (isset($designation)) {
            // echo "DATA hy iska";
            Alert::warning('Data Persent', 'Designation also  created');
        }
        if (!isset($designation)) {
            // echo "empty hy ayh";
            $roos = DB::table('department_list')
                ->where('depart_id', $departID)
                ->delete();
            // if (isset($roos)) {
            Alert::success(' Delete Success', 'Your Added Delete Successfully');
            // }
        }
        return redirect()->route('admin.department');
    }

    public function DeleteDesignation($id)
    {
        $designation = DesignationList::where('desig_id', $id)->delete();
        // dd($designation);
        if ($designation) {
            Alert::success('Delete Success', 'Delete Desgination Successfully');
        }
        // Session::flash('success', 'Succefully Deleted !');
        return redirect()->route('admin.designation');
    }

    public function holidayPolicy()
    {
        return view('admin.setting.business.holiday_policy.holiday_policy');
    }
    public function inviteEmpl()
    {
        return view('admin.setting.business.invite_empl.invite_empl');
    }
    public function leavePolicy(Request $request)
    {
        $call = new Central_unit();
        $BranchList = $call->BranchList();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $leaveTemp = DB::table('setting_leave_policy')
            ->where('business_id', $request->session()->get('business_id'))
            ->get();
        $Leaves = DB::table('setting_leave_category')
            ->where('business_id', $request->session()->get('business_id'))
            ->get();
        return view('admin.setting.business.leave_policy.leave_policy', compact('leaveTemp', 'Leaves', 'BranchList', 'permissions', 'moduleName'));
    }

    public function DeleteLeave(Request $request)
    {
        $data = $request->state;
        $leaveDelete = DB::table('setting_leave_category')
            ->where('id', $data)
            ->delete();
        return response()->json([$leaveDelete]);
    }
    public function DeleteLeaveTemp($id)
    {
        // dd($id);
        $deleteTemp = DB::table('setting_leave_policy')
            ->where('id', $id)
            ->delete();
        $deleteLeaves = DB::table('setting_leave_category')
            ->where('leave_policy_id', $id)
            ->delete();

        if ($deleteTemp) {
            Alert::success('Successfully Deleted ', '');
            return back();
        } else {
            Alert::error('Failed', '');
            return back();
        }
    }
    public function UpdateLeaveTemp(Request $request)
    {
        // dd($request->all());

        if ($request->has('Tempid')) {
            $updateTemp = DB::table('setting_leave_policy')
                ->where('id', $request->Tempid)
                ->update([
                    'policy_name' => $request->Update_policyname,
                    'leave_policy_cycle_monthly' => $request->btnradio,
                    'leave_period_from' => $request->update_leave_periodfrom,
                    'leave_period_to' => $request->update_leave_periodto,
                ]);
        }

        if ($request->has('category_name')) {
            foreach ($request->category_name as $key => $category) {
                $leave = DB::table('setting_leave_category')->insert([
                    'leave_policy_id' => $request->Tempid,
                    'business_id' => $request->session()->get('business_id'),
                    'branch_id' => $request->session()->get('branch_id'),
                    'category_name' => $request->category_name[$key],
                    'days' => $request->update_days[$key],
                    'unused_leave_rule' => $request->update_unused_leave_rule[$key],
                    'carry_forward_limit' => $request->update_carry_forward_limit[$key],
                    'applicable_to' => $request->update_applicable_to[$key],
                ]);
            }
        }

        if ($updateTemp || $leave) {
            Alert::success('Successfully Updated', '');
            return back();
        } else {
            Alert::error('Failed', '');
            return back();
        }
    }

    public function leavePolicySubmit(Request $request)
    {
        dd($request->all());
        if (empty($request->category_name)) {
            Alert::info('Not Added', 'Pleace Enter You Category Name, Your Leave-Policy Not Added');
            return back();
        }

        // }
        // return back();
        $BusinessID = $request->session()->get('business_id');
        $branchID = $request->session()->get('branch_id');
        $storeData = [
            'business_id' => $BusinessID,
            'branch_id' => $branchID != '' ? $branchID : '',
            'policy_name' => $request->policyname,
            'leave_policy_cycle_monthly' => $request->btnradio != 1 ? 0 : 1,
            'leave_policy_cycle_yearly' => $request->btnradio != 2 ? 0 : 2,
            'leave_period_from' => $request->leave_periodfrom,
            'leave_period_to' => $request->leave_periodto,
            'created_at' => now('Asia/Kolkata'),
            'updated_at' => now('Asia/Kolkata'),
        ];
        // dd($storeData);
        $truechecking_id = DB::table('setting_leave_policy')->insert($storeData);
        // dd($truechecking_id);
        if ($truechecking_id) {
            $latestID = DB::table('setting_leave_policy')
                ->latest()
                ->select('id')
                ->first();
            if (isset($latestID)) {
                $latestLeavePolicyID = $latestID->id; //generate policy ID run time
                // dd($latestLeavePolicyID);

                $CategoryName = $request->category_name;
                $Days = $request->days;
                $UnusedLeaveRule = $request->unused_leave_rule;
                $carryForwardLimit = $request->carry_forward_limit;
                $applicationTo = $request->applicable_to;

                for ($i = 0; $i < sizeof($request->category_name); $i++) {
                    // dd($UnusedLeaveRule);
                    $collectionDataSet = [
                        'leave_policy_id' => $latestLeavePolicyID,
                        'business_id' => $BusinessID,
                        'branch_id' => $branchID,
                        'category_name' => $CategoryName[$i],
                        'days' => $Days[$i],
                        'unused_leave_rule' => $UnusedLeaveRule[$i],
                        'carry_forward_limit' => $carryForwardLimit[$i],
                        'applicable_to' => $applicationTo[$i],
                        'created_at' => now('Asia/Kolkata'),
                        'updated_at' => now('Asia/Kolkata'),
                    ];
                    // print_r($collectionDataSet);
                    // dd($collectionDataSet);
                    DB::table('setting_leave_category')->insert($collectionDataSet);
                }
            }
            Alert::success('Added', 'Your Leave-Policy Added Successfully');
        } else {
            Alert::info('Not Added', 'Your Leave-Policy Not Added');
        }
        return back();
    }

    public function manageEmpDetails()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.business.manage_emp.manage', compact('permissions', 'moduleName'));
    }
    public function manager()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.business.manager.manager', compact('permissions', 'moduleName'));
    }
    public function weeklyHoliday()
    {
        $data = WeeklyHolidayList::where('business_id', Session::get('business_id'))->get();

        // dd($data);
        $days = [];

        foreach ($data as $item) {
            $days = json_decode($item->days, true); // Assuming 'days' column contains JSON data
        }

        return view('admin.setting.business.weekly_holiday.weekly_holiday', compact('data', 'days'));
    }

    // business info
    public function businessinfo()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.businessinfo.businessinfo', compact('permissions', 'moduleName'));
    }

    // attendance setting
    public function attendance()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $Modes = DB::table('attendance_mode')->where('business_id', Session()->get('business_id'))->first();
        return view('admin.setting.attendance.attendance', compact('Modes', 'permissions', 'moduleName'));
    }

    public function attendanceAccess()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.attendance_acccess', compact('permissions', 'moduleName'));
    }



    public function createShift()
    {
        $fixShift = DB::table('shift_fixed')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $openShift = DB::table('shift_open')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $rotationalShift = DB::table('shift_rotational')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $setShift = DB::table('shift_set')
            ->where('business_id', Session::get('business_id'))
            ->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.createshift', compact('permissions', 'moduleName', 'setShift', 'rotationalShift', 'openShift', 'fixShift'));
    }

    // automation rule
    public function automation()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.automation', compact('permissions', 'moduleName'));
    }
    public function asignEmp()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.rules.add_emp', compact('permissions', 'moduleName'));
    }
    public function breakRule()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];


        return view('admin.setting.attendance.rules.break_rule', compact('permissions', 'moduleName'));
    }
    public function earlyExit()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.rules.early_exit', compact('permissions', 'moduleName'));
    }
    public function lateEntry()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.rules.late_entry', compact('permissions', 'moduleName'));
    }
    public function overtimeRule()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.rules.overtime_rule', compact('permissions', 'moduleName'));
    }
    public function earlyOvertimes()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.rules.early_overtimes', compact('permissions', 'moduleName'));
    }

    public function attOnHoliday()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.attendance.attendance_on_holiday', compact('permissions', 'moduleName'));
    }

    // salary setting
    public function salary()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('admin.setting.salary.salary', compact('permissions', 'moduleName'));
    }
    public function salaryTemp()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.salary.salary_structure_temp', compact('permissions', 'moduleName'));
    }
    public function EmpAcDetail()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.salary.employee_acc_detail', compact('permissions', 'moduleName'));
    }
    public function other()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.other.other', compact('permissions', 'moduleName'));
    }
}
