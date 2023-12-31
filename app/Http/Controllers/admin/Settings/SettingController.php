<?php

namespace App\Http\Controllers\admin\Settings;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\Models\LoginAdmin;
use App\Models\CameraPermission;
use App\Models\LoginEmployee;
use App\Models\PendingAdmin;
use App\Models\ModelHasPermission;
use App\Models\PolicyHolidayDetail;
use App\Models\AdminNotice;
use App\Models\BusinessDetailsList;
use App\Models\RequestLeaveList;
use App\Models\RequestMispunchList;
use App\Models\BranchList;
use App\Models\PolicyAttendanceTrackInOut;
use App\Models\RequestGatepassList;
use App\Models\DesignationList;
use App\Models\PolicyAttendanceMode;
use App\Models\PolicyWeeklyHolidayList;
use App\Models\AttendanceList;
use App\Models\EmployeePersonalDetail;
use App\Models\StaticSidebarMenu;
use App\Models\PolicyAttendanceShiftSetting;
use App\Models\PolicySettingRoleCreate;
use App\Models\DepartmentList;
use App\Models\PolicyAttenRuleBreak;
use App\Models\PolicyAttenRuleEarlyExit;
use App\Models\PolicyAttenRuleGatepass;
use App\Models\PolicyAttenRuleLateEntry;
use App\Models\PolicyAttenRuleMisspunch;
use App\Models\PolicyAttenRuleOvertime;
use App\Models\PolicyHolidayTemplate;
use App\Models\PolicySettingRoleItem;
use App\Models\PolicySettingLeavePolicy;
use App\Models\PolicySettingRoleAssignPermission;
use App\Models\PolicyAttendanceShiftTypeItem;
use App\Models\PolicySettingLeaveCategory;
use App\Models\StaticBusinessTypeList;
use App\Models\StaticBusinessCategoriesList;
use App\Models\PolicyMasterEndgameMethod;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Central_unit;
use Carbon\Carbon;
use File;
use App\Models\admin\setupsettings\MasterEndGameModel;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Http\Request;
use Dipesh79\LaravelPhonePe\LaravelPhonePe;

// Use Alert;

class SettingController extends Controller
{
    public $loadb;
    public function __construct()
    {
        // $load =;//Session::put('load_checked', );
        $this->loadb = Session::get('business_id'); //"e3d64177e51bdff82b499e116796fe74";
    }

    public function cameraAccess()
    {
        $modes = DB::table("static_attendance_methods")->get();
        $bName = DB::table("business_details_list")->where("business_id", Session::get('business_id'))->first('business_name');
        $cameraAccess = DB::table("camera_permission")
            ->where("camera_permission.business_id", Session::get('business_id'))
            ->leftJoin('static_attendance_methods', 'camera_permission.mode_check', '=', 'static_attendance_methods.id')
            ->orderBy('camera_permission.id', 'DESC')
            ->select('camera_permission.*', 'static_attendance_methods.id as attmethodid', 'static_attendance_methods.method_name')
            ->get();
        return view("admin.setting.attendance.cameraAccess", compact(['bName', 'cameraAccess', 'modes']));
    }

    public function accessCamera(Request $request)
    {
        // dd($request->all());
        if ($request->has('mode') && $request->has('imei')) {
            $accessRequest = DB::table('camera_permission')->insert([
                'mode_check' => $request->mode,
                'business_check' => 1,
                'branch_check' => 0,
                'business_id' => Session::get('business_id'),
                'mobile_ip' => $request->ip,
                'imei_number' => $request->imei,
                'check_camera' => $request->cameraAccess == 'on' ? 1 : 0,
            ]);

            if ($accessRequest) {
                Alert::success('Successfully Added Camera Permission')->persistent(true);
            } else {
                Alert::error('Failed Not !')->persistent(true);
            }

            return redirect('admin/settings/attendance/camera-access');
        }
    }

        // public function editCameraAccessDataGet(Request $request)
        // {
        //     $data = CameraPermission::where('id', $request->id)->get();
        //     return response()->json(['get' => $data]);
        // }

    public function updateCamera(Request $request)
    {

        // dd($request->all());

        $updateAccessRequest = DB::table('camera_permission')->where(['business_id' => Session::get('business_id'), 'id' => $request->id])->update([
            'mode_check' => $request->updatemode,
            'mobile_ip' => $request->updateip,
            'imei_number' => $request->updateimei,
            'check_camera' => $request->updatecameraAccess == 'on' ? 1 : 0,
        ]);

        if (isset($updateAccessRequest)) {
            Alert::success('Successfully Update Camera Permission');
        } else {
            Alert::error('Failed');
        }

        return redirect('admin/settings/attendance/camera-access');
    }

    public function removeCamera(Request $request, $id)
    {
        if ($id) {
            $removeCameraAccess = DB::table('camera_permission')->where(
                [
                    'id' => $id,
                    'business_id' => Session::get('business_id'),
                ]
            )->delete();

            if ($removeCameraAccess) {
                Alert::success('Successfully Removed')->persistent(true);
            } else {
                Alert::error('Failed')->persistent(true);
            }
        }

        return redirect('admin/settings/attendance/camera-access');
    }

    public function index()
    {
        return view('admin.setting.setting');
    }

    // Attendance Mode setting functions

