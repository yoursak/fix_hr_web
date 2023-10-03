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
        $isPresent = DB::table('attendance_mode')
            ->where('business_id', $request->session()->get('business_id'))
            ->get();
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
            $updateMode = DB::table('attendance_mode')
                ->where(['business_id' => $request->session()->get('business_id')])
                ->update([
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


    public function subscription(Request $request){
        return view('admin.subscription.subscription');
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
        $branch_ID = $request->brand_id;
        $get = DepartmentList::where('branch_id', $branch_ID)->get();
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
        $department->b_id = Session::get('business_id');
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
    // Re-changes Policy BY JAY
    public function leavePolicy(Request $request)
    {
        $call = new Central_unit();
        $BranchList = $call->BranchList();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $Leaves = DB::table('setting_leave_category')
            ->where('business_id', $request->session()->get('business_id'))
            ->get();
        $leavePolicy = DB::table('setting_leave_policy')
            ->where('business_id', Session::get('business_id'))
            ->get();
        // dd($leavePolicy);
        return view('admin.setting.business.leave_policy.leave_policy', compact('leavePolicy', 'Leaves', 'BranchList', 'permissions', 'moduleName'));
    }
    // aJAX JAY
    public function allLeavePolicy(Request $request)
    {
        $send = DB::table('setting_leave_category')
            ->where('leave_policy_id', $request->leave_policy_id)
            ->get();
        return response()->json(['get' => $send]);
    }

    // Confirm Method set in AJAX
    public function updateLeavePolicy(Request $request)
    {
        // return response()->json(['message' => $request->all()]);

        $leaveID = $request->leave_policy_id;
        $policyName = $request->leave_name;
        $bID = Session::get('business_id');
        // Delete existing records for the given leave policy and business ID
        $check = DB::table('setting_leave_category')
            ->where('leave_policy_id', $leaveID)
            ->where('business_id', $bID)
            ->delete();

        // Check if records were successfully deleted
        if (isset($check)) {
            DB::table('setting_leave_policy')
                ->where('id', $leaveID)
                ->where('business_id', $bID)
                ->update(['policy_name' => $policyName]);
            // Assuming $request->updated_items is an array of updated items
            $updatedItems = $request->input('updated_items');

            // Insert the updated items into the table
            foreach ($updatedItems as $item) {
                DB::table('setting_leave_category')->insert([
                    'leave_policy_id' => $request->leave_policy_id,
                    'business_id' => $bID,
                    'category_name' => $item['category_name'],
                    'days' => $item['days'],
                    'unused_leave_rule' => $item['unused_leave_rule'],
                    'carry_forward_limit' => $item['carry_forward_limit'],
                    'applicable_to' => $item['applicable_to'],
                ]);
            }
            return response()->json(['message' => true]);
        } else {
            return response()->json(['message' => false]);
        }
    }

    // public function DeleteLeave(Request $request)
    // {
    //     $data = $request->state;
    //     $leaveDelete = DB::table('setting_leave_category')
    //         ->where('id', $data)
    //         ->delete();
    //     return response()->json([$leaveDelete]);
    // }
    public function DeleteLeavePolicy(Request $request)
    {
        // dd($id);
        $deleteTemp = DB::table('setting_leave_policy')
            ->where('id', $request->poli_id)

            ->delete();
        $deleteLeaves = DB::table('setting_leave_category')
            ->where('leave_policy_id', $request->poli_id)
            ->delete();

        if (isset($deleteTemp) && isset($deleteLeaves)) {
            Alert::success('Successfully Deleted Leave-Policy ');
        } else {
            Alert::error('Failed');
        }
        return back();
    }
    public function UpdateLeaveTemp(Request $request)
    {
        // dd($request->all());

        // if ($request->has('Tempid')) {
        //     $updateTemp = DB::table('setting_leave_policy')
        //         ->where('id', $request->Tempid)
        //         ->update([
        //             'policy_name' => $request->Update_policyname,
        //             'leave_policy_cycle_monthly' => $request->btnradio,
        //             'leave_period_from' => $request->update_leave_periodfrom,
        //             'leave_period_to' => $request->update_leave_periodto,
        //         ]);
        // }

        // if ($request->has('category_name')) {
        //     foreach ($request->category_name as $key => $category) {
        //         $leave = DB::table('setting_leave_category')->insert([
        //             'leave_policy_id' => $request->Tempid,
        //             'business_id' => $request->session()->get('business_id'),
        //             'branch_id' => $request->session()->get('branch_id'),
        //             'category_name' => $request->category_name[$key],
        //             'days' => $request->update_days[$key],
        //             'unused_leave_rule' => $request->update_unused_leave_rule[$key],
        //             'carry_forward_limit' => $request->update_carry_forward_limit[$key],
        //             'applicable_to' => $request->update_applicable_to[$key],
        //         ]);
        //     }
        // }

        // if ($updateTemp || $leave) {
        //     Alert::success('Successfully Updated', '');
        //     return back();
        // } else {
        //     Alert::error('Failed', '');
        //     return back();
        // }
    }

    public function leavePolicySubmit(Request $request)
    {
        // dd($request->all());
        // if (empty($request->category_name)) {
        //     Alert::info('Not Added', 'Pleace Enter You Category Name, Your Leave-Policy Not Added');
        //     return back();
        // }

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

    // set weekly Holiday
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
    // AJAX BY JAY
    public function allWeeklyHoliday(Request $request)
    {
        $days = WeeklyHolidayList::where('business_id', Session::get('business_id'))
            ->where('id', $request->holiday_weekly_id)
            ->get();

        return response()->json(['get' => $days]);
    }
    public function createWeeklyHoliday(Request $request)
    {
        $data = new WeeklyHolidayList();
        // return back();
        $data->business_id = Session::get('business_id');
        $data->name = $request->templatename;
        $data->days = json_encode($request->days);
        if ($data->save()) {
            Alert::success('Create Weekly Holidays');
        } else {
            Alert::info('Not Create Weely Holidays');
        }
        return back();
    }
    public function updateWeeklyHoliday(Request $request)
    {
        $data = DB::table('weekly_holiday_list')
            ->where('id', $request->id)
            ->where('business_id', Session::get('business_id'))
            ->update(['name' => $request->edit_weekname, 'days' => json_encode($request->holidays)]);
        if (isset($data)) {
            Alert::success('Update Weekly Holidays');
        } else {
            Alert::info('Not Update Weely Holidays');
        }
        return back();
    }
    public function deleteWeeklyHoliday(Request $request)
    {
        $data = DB::table('weekly_holiday_list')
            ->where('id', $request->weekly_policy_id)
            ->where('business_id', Session::get('business_id'))
            ->delete();

        if (isset($data)) {
            Alert::success('Delete Weekly Holidays');
        } else {
            Alert::info('Not Delete Weely Holidays');
        }
        return back();
    }
    // end weekly holiday

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
        $Track = DB::table('attendance_track_in_out')
        ->where('business_id', Session::get('business_id'))
        ->first();
  
        $Modes = DB::table('attendance_mode')
            ->where('business_id', Session()->get('business_id'))
            ->first();
        return view('admin.setting.attendance.attendance', compact('Modes','Track', 'permissions', 'moduleName'));
    }

    public function attendanceAccess()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $BusinessDetails = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $AttMode = DB::table('attendance_mode')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $Temp = DB::table('attendance_access')
            ->where('business_id', Session::get('business_id'))
            ->get();

        return view('admin.setting.attendance.attendance_acccess', compact('permissions', 'moduleName', 'BusinessDetails', 'AttMode', 'Temp'));
    }

    public function addAttendanceAccess(Request $request)
    {
        $accessTempName = $request->accessTempName;
        $branchId = $request->branchId;
        $departmentId = $request->departmentId;
        $mode = $request->mode;

        $data = [$accessTempName, $departmentId, $branchId, $mode];

        if ($accessTempName != null && $accessTempName != null && $branchId != null) {
            $addAccess = DB::table('attendance_access')->insert([
                'temp_name' => $accessTempName,
                'attendance_mode' => $mode,
                'branch_id' => $branchId,
                'department_id' => $departmentId,
                'business_id' => $request->session()->get('business_id'),
            ]);

            if ($addAccess) {
                Alert::success('Access Created Successfully', '');
            } else {
                Alert::error('Failed', '');
            }
        } else {
            Alert::error('Failed', 'All Input fields are required');
        }
        return response()->json($data);
    }
    public function deleteAttendanceAccess(Request $request)
    {
    }
    public function updateAttendanceAccess(Request $request)
    {
    }

    

    // automation rule
    public function automation()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $lateEntryData = DB::table('atten_rule_late_entry')->where('business_id', Session::get('business_id'))->first();
        $earlyExitData = DB::table('atten_rule_early_exit')->where('business_id', Session::get('business_id'))->first();
        $overtimeData = DB::table('atten_rule_overtime')->where('business_id', Session::get('business_id'))->first();
        $breakData = DB::table('atten_rule_break')->where('business_id', Session::get('business_id'))->first();
        $missPunchData = DB::table('atten_rule_misspunch')->where('business_id', Session::get('business_id'))->first();
        $gatePassData = DB::table('atten_rule_gatepass')->where('business_id', Session::get('business_id'))->first();

        return view('admin.setting.attendance.automation', compact('permissions', 'moduleName' , 'lateEntryData', 'earlyExitData', 'overtimeData', 'breakData', 'missPunchData', 'gatePassData'));
    }
    
    public function setAutomationRule(Request $request){
        // dd($request->all());

        if($request->dataLateEntry){
            if($request->dataLateEntry == 'true'){
                DB::table('atten_rule_late_entry')->where('business_id', Session::get('business_id'))->update(['switch_is'=>1]);
                return response()->json(['Updated true']);
            }else if($request->dataLateEntry == 'false'){
                 DB::table('atten_rule_late_entry')->where('business_id', Session::get('business_id'))->update(['switch_is'=>0]);
                return response()->json(['Updated false']);
            }else{
                return response()->json($request->dataLateEntry);
            }
        }

        if($request->breakSwitch)
        {
            if($request->breakSwitch == 'true'){
                DB::table('atten_rule_break')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 1]);
                return response()->json('Updated True');
            }else if($request->breakSwitch == 'false'){
                DB::table('atten_rule_break')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 0]);
                return response()->json('Updated False');
            }else{
                return response()->json($request->breakSwitch);
            }
        }

        if($request->earlyExitSwitch)
        {
            if($request->earlyExitSwitch == 'true'){
                DB::table('atten_rule_early_exit')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 1]);
                return response()->json('Updated True');
            }else if($request->earlyExitSwitch == 'false'){
                DB::table('atten_rule_early_exit')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 0]);
                return response()->json('Updated False');
            }else{
                return response()->json($request->earlyExitSwitch);
            }
        }

        if($request->overtimeSwitch)
        {
            if($request->overtimeSwitch == 'true'){
                DB::table('atten_rule_overtime')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 1]);
                return response()->json('Updated True');
            }else if($request->overtimeSwitch == 'false'){
                DB::table('atten_rule_overtime')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 0]);
                return response()->json('Updated False');
            }else{
                return response()->json($request->overtimeSwitch);
            }
        }

        if($request->missPunchSwitch)
        {
            if($request->missPunchSwitch == 'true'){
                DB::table('atten_rule_misspunch')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 1]);
                return response()->json('Updated True');
            }else if($request->missPunchSwitch == 'false'){
                DB::table('atten_rule_misspunch')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 0]);
                return response()->json('Updated False');
            }else{
                return response()->json($request->missPunchSwitch);
            }
        }

        if($request->gatePassSwitch)
        {
            if($request->gatePassSwitch == 'true'){
                DB::table('atten_rule_gatepass')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 1]);
                return response()->json('Updated True');
            }else if($request->gatePassSwitch == 'false'){
                DB::table('atten_rule_gatepass')->where('business_id', Session::get('business_id'))->update(['switch_is'=> 0]);
                return response()->json('Updated False');
            }else{
                return response()->json($request->gatePassSwitch);
            }
        }
        

        
        $splitedLateEntryGraceTime = explode(':',$request->lateEntryGraceTime);
        $splitedLateEntryOccurenceHour = explode(':',$request->lateEntryOccurenceHour);
        $splitedLateEntryMarkHalfDayMinutes = explode(':',$request->lateEntryMarkHalfDayMinutes);
        $splitedGraceTime = explode(':',$request->graceTime);
        $splitedEarlyExitOccurenceHour = explode(':',$request->earlyExitOccurenceHour);

        $splitedEarlyExitBy = explode(':',$request->earlyExitBy);
        $splitedExtraBreakTime = explode(':',$request->extraBreakTime);
        $splitedBreakOccurenceHour = explode(':',$request->breakOccurenceHour);
        $splitedEarlyOverTime = explode(':',$request->earlyOverTime);
        $splitedLateOverTime = explode(':',$request->lateOverTime);
        $splitedMinOverTime = explode(':',$request->minOverTime);
        $splitedMaxOverTime = explode(':',$request->maxOverTime);
        $splitedMissPunchOccurenceHour = explode(':',$request->missPunchOccurenceHour);
        $splitedGatePassOccurenceHour = explode(':',$request->gatePassOccurenceHour);
        
        // dd($request->extraBreakTime);

        // isset($splitedLateEntryMarkHalfDayMinutes[1]) ? dd($splitedLateEntryMarkHalfDayMinutes[1]) : dd('0');

        if($request->lateEntry == 'on'){
            $lateEntryData = DB::table('atten_rule_late_entry')->where('business_id', Session::get('business_id'))->first();
            if(!isset($lateEntryData)){
                $insertLateEntryData = DB::table('atten_rule_late_entry')->insert([
                    'switch_is'=>1,
                    'grace_time_hr'=> isset($request->lateEntryGraceTime) ? $splitedLateEntryGraceTime[0]: 0 ,
                    'grace_time_min'=> isset($request->lateEntryGraceTime) ? $splitedLateEntryGraceTime[1] : 0,
                    'occurance_is'=> $request->lateEntrySelectOccurance,
                    'occurance_count'=> $request->lateEntryOccurenceCount,
                    'occurance_hr'=> isset($request->lateEntryOccurenceHour) ? $splitedLateEntryOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->lateEntryOccurenceHour) ? $splitedLateEntryOccurenceHour[1] : 0,
                    'absent_is'=> $request->lateEntrySelectAbsent,
                    'mark_half_day_hr'=> isset($request->lateEntryMarkHalfDayMinutes) ? $splitedLateEntryMarkHalfDayMinutes[0] : 0,
                    'mark_half_day_min'=> isset($request->lateEntryMarkHalfDayMinutes) ? $splitedLateEntryMarkHalfDayMinutes[1] : 0,
                    'business_id'=> Session::get('business_id'),
                ]);

                if($insertLateEntryData){
                    Alert::success('Successfully Created');
                }
            }else{
                $updateLateEntryData = DB::table('atten_rule_late_entry')->where('business_id',Session::get('business_id'))->update([
                    'grace_time_hr'=> isset($request->lateEntryGraceTime) ? $splitedLateEntryGraceTime[0]: 0 ,
                    'grace_time_min'=> isset($request->lateEntryGraceTime) ? $splitedLateEntryGraceTime[1] : 0,
                    'occurance_is'=> $request->lateEntrySelectOccurance,
                    'occurance_count'=> $request->lateEntryOccurenceCount,
                    'occurance_hr'=> isset($request->lateEntryOccurenceHour) ? $splitedLateEntryOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->lateEntryOccurenceHour) ? $splitedLateEntryOccurenceHour[1] : 0,
                    'absent_is'=> $request->lateEntrySelectAbsent,
                    'mark_half_day_hr'=> isset($request->lateEntryMarkHalfDayMinutes) ? $splitedLateEntryMarkHalfDayMinutes[0] : 0,
                    'mark_half_day_min'=> isset($request->lateEntryMarkHalfDayMinutes) ? $splitedLateEntryMarkHalfDayMinutes[1] : 0,
                ]);

                if($updateLateEntryData){
                    Alert::success('Successfully Updated');
                }
            }
        }

        if($request->earlyExitBtn == 'on'){
            $earlyExitData = DB::table('atten_rule_early_exit')->where('business_id', Session::get('business_id'))->first();
            
            if(!isset($earlyExitData)){
                $insertEarlyExitData = DB::table('atten_rule_early_exit')->insert([
                    'switch_is'=>1,
                    'grace_time_hr'=> isset($request->graceTime) ? $splitedGraceTime[0] : 0,
                    'grace_time_min'=> isset($request->graceTime) ? $splitedGraceTime[1] : 0,
                    'occurance_is'=> $request->earlyExitSelectOccurence,
                    'occurance_count'=> $request->earlyExitOccurenceCount,
                    'occurance_hr'=> isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[1] : 1,
                    'absent_is'=> $request->earlyExitSelectAbsent,
                    'mark_half_day_hr'=> isset($request->earlyExitBy) ? $splitedEarlyExitBy[0] : 0,
                    'mark_half_day_min'=> isset($request->earlyExitBy) ? $splitedEarlyExitBy[1] : 0,
                    'business_id'=> Session::get('business_id'),
                ]);
                if($insertEarlyExitData){
                    Alert::success('Successfully Created');
                }
            }else {
                $updateEarlyExitData = DB::table('atten_rule_early_exit')->where('business_id',Session::get('business_id'))->update([
                    
                    'grace_time_hr'=> isset($request->graceTime) ? $splitedGraceTime[0] : 0,
                    'grace_time_min'=> isset($request->graceTime) ? $splitedGraceTime[1] : 0,
                    'occurance_is'=> $request->earlyExitSelectOccurence,
                    'occurance_count'=> $request->earlyExitOccurenceCount,
                    'occurance_hr'=> isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[1] : 1,
                    'absent_is'=> $request->earlyExitSelectAbsent,
                    'mark_half_day_hr'=> isset($request->earlyExitBy) ? $splitedEarlyExitBy[0] : 0,
                    'mark_half_day_min'=> isset($request->earlyExitBy) ? $splitedEarlyExitBy[1] : 0,
                ]);
                if($updateEarlyExitData){
                    Alert::success('Successfully Updated');
                }
            }
            
        }

        if($request->overtime == 'on'){
            $overtimeData = DB::table('atten_rule_overtime')->where('business_id', Session::get('business_id'))->first();
            if(!isset($overtimeData)){
                $insertOvertimeData = DB::table('atten_rule_overtime')->insert([
                    'switch_is'=>1,
                    'early_ot_hr'=> isset($request->earlyOverTime) ? $splitedEarlyOverTime[0] : 0,
                    'early_ot_min'=> isset($request->earlyOverTime) ? $splitedEarlyOverTime[1] : 0,
                    'late_ot_hr'=> isset($request->lateOverTime) ? $splitedLateOverTime[0] : 0,
                    'late_ot_min'=> isset($request->lateOverTime) ? $splitedLateOverTime[1] : 0,
                    'min_ot_hr'=> isset($request->minOverTime) ? $splitedMinOverTime[0] : 0,
                    'min_ot_min'=> isset($request->minOverTime) ? $splitedMinOverTime[1] : 0,
                    'max_ot_hr'=> isset($request->maxOverTime) ? $splitedMaxOverTime[0] : 0,
                    'max_ot_min'=> isset($request->maxOverTime) ? $splitedMaxOverTime[1] : 0,
                    'business_id'=> Session::get('business_id'),
                ]);

                if($insertOvertimeData){
                    Alert::success('Successfully Created');
                }
            }else{
                $updateOvertimeData = DB::table('atten_rule_overtime')->where('business_id', Session::get('business_id'))->update([
                    'early_ot_hr'=> isset($request->earlyOverTime) ? $splitedEarlyOverTime[0] : 0,
                    'early_ot_min'=> isset($request->earlyOverTime) ? $splitedEarlyOverTime[1] : 0,
                    'late_ot_hr'=> isset($request->lateOverTime) ? $splitedLateOverTime[0] : 0,
                    'late_ot_min'=> isset($request->lateOverTime) ? $splitedLateOverTime[1] : 0,
                    'min_ot_hr'=> isset($request->minOverTime) ? $splitedMinOverTime[0] : 0,
                    'min_ot_min'=> isset($request->minOverTime) ? $splitedMinOverTime[1] : 0,
                    'max_ot_hr'=> isset($request->maxOverTime) ? $splitedMaxOverTime[0] : 0,
                    'max_ot_min'=> isset($request->maxOverTime) ? $splitedMaxOverTime[0] : 0,
                ]);
                if($updateOvertimeData){
                    Alert::success('Successfully Updated');
                }
            }
            
        }

        if($request->breakBtn == 'on'){
            $breakData = DB::table('atten_rule_break')->where('business_id', Session::get('business_id'))->first();
            if(!isset($breakData)){
                $insertBreakData = DB::table('atten_rule_break')->insert([
                    'switch_is'=>1,
                    'is_break_hr_deduct'=> $request->defaultBreak,
                    'break_extra_hr'=> isset($request->extraBreakTime) ? $splitedExtraBreakTime[0] : 0,
                    'break_extra_min'=> isset($request->extraBreakTime) ? $splitedExtraBreakTime[1] : 0,
                    'occurance_is'=> $request->breakSelectOccurence,
                    'occurance_hr'=> isset($request->breakOccurenceHour) ? $splitedBreakOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->breakOccurenceHour) ? $splitedBreakOccurenceHour[1] : 0,
                    'occurance_count'=> $request->breakOccurenceCount,
                    'absent_is'=> $request->breakSelectAbsent,
                    'business_id'=> Session::get('business_id'),
                ]);
                if($insertBreakData){
                    Alert::success('Successfully Created');
                }
            }else{
                $updateBreakData = DB::table('atten_rule_break')->where('business_id', Session::get('business_id'))->update([
                    'is_break_hr_deduct'=> $request->defaultBreak,
                    'break_extra_hr'=> isset($request->extraBreakTime) ? $splitedExtraBreakTime[0] : 0,
                    'break_extra_min'=> isset($request->extraBreakTime) ? $splitedExtraBreakTime[1] : 0,
                    'occurance_is'=> $request->breakSelectOccurence,
                    'occurance_hr'=> isset($request->breakOccurenceHour) ? $splitedBreakOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->breakOccurenceHour) ? $splitedBreakOccurenceHour[1] : 0,
                    'occurance_count'=> $request->breakOccurenceCount,
                    'absent_is'=> $request->breakSelectAbsent,
                ]);
                if($updateBreakData){
                    Alert::success('Successfully Updated');
                }
            }
            
        }

        if($request->missPunch == 'on') {
            $missPunchData = DB::table('atten_rule_misspunch')->where('business_id', Session::get('business_id'))->first();
            
            if(!isset($missPunchData)){
                $insertMissPunchData = DB::table('atten_rule_misspunch')->insert([
                    'switch_is'=>1,
                    'occurance_is'=> $request->missPunchSelectOccurence,
                    'occurance_count'=> $request->missPunchOccurenceCount,
                    'occurance_hr'=> isset($request->missPunchOccurenceHour) ? $splitedMissPunchOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->missPunchOccurenceHour) ? $splitedMissPunchOccurenceHour[1] : 0,
                    'absent_is'=> $request->missPunchSelectAbsent,
                    'business_id'=> Session::get('business_id'),
                ]);

                if($insertMissPunchData){
                    Alert::success('Successfully Created');
                }
            }else{
                $updateMissPunchData = DB::table('atten_rule_misspunch')->where('business_id', Session::get('business_id'))->update([
                    'occurance_is'=> $request->missPunchSelectOccurence,
                    'occurance_count'=> $request->missPunchOccurenceCount,
                    'occurance_hr'=> isset($request->missPunchOccurenceHour) ? $splitedMissPunchOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->missPunchOccurenceHour) ? $splitedMissPunchOccurenceHour[1] : 0,
                    'absent_is'=> $request->missPunchSelectAbsent,
                ]);

                if($updateMissPunchData){
                    Alert::success('Successfully Created');
                }
            }
        }

        if($request->gatePass == 'on') {
            $gatePassData = DB::table('atten_rule_gatepass')->where('business_id', Session::get('business_id'))->first();
            
            if(!isset($gatePassData)){
                $insertGatePassData = DB::table('atten_rule_gatepass')->insert([
                    'switch_is'=>1,
                    'occurance_is'=> $request->gatePassSelectOccurence,
                    'occurance_count'=> $request->gatePassOccurenceCount,
                    'occurance_hr'=> isset($request->gatePassOccurenceHour) ? $splitedGatePassOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->gatePassOccurenceHour) ? $splitedGatePassOccurenceHour[1] : 0,
                    'absent_is'=> $request->gatePasSelectAbsent,
                    'business_id'=> Session::get('business_id'),
                ]);
    
                if($insertGatePassData){
                    Alert::success('Successfully Created');
                }
            }else{
                $updateGatePassData = DB::table('atten_rule_gatepass')->where('business_id', Session::get('business_id'))->update([
                    'occurance_is'=> $request->gatePassSelectOccurence,
                    'occurance_count'=> $request->gatePassOccurenceCount,
                    'occurance_hr'=> isset($request->gatePassOccurenceHour) ? $splitedGatePassOccurenceHour[0] : 0,
                    'occurance_min'=> isset($request->gatePassOccurenceHour) ? $splitedGatePassOccurenceHour[1] : 0,
                    'absent_is'=> $request->gatePasSelectAbsent,
                ]);

                if($updateGatePassData){
                    Alert::success('Successfully Updated');
                }
            }
            
        }

        return back();
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
