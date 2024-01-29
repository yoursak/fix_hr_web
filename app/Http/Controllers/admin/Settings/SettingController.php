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
use App\Models\Subscription;
use Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Central_unit;
use Carbon\Carbon;
use File;
use App\Models\admin\setupsettings\MasterEndGameModel;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\AttendanceHolidayList;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Http\Request;
use Dipesh79\LaravelPhonePe\LaravelPhonePe;
use Illuminate\Support\Facades\Route;

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
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $modes = DB::table('static_attendance_methods')->get();
        $bName = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first('business_name');
        $cameraAccess = DB::table('camera_permission')
            ->where('camera_permission.business_id', Session::get('business_id'))
            ->leftJoin('static_attendance_methods', 'camera_permission.mode_check', '=', 'static_attendance_methods.id')
            ->orderBy('camera_permission.id', 'DESC')
            ->select('camera_permission.*', 'static_attendance_methods.id as attmethodid', 'static_attendance_methods.method_name')
            ->get();
        $Type = DB::table('static_attendance_mode')->whereIn('id', [1, 2])->get();

        return view('admin.setting.attendance.cameraAccess', compact(['bName', 'cameraAccess', 'modes', 'Type', 'permissions']));
    }

    public function accessCamera(Request $request)
    {
        $Branch = DB::table('branch_list')
            ->where('business_id', Session::get('business_id'))
            ->where('branch_id', $request->branch)
            ->first();
        // dd($Branch->branch_email);
        if ($request->has('mode') && $request->has('imei')) {
            $accessRequest = DB::table('camera_permission')->insert([
                'mode_check' => $request->mode,
                'type_check' => $request->type,
                'business_check' => 1,
                'branch_check' => 1,
                'business_id' => Session::get('business_id'),
                'branch_id' => $request->branch,
                'branch_email' => $Branch->branch_email,
                'imei_number' => $request->imei,
                'check_camera' => $request->cameraAccess == 'on' ? 1 : 0,
            ]);

            if ($accessRequest) {
                Alert::success('', 'Your Camera permissiong has been successfully created')->persistent(true);
            } else {
                Alert::error('', 'Your Camera permissiong has not been created')->persistent(true);
            }

            return redirect()->back();
        }
    }



    public function updateCamera(Request $request)
    {
        // dd($request->all());

        $updateAccessRequest = DB::table('camera_permission')
            ->where('business_id', Session::get('business_id'))
            ->where('id', $request->id)
            ->update([
                'mode_check' => $request->updatemode,
                'type_check' => $request->type,
                'business_check' => 1,
                'business_id' => Session::get('business_id'),
                'branch_check' => 1,
                'branch_email' => $request->update_branch_email,
                'branch_id' => $request->branch,
                'imei_number' => $request->updateimei,
                'check_camera' => $request->updatecameraAccess == 'on' ? 1 : 0,
            ]);

        if (isset($updateAccessRequest)) {
            Alert::success('', 'Your Camera access persmission has been updated successfully');
        } else {
            Alert::error('', 'Your Camera access persmission has not been updated');
        }
        return redirect()->back();
    }

    public function removeCamera(Request $request, $id)
    {
        if ($id) {
            $removeCameraAccess = DB::table('camera_permission')
                ->where([
                    'id' => $id,
                    'business_id' => Session::get('business_id'),
                ])
                ->delete();

            if ($removeCameraAccess) {
                Alert::success('', 'Your Camera access has been deleted successfully')->persistent(true);
            } else {
                Alert::error('', 'Your Camera access has not been deleted')->persistent(true);
            }
        }
        return redirect()->back();
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

        if ($request->premisesActive === 'on') {
            $final_value[] = 1;
        }
        if ($request->outDoorActive === 'on') {
            $final_value[] = 2;
        }
        if ($request->wfhActive === 'on') {
            $final_value[] = 3;
        }

        // print_r($final_value);

        $isPresent = PolicyAttendanceMode::where('business_id', $request->session()->get('business_id'))->get();

        if ($isPresent->count() == 0) {
            $setMode = DB::table('policy_attendance_mode')->insert([
                'business_id' => $request->session()->get('business_id'),
                'attendance_active_methods' => json_encode($final_value),
                'office_auto' => $request->premisesIsAuto != 0 && $request->premisesActive === 'on' ? $request->premisesIsAuto : 0,
                'office_manual' => $request->premisesIsAuto == 0 && $request->premisesActive === 'on' ? 1 : 0,
                'office_qr' => $request->premisesQR != null && $request->premisesActive === 'on' ? $request->premisesQR : 0,
                'office_face_id' => $request->premisesFaceId != null && $request->premisesActive === 'on' ? $request->premisesFaceId : 0,
                'office_selfie' => $request->premisesSelfie != null && $request->premisesActive === 'on' ? $request->premisesSelfie : 0,
                'outdoor_auto' => $request->outIsAuto != 0 && $request->outDoorActive === 'on' ? $request->outIsAuto : 0,
                'outdoor_manual' => $request->outIsAuto == 0 && $request->outDoorActive === 'on' ? 1 : 0,
                'outdoor_selfie' => $request->outSelfie != null && $request->outDoorActive === 'on' ? $request->outSelfie : 0,
                'wfh_auto' => $request->wfhIsAuto != 0 && $request->wfhActive === 'on' ? $request->wfhIsAuto : 0,
                'wfh_manual' => $request->wfhIsAuto == 0 && $request->wfhActive === 'on' ? 1 : 0,
                'wfh_selfie' => $request->wfhSelfie != null && $request->wfhActive === 'on' ? $request->wfhSelfie : 0,
                'updated_at' => now(),
            ]);

            if ($setMode) {
                Alert::success('', 'Your Attendance mode has been activated successfully', '')->persistent(true);
            } else {
                Alert::error('Failed', '')->persistent(true);
            }
        } else {
            $updateMode = DB::table('policy_attendance_mode')
                ->where(['business_id' => $request->session()->get('business_id')])
                ->update([
                    'business_id' => $request->session()->get('business_id'),
                    'attendance_active_methods' => json_encode($final_value),
                    'office_auto' => $request->premisesIsAuto != 0 && $request->premisesActive === 'on' ? $request->premisesIsAuto : 0,
                    'office_manual' => $request->premisesIsAuto == 0 && $request->premisesActive === 'on' ? 1 : 0,
                    'office_qr' => $request->premisesQR != null && $request->premisesActive === 'on' ? $request->premisesQR : 0,
                    'office_face_id' => $request->premisesFaceId != null && $request->premisesActive === 'on' ? $request->premisesFaceId : 0,
                    'office_selfie' => $request->premisesSelfie != null && $request->premisesActive === 'on' ? $request->premisesSelfie : 0,
                    'outdoor_auto' => $request->outIsAuto != 0 && $request->outDoorActive === 'on' ? $request->outIsAuto : 0,
                    'outdoor_manual' => $request->outIsAuto == 0 && $request->outDoorActive === 'on' ? 1 : 0,
                    'outdoor_selfie' => $request->outSelfie != null && $request->outDoorActive === 'on' ? $request->outSelfie : 0,
                    'wfh_auto' => $request->wfhIsAuto != 0 && $request->wfhActive === 'on' ? $request->wfhIsAuto : 0,
                    'wfh_manual' => $request->wfhIsAuto == 0 && $request->wfhActive === 'on' ? 1 : 0,
                    'wfh_selfie' => $request->wfhSelfie != null && $request->wfhActive === 'on' ? $request->wfhSelfie : 0,
                    'updated_at' => now(),
                ]);

            if ($updateMode) {
                Alert::success('', 'Your Attendance mode  has been activated successfully')->persistent(true);
            } else {
                Alert::error('', 'Your Attendance mode has not been activated')->persistent(true);
            }
        }

        // return redirect()->to('/admin/settings/attendance/mode');

        return redirect()->back();
    }

    // account setting
    public function account()
    {
        $currentRouteName = Route::currentRouteName();
        // dd($currentRouteName);
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $statefind = DB::table('static_states')
            ->where('country_id', $accDetail->country)
            ->orderBy('name', 'asc')
            ->get();
        // dd($statefind);
        $citiesfind = DB::table('static_cities')
            ->where('state_id', $accDetail->state)
            ->orderBy('name', 'asc')
            ->get();
        // dd($citiesfind);
        return view('admin.setting.account.account', compact('permissions', 'moduleName', 'accDetail', 'statefind', 'citiesfind'));
    }

    public function BusinessDetail(Request $request)
    {
        $BAddDetail = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();

        return response()->json(['get' => $BAddDetail]);
    }

    // account setting page start
    public function uploadlogo(Request $request)
    {
        if ($request->image) {
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            // Get the uploaded image file
            $image = $request->file('image');
            $path = public_path('business_logo/');
            $imageName = date('d-m-Y') . '_' . md5($image) . '.' . $request->image->extension();
            $data = $request->image->move($path, $imageName);
            $data = DB::table('business_details_list')
                ->where('id', $request->editlogoId)
                ->where('business_id', Session::get('business_id'))
                ->update(['business_logo' => $imageName]);
            if ($data) {
                session()->put('login_business_image', $imageName);
                Alert::success('', 'Your Business logo has been updated successfully')->persistent(true);
            } else {
                Alert::success('', 'Your Business logo has not been updated')->persistent(true);
            }
        } else {
            $data = DB::table('business_details_list')
                ->where('id', $request->editlogoId)
                ->where('business_id', Session::get('business_id'))->first();
            if ($data) {
                Alert::success('', 'Your Business logo has been updated successfully')->persistent(true);
            } else {
                Alert::success('', 'Your Business logo has not been updated')->persistent(true);
            }
        }
        return redirect()->back();
    }

    public function sbussinessnameupdate(Request $request)
    {
        $sbussinessnameupdate = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['business_name' => $request->business_name, 'business_categories' => $request->select]);
        // return $branch;

        if (isset($sbussinessnameupdate)) {
            Alert::success('', 'Your Business category has been updated successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Business category has not been updated')->persistent(true);
        }
        return redirect()->back();
    }

    // sphoneupdate
    public function sphoneupdate(Request $request)
    {
        // dd($request->all());
        $data = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['mobile_no' => $request->phone]);
        // return $branch;
        if (isset($data)) {
            Alert::success('', 'Your Phone number has been updated successfully')->persistent(true);
        } else {
            Alert::success('', 'Your Phone number has not been updated')->persistent(true);
        }
        return redirect()->back();
    }

    public function sbtypeupdate(Request $request)
    {
        // dd($request->all());
        $data = DB::table('business_details_list')
            ->where('id', $request->editBtypeId)
            ->where('business_id', Session::get('business_id'))
            ->update(['business_type' => $request->select]);
        // return $branch;
        if (isset($data)) {
            Alert::success('', 'Your Business type has been updated successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Business type has not been updated')->persistent(true);
        }
        return redirect()->back();
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
        $address = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update([
                'business_address' => $request->address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'pin_code' => $request->pincode,
            ]);

        if (isset($address)) {
            Alert::success('', 'Your Business address has been updated successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Business address has not been updated')->persistent(true);
        }
        return redirect()->back();
    }

    public function getCountryStateCityAjax(Request $request)
    {
        $City = DB::table('static_cities')
            ->where('state_id', $request->state)
            ->orderBy('Name')
            ->get();
        $states = DB::table('static_states')
            ->where('country_id', $request->country)
            ->orderBy('Name')
            ->get();

        return response()->json(['states' => $states, 'city' => $City]);
    }

    public function subscription()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $subscriptionTable = Subscription::leftJoin('static_subscription_plan', 'subscription.plan_id', '=', 'static_subscription_plan.id')->where('business_id', Session::get('business_id'))->where('user_type', 1)->select('static_subscription_plan.plan_name as planName', 'subscription.*')->get();

        // dd($accessPermission);
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
        return view('admin.subscription.subscription', compact('accDetail', 'permissions', 'moduleName', 'subscriptionTable'));
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
        $name = DB::table('business_details_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update(['client_name' => $request->name]);
        if (isset($name)) {
            Alert::success('', 'Your Name has been updated successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Name has not been updated')->persistent(true);
        }
        return redirect()->back();
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
            ->where('policy_attendance_shift_type_items.attendance_shift_id', $branch_ID)
            ->where('policy_attendance_shift_type_items.business_id', Session::get('business_id'))
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
            ->where('employee_personal_details.active_emp', '1')
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
    public function allPermissionType()
    {
        $get = DB::table('static_permission_type')->get();
        return response()->json(['permission' => $get]);
    }
    public function allBranch()
    {
        $get = DB::table('branch_list')->where('business_id', Session::get('business_id'))->get();
        return response()->json(['branch' => $get]);
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
            'branch_email' => $request->email,
            'address' => $request->location,
            'logitude' => $request->logitude,
            'latitude' => $request->latitude,
        ];
        $addBranch = DB::table('branch_list')->insert($data);

        if ($addBranch) {
            Alert::success('', 'Your Branhc has been created successfully')->persistent(true);
        }
        return redirect()->back();
    }

    public function AddDepartment(Request $request)
    {
        $department = new DepartmentList();
        $department->b_id = Session::get('business_id');
        $department->depart_name = $request->department;
        $department->status = 0;
        if ($department->save()) {
            Alert::success('', 'Your Department has been created successfully')->persistent(true);
        }
        return redirect()->back();
    }
    public function AddDesignation(Request $request)
    {
        $designation = new DesignationList();
        $designation->business_id = $request->session()->get('business_id');
        $designation->desig_name = $request->designation;
        if ($designation->save()) {
            Alert::success('', 'Your Designation has been created successfully')->persistent(true);
        }
        return redirect()->back();
    }

    // update Functions
    public function UpdateBranch(Request $request)
    {
        // dd($request->all());
        $branch = DB::table('branch_list')
            ->where('id', $request->editBranchId)
            ->where('business_id', Session::get('business_id'))
            ->update([
                'branch_name' => $request->editbranch,
                'branch_email' => $request->editemail,
                'address' => $request->editaddress,
                'logitude' => $request->logitudeedit,
                'latitude' => $request->latitudeedit,
            ]);

        if (isset($branch)) {
            Alert::success('', 'Your Branch has been updated successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Branch has not been updated')->persistent(true);
        }
        return redirect()->back();
    }
    public function UpdateDepartment(Request $request)
    {
        $department = DepartmentList::where('depart_id', $request->editid)
            ->where('b_id', $request->session()->get('business_id'))
            ->update([
                'b_id' => $request->session()->get('business_id'),
                'depart_name' => $request->editdepartment,
            ]);

        if (isset($department)) {
            Alert::success('', 'Your Department has been updated successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Department has not been updated')->persistent(true);
        }

        return redirect()->back();
    }
    public function UpdateDesignation(Request $request)
    {
        $designation = DesignationList::where('desig_id', $request->editid)
            ->where('business_id', $request->session()->get('business_id'))
            ->update([
                'business_id' => $request->session()->get('business_id'),
                'desig_name' => $request->editdesignation,
            ]);
        if (isset($designation)) {
            Alert::success('', 'Your Designation has been updated successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Designation has not been updated')->persistent(true);
        }
        return redirect()->back();
    }

    // Delete Functions
    public function DeleteBranch(Request $request)
    {
        $branch_id = $request->branch_id;
        $checkmat = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->where('branch_id', $branch_id)
            ->first();
        if (isset($checkmat)) {
            Alert::error('', 'You cannot delete the Branch if you have an employee associated with it.')->persistent(true);
        } else {
            $roos = BranchList::where('business_id', Session::get('business_id'))
                ->where('branch_id', $branch_id)
                ->delete();
            Alert::success('', 'Your Branch has been deleted successfully')->persistent(true);
        }
        return redirect()->back();
    }

    public function DeleteDepartment($departID)
    {
        $checkmat = DB::table('employee_personal_details')
            ->where('department_id', '=', $departID)
            ->first();
        $department = DB::table('department_list')
            ->where('depart_id', $departID)
            ->first();
        if (isset($checkmat)) {
            Alert::error('', 'You cannot delete the department if you have an employee associated with it.')->persistent(true);
        } else {
            $roos = DB::table('department_list')
                ->where('depart_id', $departID)
                ->delete();
            Alert::success('', 'Your Department has been deleted successfully.')->persistent(true);
        }
        return redirect()->back();
    }

    public function DeleteDesignation($id)
    {
        $checkmat = DB::table('employee_personal_details')
            ->where('business_id', Session::get('business_id'))
            ->where('designation_id', $id)
            ->first();
        if (isset($checkmat)) {
            Alert::error('', 'You cannot delete the designation if you have an employee associated with it.')->persistent(true);
        } else {
            $designation = DesignationList::where('desig_id', $id)->delete();
            Alert::success('', 'Your Designation has been deleted successfully.')->persistent(true);
        }
        return redirect()->back();
    }

    public function holidayPolicy()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $masterEndAssignCheck = PolicyMasterEndgameMethod::where('business_id', Session::get('business_id'))->select('holiday_policy_ids_list')->get();
        $holidayPolicy = PolicyHolidayTemplate::where('business_id', Session::get('business_id'))->get();
        return view('admin.setting.business.holiday_policy.holiday_policy', compact('holidayPolicy', 'masterEndAssignCheck', 'permissions'));
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
        $getleavepolicy = DB::table('policy_master_endgame_method')->where('business_id', Session::get('business_id'))->select('leave_policy_ids_list')->get();
        $Leaves = PolicySettingLeaveCategory::where('business_id', session()->get('business_id'))->get();
        $leavePolicy = PolicySettingLeavePolicy::where('business_id', Session::get('business_id'))->get();
        $leaveType = DB::table('static_leave_category')
            ->where('id', '!=', '8')
            ->where('id', '!=', '9')
            ->get();
        $applicableTo = DB::table('static_leave_category_applicable_to')->get();
        return view('admin.setting.business.leave_policy.leave_policy', compact('leaveType', 'leavePolicy', 'Leaves', 'BranchList', 'permissions', 'moduleName', 'applicableTo', 'getleavepolicy'));
    }
    // aJAX JAY
    public function allLeavePolicy(Request $request)
    {
        $send = PolicySettingLeaveCategory::join('static_leave_category', 'static_leave_category.id', '=', 'policy_setting_leave_category.category_name')
            ->where('business_id', Session::get('business_id'))
            ->where('leave_policy_id', $request->leave_policy_id)
            ->select('policy_setting_leave_category.*', 'static_leave_category.name as static_category_name', 'static_leave_category.description')
            ->get();
        return response()->json(['get' => $send]);
    }

    public function allHolidayPolicy(Request $request)
    {
        $send = PolicyHolidayDetail::where('template_id', $request->leave_policy_id)
            ->orderBy('holiday_date')
            ->get();
        return response()->json(['get' => $send]);
    }

    // Confirm Method set in AJAX
    public function updateLeavePolicy(Request $request)
    {
        // dd($request->all());
        // code by umesh
        $leaveID = $request->role;
        $policyName = $request->edit_policys;
        $bID = Session::get('business_id');
        $branchID = $request->session()->get('branch_id');
        $btnradioedit = $request->btnradioedit;
        // Delete existing records for the given leave policy and busine
        // $check = true;
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
            $latestLeavePolicyID = $request->role; //generate policy ID run time
            $CategoryName = $request->category_name_edit ?? 0;
            $Days = $request->days_edit ?? 0;
            $UnusedLeaveRule = $request->unused_leave_rule_edit ?? 0;
            $carryForwardLimit = $request->carry_forward_limit_edit ?? 0;
            $applicationTo = $request->applicable_to_edit ?? 0;
            $leaveCycleMy = $request->leave_cycle_my_edit ?? 0;
            $ms = 0;
            $cfl = 0;
            if ($request->category_name_edit) {
                for ($i = 0; $i < sizeof($request->category_name_edit ?? 0); $i++) {
                    $collectionDataSet = [
                        'leave_policy_id' => $latestLeavePolicyID,
                        'business_id' => $bID,
                        'category_name' => $CategoryName[$i],
                        'leave_cycle_monthly_yearly' => $leaveCycleMy[$i],
                        'days' => $Days[$i],
                        'unused_leave_rule' => $UnusedLeaveRule[$i],
                        'carry_forward_limit' => $UnusedLeaveRule[$i] != 1 ? $carryForwardLimit[$cfl] : '0',
                        'applicable_to' => $applicationTo[$i],
                        'created_at' => now('Asia/Kolkata'),
                        'updated_at' => now('Asia/Kolkata'),
                    ];
                    PolicySettingLeaveCategory::insert($collectionDataSet);
                    if ($UnusedLeaveRule[$i] != 1) {
                        $cfl++;
                    }
                    if ($applicationTo[$i] != 1) {
                        $ms++;
                    }
                }
            }

            Alert::success('', 'Your Leave policy has been updated successfully')->persistent(true);
        } else {
            Alert::info('Not Added', 'Your Leave policy has not been pdated')->persistent(true);
        }
        return back();


    }


    public function DeleteLeavePolicy(Request $request)
    {
        $validateMethod = DB::table('policy_master_endgame_method')
            ->where('leave_policy_ids_list', $request->poli_id)
            ->first();
        // dd($validateMethod->method_name);

        if (isset($validateMethod)) {
            Alert::error('', 'You cannot delete the policy if you have an employee associated with it.');
        } else {
            $deleteTemp = PolicySettingLeavePolicy::where('id', $request->poli_id)->delete();
            $deleteLeaves = PolicySettingLeaveCategory::where('leave_policy_id', $request->poli_id)->delete();

            if (isset($deleteTemp) && isset($deleteLeaves)) {
                Alert::success('', 'Your Leave policy has been deleted successfully')->persistent(true);
            } else {
                Alert::error('', 'Your Leave policy has not been deleted')->persistent(true);
            }
        }
        return back();
    }
    // update check master engame assign or not
    public function UpdateCheMastEndLeavePolicy(Request $request)
    {
        $validateMethod = DB::table('policy_master_endgame_method')
            ->where('leave_policy_ids_list', $request->leave_policy_id)
            ->first();
        // dd($validateMethod->method_name);

        if (isset($validateMethod)) {
            return response()->json(['get' => '1']);
        } else {
            return response()->json(['get' => '2']);
        }
        return back();
    }


    public function leavePolicySubmit(Request $request)
    {
        $BusinessID = $request->session()->get('business_id');
        $branchID = $request->session()->get('branch_id');
        $firstDayOfMonth = $request->leave_periodfrom . '-01';
        $lastDayOfMonth = $request->leave_periodto . '-01';
        $carbonFirstDay = Carbon::createFromFormat('Y-m-d', $firstDayOfMonth);
        $carbonLastDay = Carbon::createFromFormat('Y-m-d', $lastDayOfMonth)->endOfMonth();
        $formattedLastDay = $carbonLastDay->format('Y-m-d');
        $storeData = [
            'business_id' => $BusinessID,
            'policy_name' => $request->policyname,
            'sandwich_leaves_count' => $request->btnradio != 1 ? 0 : 1,
            'sandwich_leaves_ignore' => $request->btnradio != 2 ? 0 : 2,
            'leave_period_from' => $carbonFirstDay,
            'leave_period_to' => $formattedLastDay,
            'created_at' => now('Asia/Kolkata'),
            'updated_at' => now('Asia/Kolkata'),
        ];
        // dd($storeData);
        if ($BusinessID != null || $branchID != null || $request->policyname != null || $request->category_name != null || $request->days != null) {
            $truechecking_id = DB::table('policy_setting_leave_policy')->insert($storeData);
        }
        if ($truechecking_id) {
            $latestID = PolicySettingLeavePolicy::latest()
                ->select('id')
                ->first();
            if (isset($latestID)) {
                $latestLeavePolicyID = $latestID->id; //generate policy ID run time
                $CategoryName = $request->category_name;
                $Days = $request->days;
                $UnusedLeaveRule = $request->unused_leave_rule;
                $carryForwardLimit = $request->carry_forward_limit;
                $applicationTo = $request->applicable_to;
                $leaveCycleMy = $request->leave_cycle_my;
                $ms = 0;
                $cfl = 0;
                for ($i = 0; $i < sizeof($request->category_name); $i++) {
                    $collectionDataSet = [
                        'leave_policy_id' => $latestLeavePolicyID,
                        'business_id' => $BusinessID,
                        'category_name' => $CategoryName[$i],
                        'leave_cycle_monthly_yearly' => $leaveCycleMy[$i],
                        'days' => $Days[$i],
                        'unused_leave_rule' => $UnusedLeaveRule[$i],
                        'carry_forward_limit' => $UnusedLeaveRule[$i] != 1 ? $carryForwardLimit[$cfl] : '0',
                        'applicable_to' => $applicationTo[$i],
                        'created_at' => now('Asia/Kolkata'),
                        'updated_at' => now('Asia/Kolkata'),
                    ];
                    PolicySettingLeaveCategory::insert($collectionDataSet);
                    if ($UnusedLeaveRule[$i] != 1) {
                        $cfl++;
                    }
                    if ($applicationTo[$i] != 1) {
                        $ms++;
                    }
                }
            }
            Alert::success('', 'Your Leave policy has been added successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Leave policy has not been added')->persistent(true);
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
        $data = PolicyWeeklyHolidayList::where('business_id', Session::get('business_id'))
            ->join('static_week_off_type', 'policy_weekly_holiday_list.weekend_policy', '=', 'static_week_off_type.id')
            ->select('policy_weekly_holiday_list.*', 'static_week_off_type.week_off_type_name')
            ->get();
        // check master endgame assign or not
        $checkMaEnAssOrNot = DB::table('policy_master_endgame_method')->where('business_id', Session::get('business_id'))->select('weekly_policy_ids_list')->get();
        $staticweekoffType = DB::table('static_week_off_type')->get();
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $days = [];

        foreach ($data as $item) {
            $days = json_decode($item->days, true); // Assuming 'days' column contains JSON data
        }

        return view('admin.setting.business.weekly_holiday.weekly_holiday', compact('data', 'days', 'staticweekoffType', 'checkMaEnAssOrNot', 'permissions'));
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
        // dd($request->all());
        if ($request->has('templatename') && $request->has('selectWeekOffPolicy') && $request->has('days')) {
            $data = new PolicyWeeklyHolidayList();
            // return back();
            $data->business_id = Session::get('business_id');
            $data->name = $request->templatename;
            $data->weekend_policy = $request->selectWeekOffPolicy;
            $data->days = json_encode($request->days);
            if ($data->save()) {
                Alert::success('', 'Your Week off policy has been created successfully')->persistent(true);
            } else {
                Alert::info('', 'Your Week off policy has not been created')->persistent(true);
            }
        } else {
            Alert::info('', 'Your Week off policy has not been created')->persistent(true);
        }
        return redirect()->back();
    }
    public function updateWeeklyHoliday(Request $request)
    {
        // dd($request->all());
        if ($request->has('id') && $request->has('edit_weekname') && $request->has('selectWeekOffPolicyUpdate') && $request->has('holidays')) {

            $data = DB::table('policy_weekly_holiday_list')
                ->where('id', $request->id)
                ->where('business_id', Session::get('business_id'))
                ->update(['name' => $request->edit_weekname, 'weekend_policy' => $request->selectWeekOffPolicyUpdate, 'days' => json_encode($request->holidays)]);
            if (isset($data)) {
                Alert::success('', 'Your Week off policy has been updated successfully')->persistent(true);
            } else {
                Alert::info('', 'Your Week off policy has not updated')->persistent(true);
            }
        } else {
            Alert::info('', 'Your Week off policy has not updated')->persistent(true);
        }
        return redirect()->back();
    }
    public function deleteWeeklyHoliday(Request $request)
    {
        // dd($request->weekly_policy_id);
        $checkmet = DB::table('policy_master_endgame_method')
            ->where('business_id', Session::get('business_id'))
            ->where('weekly_policy_ids_list', $request->weekly_policy_id)
            ->count();
        // dd($checkmet);

        if ($checkmet == 0) {
            $data = DB::table('policy_weekly_holiday_list')
                ->where('id', $request->weekly_policy_id)
                ->where('business_id', Session::get('business_id'))
                ->delete();
            Alert::success('', 'Your Week off policy has been deleted successfully')->persistent(true);
        } else {
            Alert::error('', 'You cannot delete the policy if you have an employee associated with it.')->persistent(true);
        }
        return redirect()->back();
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
        $Track = PolicyAttendanceTrackInOut::where('business_id', Session::get('business_id'))->first();

        $Modes = PolicyAttendanceMode::where('business_id', Session()->get('business_id'))->first();
        $List = RulesManagement::ALLPolicyTemplates();
        $FinalEndGameRule = $List[0];
        // dd($List);

        $AttendanceData = RulesManagement::AttendaceMethodTypeCounter();

        return view('admin.setting.attendance.attendance', compact('Modes', 'Track', 'FinalEndGameRule', 'permissions', 'moduleName', 'AttendanceData'));
    }

    public function attendanceAccess()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];

        $EmployeeInfomation = $List[9];

        $BusinessDetails = DB::table('business_details_list')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $AttMode = PolicyAttendanceMode::where('business_id', Session::get('business_id'))->first();


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

        $root = compact('moduleName', 'permissions', 'BusinessDetails', 'FinalEndGameRule', 'BranchList', 'LeavePolicy', 'HolidayPolicy', 'weeklyPolicy', 'attendanceModePolicy', 'attendanceShiftPolicy', 'attendanceTrackInOut');
        return view('admin.setting.active_rules.active_end_game', $root);
    }
    // End Games Rule Submit form
    public function FinalStartRuleEndGame(Request $request)
    {

        $data = [
            'business_id' => $request->b_id,
            'method_name' => $request->methodname,
            'method_switch' => 0,
            'policy_preference' => $request->policypreference,
            'level_type' => 1,
            'shift_settings_ids_list' => json_encode($request->input('shiftsetting')),
            'leave_policy_ids_list' => $request->leavepolicy, //json_encode($request->input('leavepolicy')),
            'holiday_policy_ids_list' => $request->holidaypolicy, // json_encode($request->input('holidaypolicy')),
            'weekly_policy_ids_list' => $request->weeklypolicy, // json_encode($request->input('weeklypolicy')),
        ];


        $load = PolicyMasterEndgameMethod::insert($data);
        if (isset($load)) {
            Alert::success('', 'Your Setup has been created successfully')->persistent(true);
        } else {
            Alert::error('', 'Your Setup has been not created')->persistent(true);
        }

        return redirect()->back();
        // dd($leavePolicyIds);
    }

    // ajax getMasterRules
    public function getMasterRules(Request $request)
    {
        $load = PolicyMasterEndgameMethod::where(['id' => $request->e_id, 'business_id' => $request->b_id])->first();
        return response()->json($load);
    }
    // edit_master_rule
    public function editMasterRules(Request $request)
    {

        $data = [
            'business_id' => $request->edit_bid,
            'method_switch' => 0, //($request->switch != 0) ? $request->switch : 0
            'method_name' => $request->edit_mname,
            'policy_preference' => $request->editpolicypreference,
            'level_type' => 1,
            'leave_policy_ids_list' => $request->editleavepolicy, // json_encode($request->input('editleavepolicy')),
            'holiday_policy_ids_list' => $request->editholidaypolicy, //json_encode($request->input('editholidaypolicy')),
            'weekly_policy_ids_list' => $request->editweeklypolicy, // json_encode($request->input('editweeklypolicy')),
            'shift_settings_ids_list' => $request->editshiftsetting, // json_encode($request->input('editshiftsetting')),
        ];

        //     // Insert the new data into the database
        $load = PolicyMasterEndgameMethod::where('id', $request->edit_id)->update($data);
        //     // Commit the transaction if all operations were successful
        //     DB::commit();
        if ($load) {
            Alert::success('', 'Your Setup has been updated successfully')->persistent(true);
        } else {
            Alert::info('', 'Your Setup has been not updated')->persistent(true);
        }

        return redirect()->back();
        // return self::ActiveMode();
    }

    // mode_master_rule switch ON/OFF
    // long time set in JAYANT
    public function modeMasterRules(Request $request)
    {
        $activeCheck = $request->checked; //1 or  0
        $masterId = $request->e_id;
        $BusinessID = $request->b_id;
        $holidayPolicyID = $request->holiday_policy_id;
        $weeklyPolicyID = $request->weekly_policy_id;

        // $mode = AttendanceHolidayList::where('business_id', $BusinessID)->delete();
        $loaded = PolicyMasterEndgameMethod::where('business_id', $BusinessID)
            ->where('id', $masterId)
            ->update(['method_switch' => $activeCheck]);


        if ($activeCheck != 0) {
            // Return the filtered "Monday" entries
            $policyHoliday = PolicyHolidayTemplate::where('business_id', $BusinessID)
                ->where('temp_id', $holidayPolicyID)
                ->where('holiday_type_id', 1)
                ->first();
            $sd = AttendanceHolidayList::where('business_id', $BusinessID)
                ->where('master_end_method_id', $masterId)
                ->where('holiday_package_id', $holidayPolicyID)
                ->where('holiday_type_id', 1)
                ->first();
            if (!isset($sd)) {
                $policyHolidayItems = PolicyHolidayDetail::where('business_id', $BusinessID)
                    ->where('template_id', $policyHoliday->temp_id)
                    ->get();
                $dataToInsert = $policyHolidayItems
                    ->map(function ($item) use ($policyHoliday, $holidayPolicyID, $masterId) {
                        return [
                            'process_check' => 0,
                            'master_end_method_id' => $masterId,
                            'from_start' => $policyHoliday->temp_from,
                            'to_end' => $policyHoliday->temp_to,
                            'holiday_type_id' => 1, //type of cycle in mana. type of holiday
                            'holiday_package_id' => $holidayPolicyID,
                            'business_id' => $item->business_id,
                            'name' => $item->holiday_name,
                            'day' => $item->day,
                            'holiday_date' => $item->holiday_date,
                        ];
                    })
                    ->toArray();
                AttendanceHolidayList::where('attendance_holiday_list', '<>', 1)->where('business_id', Session::get('business_id'))->insert($dataToInsert);

                $delete = AttendanceHolidayList::where('attendance_holiday_list', 0)->where('business_id', Session::get('business_id'))->get();
                if ($delete) {
                    $delete->delete();
                }
            }
            $sd2 = AttendanceHolidayList::where('business_id', $BusinessID)
                ->where('master_end_method_id', $masterId)
                ->where('holiday_package_id', $weeklyPolicyID)
                ->where('holiday_type_id', 2)
                ->first();
            if (!isset($sd2)) {
                $getweeklyID = PolicyWeeklyHolidayList::where('business_id', $BusinessID)
                    ->where('id', $weeklyPolicyID)
                    ->select('days', 'weekend_policy')
                    ->first();
                $year = Carbon::now()->year; // Get the current year
                $mondaysInYear = []; //currentyearFiltering process
                $dataToInsert = []; //insert new data store

                // Loop through each day of the year

                for ($month = 1; $month <= 12; $month++) {
                    $totalDaysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
                    for ($day = 1; $day <= $totalDaysInMonth; $day++) {
                        // Loop through all possible days
                        // Check if the date is valid and if it's a Monday
                        if (checkdate($month, $day, $year) && Carbon::createFromDate($year, $month, $day)) {
                            $formattedDate = [
                                'day' => Carbon::createFromDate($year, $month, $day)->format('l'),
                                'weekly_no' => Carbon::createFromDate($year, $month, $day)->format('N'),
                                'date' => Carbon::createFromDate($year, $month, $day)->format('d-m-Y'),
                                'number' => intval((Carbon::createFromDate($year, $month, $day)->format('d') - 1) / 7),
                            ];
                            $mondaysInYear[] = $formattedDate; // Store day name and date together
                        }
                    }
                }

                $collectionArray = json_decode($getweeklyID->days); //['Sunday','studart']
                $methodApply = $getweeklyID->weekend_policy;

                $filteredDays = array_filter($mondaysInYear, function ($item) use ($collectionArray, $methodApply) {
                    if ($methodApply == 1) {
                        if ($item['weekly_no'] == 6 || $item['weekly_no'] == 7) {
                            // Filter Saturdays and Sundays (1: all Saturday and Sunday)
                            return in_array($item['day'], $collectionArray);
                        }
                    } elseif ($methodApply == 2) {
                        if ($item['weekly_no'] == 7) {
                            // Filter only Sundays (2: Sunday-off)
                            return in_array($item['day'], $collectionArray);
                        }
                    } elseif ($methodApply == 3) {
                        if (($item['weekly_no'] == 6 && $item['number'] == 1) || $item['weekly_no'] == 7 || ($item['weekly_no'] == 6 && $item['number'] == 3) || $item['weekly_no'] == 7) {
                            // Filter 2nd or 4th Saturday and all Sundays (3: 2nd or 4th Saturday also set all Sundays)
                            return in_array($item['day'], $collectionArray);
                        }
                        // Other array list data loaded
                    } else {
                        return in_array($item['day'], $collectionArray);
                    }
                });

                foreach ($filteredDays as $filteredDay) {
                    $dataToInsert[] = [
                        'process_check' => 0,
                        'master_end_method_id' => $masterId,
                        'from_start' => $policyHoliday->temp_from,
                        'to_end' => $policyHoliday->temp_to,
                        'holiday_type_id' => 2,
                        'holiday_package_id' => $weeklyPolicyID,
                        'business_id' => $BusinessID,
                        'name' => 'Weekly Off', // Replace with the appropriate holiday name
                        'day' => $filteredDay['day'],
                        'holiday_date' => Carbon::createFromFormat('d-m-Y', $filteredDay['date'])->toDateString(), // Convert date format if needed
                    ];
                    // Insert the prepared data into the AttendanceHolidayList table
                }
                AttendanceHolidayList::where('attendance_holiday_list', '<>', 1)->where('business_id', Session::get('business_id'))->insert($dataToInsert);

                $delete = AttendanceHolidayList::where('attendance_holiday_list', 0)->where('business_id', Session::get('business_id'))->get();
                if ($delete) {
                    $delete->delete();
                }
            }
        }

        return response()->json($request->all());
    }

    // parament delete_set
    public function deleteMasterRules(Request $request)
    {
        $PID = $request->eid;
        $RuleMode = new RulesManagement();
        $check = false;
        $AssociatedCheck = $RuleMode->AssociatedUser($PID)[0];
        if ($AssociatedCheck !== 0) {
            $check = false;
        } else {
            $check = true;
        }
        if ($check) {
            $load = PolicyMasterEndgameMethod::where('business_id', $request->bid)
                ->where('id', $PID)
                ->delete();
            Alert::success('', 'You setup has been deleted successfully')->persistent(true);
        } else {
            // Failed Final Rules Not Deleted
            Alert::error('', 'You cannot delete the setup if you have an employee associated with it.')->persistent(true);
        }

        return redirect()->back();

    }

    // automation rule
    public function automation()
    {
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];

        $lateEntryData = DB::table('policy_atten_rule_late_entry')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $earlyExitData = DB::table('policy_atten_rule_early_exit')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $overtimeData = DB::table('policy_atten_rule_overtime')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $breakData = DB::table('policy_atten_rule_break')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $missPunchData = DB::table('policy_atten_rule_misspunch')
            ->where('business_id', Session::get('business_id'))
            ->first();
        $gatePassData = DB::table('policy_atten_rule_gatepass')
            ->where('business_id', Session::get('business_id'))
            ->first();

        return view('admin.setting.attendance.automation', compact('permissions', 'moduleName', 'lateEntryData', 'earlyExitData', 'overtimeData', 'breakData', 'missPunchData', 'gatePassData'));
    }

    public function setAutomationRule(Request $request)
    {

        if ($request->dataLateEntry) {
            if ($request->dataLateEntry == 'true') {
                DB::table('policy_atten_rule_late_entry')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 1]);
                return response()->json(['Updated true']);
            } elseif ($request->dataLateEntry == 'false') {
                DB::table('policy_atten_rule_late_entry')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 0]);
                return response()->json(['Updated false']);
            } else {
                return response()->json($request->dataLateEntry);
            }
        }

        if ($request->breakSwitch) {
            if ($request->breakSwitch == 'true') {
                DB::table('policy_atten_rule_break')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } elseif ($request->breakSwitch == 'false') {
                DB::table('policy_atten_rule_break')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->breakSwitch);
            }
        }

        if ($request->earlyExitSwitch) {
            if ($request->earlyExitSwitch == 'true') {
                DB::table('policy_atten_rule_early_exit')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } elseif ($request->earlyExitSwitch == 'false') {
                DB::table('policy_atten_rule_early_exit')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->earlyExitSwitch);
            }
        }

        if ($request->overtimeSwitch) {
            if ($request->overtimeSwitch == 'true') {
                DB::table('policy_atten_rule_overtime')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } elseif ($request->overtimeSwitch == 'false') {
                DB::table('policy_atten_rule_overtime')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->overtimeSwitch);
            }
        }

        if ($request->missPunchSwitch) {
            if ($request->missPunchSwitch == 'true') {
                DB::table('policy_atten_rule_misspunch')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } elseif ($request->missPunchSwitch == 'false') {
                DB::table('policy_atten_rule_misspunch')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 0]);
                return response()->json('Updated False');
            } else {
                return response()->json($request->missPunchSwitch);
            }
        }

        if ($request->gatePassSwitch) {
            if ($request->gatePassSwitch == 'true') {
                DB::table('policy_atten_rule_gatepass')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 1]);
                return response()->json('Updated True');
            } elseif ($request->gatePassSwitch == 'false') {
                DB::table('policy_atten_rule_gatepass')
                    ->where('business_id', Session::get('business_id'))
                    ->update(['switch_is' => 0]);
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



        if ($request->lateEntry == 'on') {
            $lateEntryData = DB::table('policy_atten_rule_late_entry')
                ->where('business_id', Session::get('business_id'))
                ->first();
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
                $updateLateEntryData = DB::table('policy_atten_rule_late_entry')
                    ->where('business_id', Session::get('business_id'))
                    ->update([
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
            $earlyExitData = DB::table('policy_atten_rule_early_exit')
                ->where('business_id', Session::get('business_id'))
                ->first();

            if (!isset($earlyExitData)) {
                $insertEarlyExitData = DB::table('policy_atten_rule_early_exit')->insert([
                    'switch_is' => 1,
                    'grace_time_hr' => isset($request->graceTime) ? $splitedGraceTime[0] : 0,
                    'grace_time_min' => isset($request->graceTime) ? $splitedGraceTime[1] : 0,
                    'occurance_is' => $request->earlyExitSelectOccurence,
                    'occurance_count' => $request->earlyExitOccurenceCount,
                    'occurance_hr' => isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[0] : 0,
                    'occurance_min' => isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[1] : 0,
                    'absent_is' => $request->earlyExitSelectAbsent,
                    'mark_half_day_hr' => isset($request->earlyExitBy) ? $splitedEarlyExitBy[0] : 0,
                    'mark_half_day_min' => isset($request->earlyExitBy) ? $splitedEarlyExitBy[1] : 0,
                    'business_id' => Session::get('business_id'),
                ]);
                if ($insertEarlyExitData) {
                    Alert::success('Successfully Created')->persistent(true);
                }
            } else {
                $updateEarlyExitData = DB::table('policy_atten_rule_early_exit')
                    ->where('business_id', Session::get('business_id'))
                    ->update([
                        'grace_time_hr' => isset($request->graceTime) ? $splitedGraceTime[0] : 0,
                        'grace_time_min' => isset($request->graceTime) ? $splitedGraceTime[1] : 0,
                        'occurance_is' => $request->earlyExitSelectOccurence,
                        'occurance_count' => $request->earlyExitOccurenceCount,
                        'occurance_hr' => isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[0] : 0,
                        'occurance_min' => isset($request->earlyExitOccurenceHour) ? $splitedEarlyExitOccurenceHour[1] : 0,
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
            $overtimeData = DB::table('policy_atten_rule_overtime')
                ->where('business_id', Session::get('business_id'))
                ->first();
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
                $updateOvertimeData = DB::table('policy_atten_rule_overtime')
                    ->where('business_id', Session::get('business_id'))
                    ->update([
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
            $breakData = DB::table('policy_atten_rule_break')
                ->where('business_id', Session::get('business_id'))
                ->first();
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
                $updateBreakData = DB::table('policy_atten_rule_break')
                    ->where('business_id', Session::get('business_id'))
                    ->update([
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
            $missPunchData = DB::table('policy_atten_rule_misspunch')
                ->where('business_id', Session::get('business_id'))
                ->first();

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
                $updateMissPunchData = DB::table('policy_atten_rule_misspunch')
                    ->where('business_id', Session::get('business_id'))
                    ->update([
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
            $gatePassData = DB::table('policy_atten_rule_gatepass')
                ->where('business_id', Session::get('business_id'))
                ->first();

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
                $updateGatePassData = DB::table('policy_atten_rule_gatepass')
                    ->where('business_id', Session::get('business_id'))
                    ->update([
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

        if (($updateGatePassData ?? false) || ($updateMissPunchData ?? false) || ($updateBreakData ?? false) || ($updateOvertimeData ?? false) || ($updateEarlyExitData ?? false) || ($updateLateEntryData ?? false)) {
            Alert::success('', 'Your Automation rule has been created successfully');
        } else {
            Alert::warning('', 'Your Automation rule is not updated');
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
        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $Notice = DB::table('admin_notices')
            ->where('business_id', $request->session()->get('business_id'))
            ->get();
        return view('admin.setting.business.notice.notice', compact('Notice', 'permissions'));
    }


    public function createNotice(Request $request)
    {
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

            if (isset($notice)) {
                Alert::success('', 'Your Notice has been created successfully')->persistent(true);
            } else {
                Alert::error('', 'Your Notice has not been created')->persistent(true);
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
                Alert::success('', 'Your Notice has been deleted successfully')->persistent(true);
            } else {
                Alert::error('', 'Your Notice has not been deleted')->persistent(true);
            }
        } else {
            Alert::error('This data is already deleted')->persistent(true);
        }
        return redirect()->back();
    }
}