    public function setAttendaceMode(Request $request)
    {
        $final_value = [];
        // dd($request->all());

        if ($request->premisesActive === "on") {
            $final_value[] = 1;
        }
        if ($request->outDoorActive === "on") {
            $final_value[] = 2;
        }
        if ($request->wfhActive === "on") {
            $final_value[] = 3;
        }

        // print_r($final_value);


        $isPresent = PolicyAttendanceMode::where('business_id', $request->session()->get('business_id'))
            ->get();

        if ($isPresent->count() == 0) {
            $setMode = DB::table('policy_attendance_mode')->insert([
                'business_id' => $request->session()->get('business_id'),
                'attendance_active_methods' => json_encode($final_value),
                'office_auto' => ($request->premisesIsAuto != 0 && $request->premisesActive === "on") ? $request->premisesIsAuto : 0,
                'office_manual' => ($request->premisesIsAuto == 0 && $request->premisesActive === "on") ? 1 : 0,
                'office_qr' => ($request->premisesQR != null && $request->premisesActive === "on") ? $request->premisesQR : 0,
                'office_face_id' => ($request->premisesFaceId != null && $request->premisesActive === "on") ? $request->premisesFaceId : 0,
                'office_selfie' => ($request->premisesSelfie != null && $request->premisesActive === "on") ? $request->premisesSelfie : 0,
                'outdoor_auto' => ($request->outIsAuto != 0 && $request->outDoorActive === "on") ? $request->outIsAuto : 0,
                'outdoor_manual' => ($request->outIsAuto == 0 && $request->outDoorActive === "on") ? 1 : 0,
                'outdoor_selfie' => ($request->outSelfie != null && $request->outDoorActive === "on") ? $request->outSelfie : 0,
                'wfh_auto' => ($request->wfhIsAuto != 0 && $request->wfhActive === "on") ? $request->wfhIsAuto : 0,
                'wfh_manual' => ($request->wfhIsAuto == 0 && $request->wfhActive === "on") ? 1 : 0,
                'wfh_selfie' => ($request->wfhSelfie != null && $request->wfhActive === "on") ? $request->wfhSelfie : 0,
                'updated_at' => now(),

            ]);

            if ($setMode) {
                Alert::success('Successfully Created Attendance Mode Active', '')->persistent(true);
            } else {
                Alert::error('Failed', '')->persistent(true);
            }
        } else {
            $updateMode = DB::table('policy_attendance_mode')
                ->where(['business_id' => $request->session()->get('business_id')])
                ->update([
                    'business_id' => $request->session()->get('business_id'),
                    'attendance_active_methods' => json_encode($final_value),
                    'office_auto' => ($request->premisesIsAuto != 0 && $request->premisesActive === "on") ? $request->premisesIsAuto : 0,
                    'office_manual' => ($request->premisesIsAuto == 0 && $request->premisesActive === "on") ? 1 : 0,
                    'office_qr' => ($request->premisesQR != null && $request->premisesActive === "on") ? $request->premisesQR : 0,
                    'office_face_id' => ($request->premisesFaceId != null && $request->premisesActive === "on") ? $request->premisesFaceId : 0,
                    'office_selfie' => ($request->premisesSelfie != null && $request->premisesActive === "on") ? $request->premisesSelfie : 0,
                    'outdoor_auto' => ($request->outIsAuto != 0 && $request->outDoorActive === "on") ? $request->outIsAuto : 0,
                    'outdoor_manual' => ($request->outIsAuto == 0 && $request->outDoorActive === "on") ? 1 : 0,
                    'outdoor_selfie' => ($request->outSelfie != null && $request->outDoorActive === "on") ? $request->outSelfie : 0,
                    'wfh_auto' => ($request->wfhIsAuto != 0 && $request->wfhActive === "on") ? $request->wfhIsAuto : 0,
                    'wfh_manual' => ($request->wfhIsAuto == 0 && $request->wfhActive === "on") ? 1 : 0,
                    'wfh_selfie' => ($request->wfhSelfie != null && $request->wfhActive === "on") ? $request->wfhSelfie : 0,
                    'updated_at' => now(),
                ]);

            if ($updateMode) {
                Alert::success('Successfully Updated Attendance Mode Active', '')->persistent(true);
            } else {
                Alert::error('Failed', '')->persistent(true);
            }
        }

        // return redirect()->to('/admin/settings/attendance/mode');

        // return Redirect::back();
        return self::attendance();
    }

    // account setting
    public function account()
    {
        // dd($request->all());
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))
            ->first();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        return view('admin.setting.account.account', compact('permissions', 'moduleName', 'accDetail'));
    }

    public function BusinessDetail(Request $request)
    {
        $BAddDetail = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();

        return response()->json(['get' => $BAddDetail]);
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
        // dd($request->all());
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
                Alert::success('Data Updated', 'Updated  Created')->persistent(true);


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

        if (isset($branch)) {
            Alert::success('Data Updated', 'Updated  Created')->persistent(true);
            return back();
        } else {
            return back();
        }
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


    public function subscription()
    {
        // echo $request->all();
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
        return view('admin.subscription.subscription',compact('accDetail'));
    }


    function callExternalData()
    {
        return 'xyz';
    }

    public function phonePe()
    {
        $phonepe = new LaravelPhonePe();
        $amount = 1000; // Specify the payment amount
        $mobileNumber = '9999999999'; // User's mobile number
        $redirectUrl = url('response');

        $url = $phonepe->makePayment($amount, $mobileNumber, $redirectUrl);

        return redirect()->away($url);
    }

    public function responseSubmit(Request $request)
    {
        $phonepe = new LaravelPhonePe();
        $response = $phonepe->getTransactionStatus($request->all());

        if ($response == true) {
            // Payment Success
            dd($response);
        } else {
            // Payment Failed
            // Handle the failed payment scenario here
        }
    }


    public function companyDetails(Request $request)
    {
        return view('admin.subscription.companies');
    }

    public function nameupdate(Request $request)
    {
        // dd($request->all());
        $branch = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['client_name' => $request->name]);
        // return $branch;
        // return back();
        // if (isset($data)) {
        //     Alert::success('Update Weekly Holidays')->persistent(true);
        // } else {
        //     Alert::info('Not Update Weely Holidays')->persistent(true);
        if ($branch) {
            Alert::success('Update Name')->persistent(true);
        } else {
            Alert::info('Not Updated Name')->persistent(true);
        }
        return redirect()->route('account.settings');
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

    public function allRotationalShift(Request $request)
    {
        $branch_ID = $request->brand_id;
        $get = PolicyAttendanceShiftTypeItem::join('policy_attendance_shift_settings', 'policy_attendance_shift_settings.id', '=', 'policy_attendance_shift_type_items.attendance_shift_id')
            ->where('policy_attendance_shift_type_items.attendance_shift_id', $branch_ID)->where('policy_attendance_shift_type_items.business_id', Session::get('business_id'))
            ->select('policy_attendance_shift_settings.shift_type', 'policy_attendance_shift_type_items.*')
            ->get();

        // $get = DepartmentList::where('branch_id', $branch_ID)->where('b_id', Session::get('business_id'))->get();
        return response()->json(['department' => $get]);
    }

    public function allFilterDepartment(Request $request)
    {
        $branch_ID = $request->brand_id;
        $get = EmployeePersonalDetail::join('department_list', 'department_list.depart_id', '=', 'employee_personal_details.department_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('employee_personal_details.department_id as depart_id', 'department_list.depart_name')
            ->distinct()
            ->get();
        return response()->json(['department' => $get]);
    }

    public function allFilterDesignation(Request $request)
    {
        // return "chal";
        // $branch_ID = $request->brand_id; 
        $branch_ID = $request->branch_id;
        $get = EmployeePersonalDetail::join('designation_list', 'designation_list.desig_id', '=', 'employee_personal_details.designation_id')
            ->where('employee_personal_details.branch_id', $branch_ID)
            ->where('employee_personal_details.department_id', $request->depart_id)
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->select('designation_list.desig_id', 'designation_list.desig_name')
            ->distinct()
            ->get();
        return response()->json(['designation' => $get]);
    }

    // designationDetails ajax list shows
    public function allDepartment(Request $request)
    {
        // ::where('branch_id', $branch_ID)
        $branch_ID = $request->brand_id;
        $get = DepartmentList::where('b_id', Session::get('business_id'))->get();
        return response()->json(['department' => $get]);
    }
    public function allDesignation(Request $request)
    {
        // 
        // ->where('department_id', $request->depart_id)
        $get = DB::table('designation_list')
            ->where('business_id', Session::get('business_id'))
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
            'address' => $request->location,
            'logitude' => $request->logitude,
            'latitude' => $request->latitude
        ];
        $addBranch = DB::table('branch_list')->insert($data);

        if ($addBranch) {
            Alert::success('Added Success', 'Create Branch Successfully');
        }
        // dd($request->all());
        return redirect()->route('admin.branch');
    }

    public function AddDepartment(Request $request)
    {
        // dd($request);
        $department = new DepartmentList();
        $department->b_id = Session::get('business_id');
        $department->depart_name = $request->department;
        // $department->branch_id = $request->branch;
        $department->status = 0;
        if ($department->save()) {
            Alert::success('Added Success', 'Create Department Name Successfully')->persistent(true);
        }
        return redirect()->route('admin.department');
    }
    public function AddDesignation(Request $request)
    {
        $designation = new DesignationList();
        $designation->business_id = $request->session()->get('business_id');
        $designation->desig_name = $request->designation;
        // $designation->department_id = $request->department;
        // $designation->branch_id = $request->branch;

        if ($designation->save()) {
            Alert::success('Added Success', 'Create Designation Name Successfully')->persistent(true);
        }
        return redirect()->route('admin.designation');
    }

    // update Functions
    public function UpdateBranch(Request $request)
    {
        $branch = DB::table('branch_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update([
                'branch_name' => $request->editbranch,
                'address' => $request->editaddress,
                'logitude' => $request->logitudeedit,
                'latitude' => $request->latitudeedit
            ]);

        if ($branch) {
            Alert::success('Data Updated', 'Updated  Created')->persistent(true);
            return redirect()->route('admin.branch');
        }
    }
    public function UpdateDepartment(Request $request)
    {
        $department = DepartmentList::where('depart_id', $request->editid)
            ->where('b_id', $request->session()->get('business_id'))
            ->update([
                'b_id' => $request->session()->get('business_id'),
                // 'branch_id' => $request->editbranch,
                'depart_name' => $request->editdepartment,
            ]);

        if ($department) {
            Alert::success('Data Department Updated', 'Updated Department Created')->persistent(true);
        } else {
            Alert::info('Not Updated Department')->persistent(true);
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
                // 'branch_id' => $request->editbranch,
                // 'department_id' => $request->editdepartment,
                'desig_name' => $request->editdesignation,
            ]);
        if ($designation) {
            Alert::success('Data Designation Updated', 'Updated Designation Created')->persistent(true);
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
            Alert::warning('Data Persent', 'Department also  created')->persistent(true);
        }
        if (!isset($departmentList)) {
            // echo "empty hy ayh";
            $roos = DB::table('branch_list')
                ->where('id', $id)
                ->delete();
            // if (isset($roos)) {
            Alert::success(' Delete Success', 'Your Added Delete Successfully')->persistent(true);
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
            Alert::success(' Delete Success', 'Your Added Delete Successfully')->persistent(true);
            // }
        }
        return redirect()->route('admin.department');
    }

    public function DeleteDesignation($id)
    {
        $designation = DesignationList::where('desig_id', $id)->delete();
        // dd($designation);
        if ($designation) {
            Alert::success('Delete Success', 'Delete Desgination Successfully')->persistent(true);
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

        $Leaves = PolicySettingLeaveCategory::where('business_id', $request->session()->get('business_id'))
            ->get();
        $leavePolicy = PolicySettingLeavePolicy::where('business_id', Session::get('business_id'))
            ->get();
        // dd($leavePolicy);
        return view('admin.setting.business.leave_policy.leave_policy', compact('leavePolicy', 'Leaves', 'BranchList', 'permissions', 'moduleName'));
    }
    // aJAX JAY
    public function allLeavePolicy(Request $request)
    {
        $send = PolicySettingLeaveCategory::where('leave_policy_id', $request->leave_policy_id)
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
        // Delete existing records for the given leave policy and busine
        $check = PolicySettingLeaveCategory::where('leave_policy_id', $leaveID)
            ->where('business_id', $bID)
            ->delete();

        // Check if records were successfully deleted
        if (isset($check)) {
            PolicySettingLeavePolicy::where('id', $leaveID)
                ->where('business_id', $bID)
                ->update(['policy_name' => $policyName]);
            // Assuming $request->updated_items is an array of updated items
            $updatedItems = $request->input('updated_items');

            // Insert the updated items into the table
            foreach ($updatedItems as $item) {
                PolicySettingLeaveCategory::insert([
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
        $deleteTemp = PolicySettingLeavePolicy::where('id', $request->poli_id)
            ->delete();
        $deleteLeaves = PolicySettingLeaveCategory::where('leave_policy_id', $request->poli_id)
            ->delete();

        if (isset($deleteTemp) && isset($deleteLeaves)) {
            Alert::success('Successfully Deleted Leave-Policy ')->persistent(true);
        } else {
            Alert::error('Failed')->persistent(true);
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
        //         $leave = PolicySettingLeaveCategory::insert([
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
        $truechecking_id = DB::table('policy_setting_leave_policy')->insert($storeData);
        // dd($truechecking_id);
        if ($truechecking_id) {
            $latestID = PolicySettingLeavePolicy::latest()
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
                    PolicySettingLeaveCategory::insert($collectionDataSet);
                }
            }
            Alert::success('Added', 'Your Leave-Policy Added Successfully')->persistent(true);
        } else {
            Alert::info('Not Added', 'Your Leave-Policy Not Added')->persistent(true);
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
        $data = PolicyWeeklyHolidayList::where('business_id', Session::get('business_id'))->get();

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
        $days = PolicyWeeklyHolidayList::where('business_id', Session::get('business_id'))
            ->where('id', $request->holiday_weekly_id)
            ->get();

        return response()->json(['get' => $days]);
    }
    public function createWeeklyHoliday(Request $request)
    {
        $data = new PolicyWeeklyHolidayList();
        // return back();
        $data->business_id = Session::get('business_id');
        $data->name = $request->templatename;
        $data->days = json_encode($request->days);
        if ($data->save()) {
            Alert::success('Create Weekly Holidays')->persistent(true);
        } else {
            Alert::info('Not Create Weely Holidays')->persistent(true);
        }
        return back();
    }
    public function updateWeeklyHoliday(Request $request)
    {
        $data = DB::table('policy_weekly_holiday_list')
            ->where('id', $request->id)
            ->where('business_id', Session::get('business_id'))
            ->update(['name' => $request->edit_weekname, 'days' => json_encode($request->holidays)]);
        if (isset($data)) {
            Alert::success('Update Weekly Holidays')->persistent(true);
        } else {
            Alert::info('Not Update Weely Holidays')->persistent(true);
        }
        return back();
    }
    public function deleteWeeklyHoliday(Request $request)
    {
        $data = DB::table('policy_weekly_holiday_list')
            ->where('id', $request->weekly_policy_id)
            ->where('business_id', Session::get('business_id'))
            ->delete();

        if (isset($data)) {
            Alert::success('Delete Weekly Holidays')->persistent(true);
        } else {
            Alert::info('Not Delete Weely Holidays')->persistent(true);
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
        $Track = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))
            ->first();

        $Modes = PolicyAttendanceMode::where('business_id', Session()->get('business_id'))
            ->first();
        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];

        $AttendanceData = RulesManagement::AttendaceMethodTypeCounter();

        // $BusinessDetails = $List[1];
        // $BranchList = $List[2];
        // $LeavePolicy = $List[3];
        // $HolidayPolicy = $List[4];
        // $weeklyPolicy = $List[5];
        // $attendanceModePolicy = $List[6];
        // $attendanceShiftPolicy = $List[7];
        // $attendanceTrackInOut = $List[8];
        return view('admin.setting.attendance.attendance', compact('Modes', 'Track', 'FinalEndGameRule', 'permissions', 'moduleName', 'AttendanceData'));
    }

    public function attendanceAccess()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];


        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];
        // $BusinessDetails = $List[1];
        // $BranchList = $List[2];
        // $LeavePolicy = $List[3];
        // $HolidayPolicy = $List[4];
        // $weeklyPolicy = $List[5];
        // $attendanceModePolicy = $List[6];
        // $attendanceShiftPolicy = $List[7];
        // $attendanceTrackInOut = $List[8];
        $EmployeeInfomation = $List[9];



        $BusinessDetails = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $AttMode = PolicyAttendanceMode::where('business_id', Session::get('business_id'))
            ->first();
        // $Temp = DB::table('attendance_access')
        //     ->where('business_id', Session::get('business_id'))
        //     ->get();

        return view('admin.setting.attendance.attendance_acccess', compact('permissions', 'moduleName', 'FinalEndGameRule', 'BusinessDetails', 'AttMode', 'EmployeeInfomation'));
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
                Alert::success('Access Created Successfully', '')->persistent(true);
            } else {
                Alert::error('Failed', '')->persistent(true);
            }
        } else {
            Alert::error('Failed', 'All Input fields are required')->persistent(true);
        }
        return response()->json($data);
    }
    public function deleteAttendanceAccess(Request $request)
    {
    }
    public function updateAttendanceAccess(Request $request)
    {
    }


    // End Games
    public function ActiveMode()
    {
        $accessPermission = Central_unit::AccessPermission();

        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];
        $BusinessDetails = $List[1];
        $BranchList = $List[2];
        $LeavePolicy = $List[3];
        $HolidayPolicy = $List[4];
        $weeklyPolicy = $List[5];
        $attendanceModePolicy = $List[6];
        $attendanceShiftPolicy = $List[7];
        $attendanceTrackInOut = $List[8];
        // dd($attendanceTrackInOut)
        // $attendaceShift = DB::table('policy_attendance_shift_settings')->get();
        // alert()->success('Success Title', 'Success Message');

        // alert()->success('Success Title', 'Success Message');
        // alert()->success('Success Title', 'Success Message');
        // Alert::success('Success', 'Updated Rule Method Successfully');

        // dd($FinalEndGameRule);
        $root = compact('moduleName', 'permissions', 'BusinessDetails', 'FinalEndGameRule', 'BranchList', 'LeavePolicy', 'HolidayPolicy', 'weeklyPolicy', 'attendanceModePolicy', 'attendanceShiftPolicy', 'attendanceTrackInOut');
        return view('admin.setting.active_rules.active_end_game', $root);
    }
    // End Games Rule Submit form
    public function FinalStartRuleEndGame(Request $request)
    {
        // $checking = DB::table('policy_master_endgame_method')
        //     ->where('business_id', $request->b_id)
        //     ->first();
        // if (isset($checking)) {
        //     Alert::error('Failed Final Rules Already Created!');
        // } else {
        // 'branch_id' => json_encode($request->input('branhcid')),
        $data = [
            'business_id' => $request->b_id,
            'method_name' => $request->methodname,
            'method_switch' => 0,
            'policy_preference' => $request->policypreference,
            'level_type' => 1,
            'leave_policy_ids_list' => json_encode($request->input('leavepolicy')),
            'holiday_policy_ids_list' => json_encode($request->input('holidaypolicy')),
            'weekly_policy_ids_list' => json_encode($request->input('weeklypolicy')),
            'shift_settings_ids_list' => json_encode($request->input('shiftsetting')),
        ];
        //  'attendance_mode_list' => json_encode($request->input("attendancemode")),
        //'track_in_out_ids_list' => json_encode($request->input("trackpunch"))

        $load = PolicyMasterEndgameMethod::insert($data);
        if (isset($load)) {
            Alert::success('Create Final Rules is Successfully')->persistent(true);
        } else {
            Alert::error('Failed Final Rules Created!')->persistent(true);
        }
        // }

        // 'depart_id	' => json_decode($request->input("depart_id")),
        // 'automation_rules_list' => json_encode($request->input("automationrules")),

        // return self::ActiveMode();
        return redirect()->to('admin/attendance/active_mode_set');
        // dd($leavePolicyIds);
    }

    // ajax getMasterRules
    public function getMasterRules(Request $request)
    {
        $load = PolicyMasterEndgameMethod::where(['id' => $request->e_id, 'business_id' => $request->b_id])
            ->first();
        return response()->json($load);
    }
    // edit_master_rule
    public function editMasterRules(Request $request)
    {
        // dd($request->all());
        // Start a database transaction
        DB::beginTransaction();
        try {
            // Find and delete the existing record based on business_id
            PolicyMasterEndgameMethod::where('business_id', $request->edit_bid)
                ->where('id', $request->edit_id)
                ->delete();

            // Create an array with the new data
            // 'branch_id' => json_encode($request->input('editbranhcid')),
            $data = [
                'business_id' => $request->edit_bid,
                'method_switch' => 1, //($request->switch != 0) ? $request->switch : 0
                'method_name' => $request->edit_mname,
                'policy_preference' => $request->editpolicypreference,
                'level_type' => 1,
                'leave_policy_ids_list' => json_encode($request->input('editleavepolicy')),
                'holiday_policy_ids_list' => json_encode($request->input('editholidaypolicy')),
                'weekly_policy_ids_list' => json_encode($request->input('editweeklypolicy')),
                'shift_settings_ids_list' => json_encode($request->input('editshiftsetting')),
            ];

            // Insert the new data into the database
            PolicyMasterEndgameMethod::insert($data);
            // Commit the transaction if all operations were successful
            DB::commit();
            Alert::success('Success', 'Your Final Rules Activation is Updated')->persistent(true);
            // return redirect()->route('attendance.activeMode');
        } catch (\Exception $e) {
            // Handle any exceptions and rollback the transaction if an error occurs
            DB::rollback();
            Alert::info('failed', 'Not Updating this record!' . $e->getMessage())->persistent(true);
            // Handle the error, log it, or return an error response
        }
        return redirect()->to('admin/attendance/active_mode_set');
        // return self::ActiveMode();
    }

    // mode_master_rule switch ON/OFF
    public function modeMasterRules(Request $request)
    {
        $loaded = PolicyMasterEndgameMethod::where(['business_id' => $request->b_id, 'id' => $request->e_id])
            ->update(['method_switch' => 1]);
        PolicyMasterEndgameMethod::where('business_id', $request->b_id)
            ->where('id', '!=', $request->e_id)
            ->update(['method_switch' => 0]);
        EmployeePersonalDetail::where('business_id', $request->b_id)
            ->update(['master_endgame_id' => $request->e_id]);
        return response()->json($loaded);
    }

    // parament delete_set
    public function deleteMasterRules(Request $request)
    {
        // dd($request->all());
        $load = PolicyMasterEndgameMethod::where('business_id', $request->bid)
            ->where('id', $request->eid)
            ->delete();
        if (isset($load)) {
            Alert::success('Delete Final Rules is Successfully')->persistent(true);
        } else {
            Alert::error('Failed Final Rules Not Deleted!')->persistent(true);
        }
        // Alert::success('Success Title', 'Success Message')->persistent(true);
        // return redirect('admin/attendance/active_mode_set')->with('success', 'Task Created Successfully!');
        // return self::ActiveMode();
        return redirect()->to('admin/attendance/active_mode_set');
        // return redirect()->to('');
        // return url('admin/attendance/active_mode_set');
    }




    // automation rule
    public function automation()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $lateEntryData = DB::table('policy_atten_rule_late_entry')->where('business_id', Session::get('business_id'))->first();
        $earlyExitData = DB::table('policy_atten_rule_early_exit')->where('business_id', Session::get('business_id'))->first();
        $overtimeData = DB::table('policy_atten_rule_overtime')->where('business_id', Session::get('business_id'))->first();
        $breakData = DB::table('policy_atten_rule_break')->where('business_id', Session::get('business_id'))->first();
        $missPunchData = DB::table('policy_atten_rule_misspunch')->where('business_id', Session::get('business_id'))->first();
        $gatePassData = DB::table('policy_atten_rule_gatepass')->where('business_id', Session::get('business_id'))->first();

        return view('admin.setting.attendance.automation', compact('permissions', 'moduleName', 'lateEntryData', 'earlyExitData', 'overtimeData', 'breakData', 'missPunchData', 'gatePassData'));
    }

    public function setAutomationRule(Request $request)
    {
        // dd($request->all());

        if ($request->dataLateEntry) {
            if ($request->dataLateEntry == 'true') {
                DB::table('policy_atten_rule_late_entry')->where('business_id', Session::get('business_id'))->update(['switch_is' => 1]);
                return response()->json(['Updated true']);
            } else if ($request->dataLateEntry == 'false') {
                DB::table('policy_atten_rule_late_entry')->where('business_id', Session::get('business_id'))->update(['switch_is' => 0]);
                return response()->json(['Updated false']);
            } else {
                return response()->json($request->dataLateEntry);
            }
        }

        if ($request->breakSwitch) {
            if ($request->breakSwitch == 'true') {
                DB::table('policy_atten_rule_break')->where('business_id', Session::get('business_id'))->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } else if ($request->breakSwitch == 'false') {
                DB::table('policy_atten_rule_break')->where('business_id', Session::get('business_id'))->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->breakSwitch);
            }
        }

        if ($request->earlyExitSwitch) {
            if ($request->earlyExitSwitch == 'true') {
                DB::table('policy_atten_rule_early_exit')->where('business_id', Session::get('business_id'))->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } else if ($request->earlyExitSwitch == 'false') {
                DB::table('policy_atten_rule_early_exit')->where('business_id', Session::get('business_id'))->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->earlyExitSwitch);
            }
        }

        if ($request->overtimeSwitch) {
            if ($request->overtimeSwitch == 'true') {
                DB::table('policy_atten_rule_overtime')->where('business_id', Session::get('business_id'))->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } else if ($request->overtimeSwitch == 'false') {
                DB::table('policy_atten_rule_overtime')->where('business_id', Session::get('business_id'))->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->overtimeSwitch);
            }
        }

        if ($request->missPunchSwitch) {
            if ($request->missPunchSwitch == 'true') {
                DB::table('policy_atten_rule_misspunch')->where('business_id', Session::get('business_id'))->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } else if ($request->missPunchSwitch == 'false') {
                DB::table('policy_atten_rule_misspunch')->where('business_id', Session::get('business_id'))->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->missPunchSwitch);
            }
        }

        if ($request->gatePassSwitch) {
            if ($request->gatePassSwitch == 'true') {
                DB::table('policy_atten_rule_gatepass')->where('business_id', Session::get('business_id'))->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } else if ($request->gatePassSwitch == 'false') {
                DB::table('policy_atten_rule_gatepass')->where('business_id', Session::get('business_id'))->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->gatePassSwitch);
            }
        }



        $splitedLateEntryGraceTime = explode(':', $request->lateEntryGraceTime);
        $splitedLateEntryOccurenceHour = explode(':', $request->lateEntryOccurenceHour);
        $splitedLateEntryMarkHalfDayMinutes = explode(':', $request->lateEntryMarkHalfDayMinutes);
        $splitedGraceTime = explode(':', $request->graceTime);
        $splitedEarlyExitOccurenceHour = explode(':', $request->earlyExitOccurenceHour);

        $splitedEarlyExitBy = explode(':', $request->earlyExitBy);
        $splitedExtraBreakTime = explode(':', $request->extraBreakTime);
        $splitedBreakOccurenceHour = explode(':', $request->breakOccurenceHour);
        $splitedEarlyOverTime = explode(':', $request->earlyOverTime);
        $splitedLateOverTime = explode(':', $request->lateOverTime);
        $splitedMinOverTime = explode(':', $request->minOverTime);
        $splitedMaxOverTime = explode(':', $request->maxOverTime);
        $splitedMissPunchOccurenceHour = explode(':', $request->missPunchOccurenceHour);
        $splitedGatePassOccurenceHour = explode(':', $request->gatePassOccurenceHour);

        // dd($splitedMaxOverTime);

        // isset($splitedLateEntryMarkHalfDayMinutes[1]) ? dd($splitedLateEntryMarkHalfDayMinutes[1]) : dd('0');

        if ($request->lateEntry == 'on') {
            $lateEntryData = DB::table('policy_atten_rule_late_entry')->where('business_id', Session::get('business_id'))->first();
            if (!isset($lateEntryData)) {
                $insertLateEntryData = DB::table('policy_atten_rule_late_entry')->insert([
                    'switch_is' => 1,
                    'grace_time_hr' => isset($request->lateEntryGraceTime) ? $splitedLateEntryGraceTime[0] : 0,
                    'grace_time_min' => isset($request->lateEntryGraceTime) ? $splitedLateEntryGraceTime[1] : 0,
                    'occurance_is' => $request->lateEntrySelectOccurance,
                    'occurance_count' => $request->lateEntryOccurenceCount,
                    'occurance_hr' => isset($request->lateEntryOccurenceHour) ? $splitedLateEntryOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->lateEntryOccurenceHour) ? $splitedLateEntryOccurenceHour[1] : 0,
                    'absent_is' => $request->lateEntrySelectAbsent,
                    'mark_half_day_hr' => isset($request->lateEntryMarkHalfDayMinutes) ? $splitedLateEntryMarkHalfDayMinutes[0] : 0,
                    'mark_half_day_min' => isset($request->lateEntryMarkHalfDayMinutes) ? $splitedLateEntryMarkHalfDayMinutes[1] : 0,
                    'business_id' => Session::get('business_id'),
                ]);

                if ($insertLateEntryData) {
                    Alert::success('Successfully Created');
                }
            } else {
                $updateLateEntryData = DB::table('policy_atten_rule_late_entry')->where('business_id', Session::get('business_id'))->update([
                    'grace_time_hr' => isset($request->lateEntryGraceTime) ? $splitedLateEntryGraceTime[0] : 0,
                    'grace_time_min' => isset($request->lateEntryGraceTime) ? $splitedLateEntryGraceTime[1] : 0,
                    'occurance_is' => $request->lateEntrySelectOccurance,
                    'occurance_count' => $request->lateEntryOccurenceCount,
                    'occurance_hr' => isset($request->lateEntryOccurenceHour) ? $splitedLateEntryOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->lateEntryOccurenceHour) ? $splitedLateEntryOccurenceHour[1] : 0,
                    'absent_is' => $request->lateEntrySelectAbsent,
                    'mark_half_day_hr' => isset($request->lateEntryMarkHalfDayMinutes) ? $splitedLateEntryMarkHalfDayMinutes[0] : 0,
                    'mark_half_day_min' => isset($request->lateEntryMarkHalfDayMinutes) ? $splitedLateEntryMarkHalfDayMinutes[1] : 0,
                ]);

                if ($updateLateEntryData) {
                    Alert::success('Successfully Updated')->persistent(true);
                }
            }
        }

        if ($request->earlyExitBtn == 'on') {
            $earlyExitData = DB::table('policy_atten_rule_early_exit')->where('business_id', Session::get('business_id'))->first();

            if (!isset($earlyExitData)) {
                $insertEarlyExitData = DB::table('policy_atten_rule_early_exit')->insert([
                    'switch_is' => 1,
                    'grace_time_hr' => isset($request->graceTime) ? $splitedGraceTime[0] : 0,
                    'grace_time_min' => isset($request->graceTime) ? $splitedGraceTime[1] : 0,
                    'occurance_is' => $request->earlyExitSelectOccurence,
                    'occurance_count' => $request->earlyExitOccurenceCount,
                    'occurance_hr' => isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[1] : 1,
                    'absent_is' => $request->earlyExitSelectAbsent,
                    'mark_half_day_hr' => isset($request->earlyExitBy) ? $splitedEarlyExitBy[0] : 0,
                    'mark_half_day_min' => isset($request->earlyExitBy) ? $splitedEarlyExitBy[1] : 0,
                    'business_id' => Session::get('business_id'),
                ]);
                if ($insertEarlyExitData) {
                    Alert::success('Successfully Created')->persistent(true);
                }
            } else {
                $updateEarlyExitData = DB::table('policy_atten_rule_early_exit')->where('business_id', Session::get('business_id'))->update([

                    'grace_time_hr' => isset($request->graceTime) ? $splitedGraceTime[0] : 0,
                    'grace_time_min' => isset($request->graceTime) ? $splitedGraceTime[1] : 0,
                    'occurance_is' => $request->earlyExitSelectOccurence,
                    'occurance_count' => $request->earlyExitOccurenceCount,
                    'occurance_hr' => isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[1] : 1,
                    'absent_is' => $request->earlyExitSelectAbsent,
                    'mark_half_day_hr' => isset($request->earlyExitBy) ? $splitedEarlyExitBy[0] : 0,
                    'mark_half_day_min' => isset($request->earlyExitBy) ? $splitedEarlyExitBy[1] : 0,
                ]);
                if ($updateEarlyExitData) {
                    Alert::success('Successfully Updated')->persistent(true);
                }
            }
        }

        if ($request->overtime == 'on') {
            $overtimeData = DB::table('policy_atten_rule_overtime')->where('business_id', Session::get('business_id'))->first();
            if (!isset($overtimeData)) {
                $insertOvertimeData = DB::table('policy_atten_rule_overtime')->insert([
                    'switch_is' => 1,
                    'early_ot_hr' => isset($request->earlyOverTime) ? $splitedEarlyOverTime[0] : 0,
                    'early_ot_min' => isset($request->earlyOverTime) ? $splitedEarlyOverTime[1] : 0,
                    'late_ot_hr' => isset($request->lateOverTime) ? $splitedLateOverTime[0] : 0,
                    'late_ot_min' => isset($request->lateOverTime) ? $splitedLateOverTime[1] : 0,
                    'min_ot_hr' => isset($request->minOverTime) ? $splitedMinOverTime[0] : 0,
                    'min_ot_min' => isset($request->minOverTime) ? $splitedMinOverTime[1] : 0,
                    'max_ot_hr' => isset($request->maxOverTime) ? $splitedMaxOverTime[0] : 0,
                    'max_ot_min' => isset($request->maxOverTime) ? $splitedMaxOverTime[1] : 0,
                    'business_id' => Session::get('business_id'),
                ]);

                if ($insertOvertimeData) {
                    Alert::success('Successfully Created')->persistent(true);
                }
            } else {
                $updateOvertimeData = DB::table('policy_atten_rule_overtime')->where('business_id', Session::get('business_id'))->update([
                    'early_ot_hr' => isset($request->earlyOverTime) ? $splitedEarlyOverTime[0] : 0,
                    'early_ot_min' => isset($request->earlyOverTime) ? $splitedEarlyOverTime[1] : 0,
                    'late_ot_hr' => isset($request->lateOverTime) ? $splitedLateOverTime[0] : 0,
                    'late_ot_min' => isset($request->lateOverTime) ? $splitedLateOverTime[1] : 0,
                    'min_ot_hr' => isset($request->minOverTime) ? $splitedMinOverTime[0] : 0,
                    'min_ot_min' => isset($request->minOverTime) ? $splitedMinOverTime[1] : 0,
                    'max_ot_hr' => isset($request->maxOverTime) ? $splitedMaxOverTime[0] : 0,
                    'max_ot_min' => isset($request->maxOverTime) ? $splitedMaxOverTime[1] : 0,
                ]);
                if ($updateOvertimeData) {
                    Alert::success('Successfully Updated')->persistent(true);
                }
            }
        }

        if ($request->breakBtn == 'on') {
            $breakData = DB::table('policy_atten_rule_break')->where('business_id', Session::get('business_id'))->first();
            if (!isset($breakData)) {
                $insertBreakData = DB::table('policy_atten_rule_break')->insert([
                    'switch_is' => 1,
                    'is_break_hr_deduct' => $request->defaultBreak,
                    'break_extra_hr' => isset($request->extraBreakTime) ? $splitedExtraBreakTime[0] : 0,
                    'break_extra_min' => isset($request->extraBreakTime) ? $splitedExtraBreakTime[1] : 0,
                    'occurance_is' => $request->breakSelectOccurence,
                    'occurance_hr' => isset($request->breakOccurenceHour) ? $splitedBreakOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->breakOccurenceHour) ? $splitedBreakOccurenceHour[1] : 0,
                    'occurance_count' => $request->breakOccurenceCount,
                    'absent_is' => $request->breakSelectAbsent,
                    'business_id' => Session::get('business_id'),
                ]);
                if ($insertBreakData) {
                    Alert::success('Successfully Created')->persistent(true);
                }
            } else {
                $updateBreakData = DB::table('policy_atten_rule_break')->where('business_id', Session::get('business_id'))->update([
                    'is_break_hr_deduct' => $request->defaultBreak,
                    'break_extra_hr' => isset($request->extraBreakTime) ? $splitedExtraBreakTime[0] : 0,
                    'break_extra_min' => isset($request->extraBreakTime) ? $splitedExtraBreakTime[1] : 0,
                    'occurance_is' => $request->breakSelectOccurence,
                    'occurance_hr' => isset($request->breakOccurenceHour) ? $splitedBreakOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->breakOccurenceHour) ? $splitedBreakOccurenceHour[1] : 0,
                    'occurance_count' => $request->breakOccurenceCount,
                    'absent_is' => $request->breakSelectAbsent,
                ]);
                if ($updateBreakData) {
                    Alert::success('Successfully Updated')->persistent(true);
                }
            }
        }

        if ($request->missPunch == 'on') {
            $missPunchData = DB::table('policy_atten_rule_misspunch')->where('business_id', Session::get('business_id'))->first();

            if (!isset($missPunchData)) {
                $insertMissPunchData = DB::table('policy_atten_rule_misspunch')->insert([
                    'switch_is' => 1,
                    'occurance_is' => $request->missPunchSelectOccurence,
                    'occurance_count' => $request->missPunchOccurenceCount,
                    'occurance_hr' => isset($request->missPunchOccurenceHour) ? $splitedMissPunchOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->missPunchOccurenceHour) ? $splitedMissPunchOccurenceHour[1] : 0,
                    'absent_is' => $request->missPunchSelectAbsent,
                    'request_day' => $request->missPunchRequestDay ?? 0,
                    'request_day_absent_is' => $request->missPunchDaySelectAbsent ?? 0,
                    'business_id' => Session::get('business_id'),
                ]);

                if ($insertMissPunchData) {
                    Alert::success('Successfully Created')->persistent(true);
                }
            } else {
                $updateMissPunchData = DB::table('policy_atten_rule_misspunch')->where('business_id', Session::get('business_id'))->update([
                    'occurance_is' => $request->missPunchSelectOccurence,
                    'occurance_count' => $request->missPunchOccurenceCount,
                    'occurance_hr' => isset($request->missPunchOccurenceHour) ? $splitedMissPunchOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->missPunchOccurenceHour) ? $splitedMissPunchOccurenceHour[1] : 0,
                    'absent_is' => $request->missPunchSelectAbsent,
                    'request_day' => $request->missPunchRequestDay ?? 0,
                    'request_day_absent_is' => $request->missPunchDaySelectAbsent ?? 0,
                ]);

                if ($updateMissPunchData) {
                    Alert::success('Successfully Created')->persistent(true);
                }
            }
        }

        if ($request->gatePass == 'on') {
            $gatePassData = DB::table('policy_atten_rule_gatepass')->where('business_id', Session::get('business_id'))->first();

            if (!isset($gatePassData)) {
                $insertGatePassData = DB::table('policy_atten_rule_gatepass')->insert([
                    'switch_is' => 1,
                    'occurance_is' => $request->gatePassSelectOccurence ?? 0,
                    'occurance_count' => $request->gatePassOccurenceCount,
                    'occurance_hr' => isset($request->gatePassOccurenceHour) ? $splitedGatePassOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->gatePassOccurenceHour) ? $splitedGatePassOccurenceHour[1] : 0,
                    'absent_is' => $request->gatePasSelectAbsent,
                    'business_id' => Session::get('business_id'),
                ]);

                if ($insertGatePassData) {
                    Alert::success('Successfully Created');
                }
            } else {
                $updateGatePassData = DB::table('policy_atten_rule_gatepass')->where('business_id', Session::get('business_id'))->update([
                    'occurance_is' => $request->gatePassSelectOccurence,
                    'occurance_count' => $request->gatePassOccurenceCount,
                    'occurance_hr' => isset($request->gatePassOccurenceHour) ? $splitedGatePassOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->gatePassOccurenceHour) ? $splitedGatePassOccurenceHour[1] : 0,
                    'absent_is' => $request->gatePasSelectAbsent,
                ]);

                if ($updateGatePassData) {
                    Alert::success('Successfully Updated')->persistent(true);
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


    public function notice(Request $request)
    {
        $Notice = DB::table('admin_notices')->where('business_id', $request->session()->get('business_id'))->get();
        // dd($Notice);
        return view('admin.setting.business.notice.notice', compact('Notice'));
    }
    public function createNotice(Request $request)
    {
        // dd($request->all()); 
        // admin_notices
        $validatedData = $request->validate([
            'image' => 'required',
        ]);

        $file = $request->file('image');
        $path = public_path('notice_uploads/');
        $imageName = date('d-m-Y') . '_' . md5($file) . '.' . $file->extension();
        $data = $file->move($path, $imageName);


        // $carbonDate = Carbon::createFromFormat('d-m-Y', $request->date);
        // $formattedDate = $carbonDate->toDateString();

        if ($request->has('title') && $request->has('date')) {
            $notice = DB::table('admin_notices')->insert([
                'title' => $request->title,
                'date' => $request->date,
                'description' => $request->description,
                'file' => $imageName,
                'business_id' => $request->session()->get('business_id'),
                'branch_id' => $request->session()->get('branch_id'),
            ]);

            if ($notice) {
                Alert::success('Successfully Added !')->persistent(true);
            } else {
                Alert::error('Failed')->persistent(true);
            }
        }

        return back();
    }
    public function deleteNotice(Request $request, $id)
    {
        $getNotice = DB::table('admin_notices')
            ->where(['business_id' => $request->session()->get('business_id'), 'id' => $id])
            ->first();

        if ($getNotice) {
            $path = public_path('notice_uploads/');
            $filePath = $path . $getNotice->file;

            // Check if the file exists
            if (File::exists($filePath)) {
                // Attempt to delete the file
                if (File::delete($filePath)) {
                    $deleteFile = true;
                } else {
                    $deleteFile = false;
                }
            } else {
                $deleteFile = true; // File doesn't exist, so we consider it as deleted.
            }

            // Delete the notice
            $deleteNotice = DB::table('admin_notices')
                ->where(['business_id' => $request->session()->get('business_id'), 'id' => $id])
                ->delete();

            if ($deleteNotice && $deleteFile) {
                Alert::success('Successfully Deleted')->persistent(true);
            } else {
                Alert::error('Deletion Failed')->persistent(true);
            }
        } else {
            Alert::error('This data is already deleted')->persistent(true);
        }

        return back();
    }
}
