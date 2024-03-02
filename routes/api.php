<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\FirebasePushController;
use App\Http\Controllers\ApiController\CommonApiController;
// use App\Http\Controllers\ApiController\LeaveRequestApiController;
use App\Http\Controllers\ApiController\MisspuchApiController;
use App\Http\Controllers\ApiController\UploadImageApiController;

// Admin Side
use App\Http\Controllers\ApiController\ApiAdminController\ApiLoginController;
use App\Http\Controllers\ApiController\ApiAdminController\Employee\EmployeeController;
use App\Http\Controllers\ApiController\ApiAdminController\Attendance\AttendanceController;
use App\Http\Controllers\ApiController\ApiAdminController\Home\DashobardController;
use App\Http\Controllers\ApiController\ApiAdminController\Request\ApiRequestAdminController;
use App\Http\Controllers\ApiController\ApiAdminController\Setting\BusinessController;

// User Side
use App\Http\Controllers\ApiController\ApiUserController\Request\LeaveRequestApiController;
use App\Http\Controllers\ApiController\ApiUserController\Request\MispunchApiController;
use App\Http\Controllers\ApiController\ApiUserController\Request\OutdoorApiController;
use App\Http\Controllers\ApiController\ApiUserController\Login\EmployeeLoginApiController;
use App\Http\Controllers\ApiController\ApiUserController\Employee\EmployeeApiController;
use App\Http\Controllers\ApiController\ApiUserController\Request\GatePassApiController;
use App\Http\Controllers\ApiController\ApiUserController\Attendance\AttendanceApiController;
use App\Http\Controllers\ApiController\ApiUserController\Setting\SettingUserApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::any('leave_edit', [LeaveRequestApiController::class, 'leaveUpdate']);

// Full Employee Section *****************************************************
Route::prefix('user')->group(function () {
    Route::prefix('/employee')->group(function () {
        Route::post('/login', [EmployeeLoginApiController::class, 'login']); //QA
        Route::any('/verify_otp', [EmployeeLoginApiController::class, 'VerifiedOtp']);
        Route::post('/logout_employee', [EmployeeLoginApiController::class, 'employeeLogout']);
        Route::any('/master_rule', [EmployeeLoginApiController::class, 'MasterRule']);
        Route::any('/attendance_mode', [EmployeeLoginApiController::class, 'AttendanceMode']);
        Route::any('/shift_type_list', [EmployeeLoginApiController::class, 'ShiftTypeList']);
        Route::prefix('login')->group(function () {
            Route::post('/multiple_login', [EmployeeLoginApiController::class, 'getMultipleLogin']);
        });
        Route::prefix('attendance')->group(function () {
            Route::any('daily_details', [EmployeeApiController::class, 'dashboardcount']);
            // Route::get('/detail', [AttendanceApiController::class, 'index']);
            Route::any('/today_attendances_status', [AttendanceApiController::class, 'currentAttendanceStatus']);
            Route::any('/current_attendances_status', [AttendanceApiController::class, 'currentStatusAttendanceRequest']);
            Route::post('/detail', [AttendanceApiController::class, 'store']);
            Route::post('attendance_store', [AttendanceApiController::class, 'storeAttendance']);
            Route::get('detail/{id}', [AttendanceApiController::class, 'show']);
            Route::any('/attendance_data_list', [AttendanceApiController::class, 'attendanceDataList']);
            Route::any('/attendance_data_location_tab_list', [AttendanceApiController::class, 'checkLocationTabList']);
            Route::any('filter_attendance', [AttendanceApiController::class, 'filterAttenDetail']);
            Route::any('attendance_detail', [AttendanceApiController::class, 'attendanceDetail']);
            Route::put('detail/{id}', [AttendanceApiController::class, 'update']);
            Route::delete('detail/{id}', [AttendanceApiController::class, 'destroy']);

            // attendance Mode
            Route::any('allow_business_mode', [AttendanceApiController::class, 'attendanceAcceptOnBusiness']);
        });

        Route::post('employee_details', [EmployeeApiController::class, 'show']);

        // Leave Request
        Route::prefix('leaverequest')->group(function () {
            // Route::get('detail',[LeaveRequestApiController::class, 'index']);
            Route::post('detail', [LeaveRequestApiController::class, 'store']);
            Route::get('detail/{id}', [LeaveRequestApiController::class, 'show']);
            Route::any('leave_edit', [LeaveRequestApiController::class, 'leaveUpdate']);
            Route::any('leave_data_list', [LeaveRequestApiController::class, 'leaveDataList']); //show list
            Route::any('leave_request_status', [LeaveRequestApiController::class, 'currentStatusLeaveRequest']);
            Route::any('leave_shift_type', [LeaveRequestApiController::class, 'staticLeaveShiftType']); //static_leave_shift_type
            Route::any('request_leave_type', [LeaveRequestApiController::class, 'staticRequestLeaveType']); // static_request_leave_type
            Route::post('leave_category', [LeaveRequestApiController::class, 'policySettingLeaveCategory']); //policy_setting_leave_category
            Route::post('delete', [LeaveRequestApiController::class, 'destroy']);

            Route::any('leave_balance', [LeaveRequestApiController::class, 'leaveBalanceList']);
            // Route::get('leaveidtodata/{id}', [LeaveRequestApiController::class, 'leaveIdToData']);
        });
        // Gate Pass Request
        Route::prefix('gatepassrequest')->group(function () {
            // Route::get('detail',[GatePassApiController::class, 'index']);
            Route::get('static_going_through', [GatePassApiController::class, 'staticGoingThroughResponse']);
            Route::post('store', [GatePassApiController::class, 'store']);
            Route::any('gatepass_data_list', [GatePassApiController::class, 'gatepasssDataList']);
            Route::post('gatepass_data', [GatePassApiController::class, 'gatepassIdData']);
            Route::post('/gatepass_month_filter_data', [GatePassApiController::class, 'gatepassMonthFilterData']);
            Route::get('detail/{id}', [GatePassApiController::class, 'show']);
            Route::any('gate_pass_edit', [GatePassApiController::class, 'gatepassupdate']); //edit_gate_pass
            Route::any('delete', [GatePassApiController::class, 'destroy']); //gate_pass_delete
            Route::any('gatepass_request_status', [GatePassApiController::class, 'currentStatusGatePassRequest']);
        });

        // MisPunch Request
        Route::prefix('mispuchrequest')->group(function () {
            // Route::get('detail',[MispunchApiController::class, 'index']);
            Route::get('static_mispunch_time', [MispunchApiController::class, 'staticMispunchTimeType']);
            Route::get('detail/{id}', [MispunchApiController::class, 'show']);
            Route::any('mispunch_data_list', [MispunchApiController::class, 'mispunchDataList']);
            Route::post('store', [MispunchApiController::class, 'store']);
            Route::any('mispunch_edit', [MispunchApiController::class, 'mispunchupdate']);  //edit_mis_punch_route
            Route::post('delete', [MispunchApiController::class, 'destroy']); //delete_mis_punch_route
            Route::delete('detail/{id}', [MispunchApiController::class, 'destroy']);
            Route::any('current_mispunch_status', [MispunchApiController::class, 'currentStatusMisspunchRequest']);
            Route::any('find_mispunch_status', [MispunchApiController::class, 'findOutMisPunchRequest']);
            // add allow misspunch permission
            Route::any('checking_current_mispunch_permission', [MispunchApiController::class, 'checkPermissionAllowMissPunch']);
        });

        // Outdoor Request
        Route::prefix('outdoorrequest')->group(function () {
            Route::post('outdoor_store', [OutdoorApiController::class, 'store']);
            Route::post('outdoor_show_list', [OutdoorApiController::class, 'showList']);
            Route::post('outdoor_detail_find', [OutdoorApiController::class, 'outdoorDetailFind']);
        });

        Route::prefix('settings')->group(function () {
            Route::any('holiday_list', [SettingUserApiController::class, 'policyHolidayDataList']);
        });
    });
});
// End Employee Section ***********************************************************

Route::prefix('image')->group(function () {
    Route::post('upload', [UploadImageApiController::class, 'uploadImage']);
});

Route::any('/bussinesscheck', [CommonApiController::class, 'businesscheck']);

// Admin Call
Route::prefix('admin')->group(function () {
    Route::post('/login', [ApiLoginController::class, 'login']);
    Route::any('/verify_otp', [ApiLoginController::class, 'VerifiedOtp']); //owner
    Route::any('/logout', [ApiLoginController::class, 'Logout']);
    Route::any('/notification', [FirebasePushController::class, 'sendNotification']);

    Route::any('/dashboard_count', [DashobardController::class, 'getDashboardCount']);
    Route::any('/pending_approval_count', [DashobardController::class, 'getPendingApprovalCount']);
    Route::any('/today_attendance_list', [AttendanceController::class, 'getTodayAttendanceList']);
    Route::any('/today_attendance_report', [DashobardController::class, 'getTodayAttendanceReport']);
    Route::prefix('camera_permission')->group(function () {
        Route::any('/camera_login_permission', [ApiLoginController::class, 'cameraLogin']);
        Route::any('/camera_verify_permission', [ApiLoginController::class, 'cameraVerifyPermission']);
    });


    Route::middleware(['auth:admin'])->group(function () {


        Route::get('/branchlist/{id}', [EmployeeController::class, 'branchList']);
        Route::get('/departmentlist/{id}', [EmployeeController::class, 'departmentList']);
        Route::any('/allemployee', [EmployeeController::class, 'employeeList']); //cameraPermission check_camera
        Route::any('/attendance_list', [AttendanceController::class, 'allAttendanceList']);
        Route::any('/attend', [ApiLoginController::class, 'attendence']); //Mode attendances
        Route::get('/business_name/{business_id}', [BusinessController::class, 'nameBusiness']); //Mode attendances
        Route::get('/brand_name/{brand_id}', [ApiLoginController::class, 'nameBrand']); //Mode attendances
        Route::get('/totalbranddetails/{business_id}', [ApiLoginController::class, 'nameTotalBrand']); //Mode attendances

        Route::prefix('employee')->group(function () {
            Route::post('/personal_details', [AttendanceController::class, 'allEmployeePersonalData']);
        });

        Route::prefix('requests')->group(function () {

            Route::prefix('filter_list')->group(function () {
                Route::any('leave', [ApiRequestAdminController::class, 'allRequestLeaveList']); //Mode attendances
                Route::any('/misspunch_list', [ApiRequestAdminController::class, 'allRequestMissPunchList']);
            });

            // Route::post('/personal_details', [AttendanceController::class, 'allEmployeePersonalData']);

        });
    });
    // Route::group(['middleware' => 'apilogincheck'], function () {
    //     Route::prefix('employee')->group(function () {
    //         Route::get('/detail', [EmployeeApiController::class, 'index']);
    //         Route::post('/detail', [EmployeeApiController::class, 'store']);
    //         // Route::get('detail/{id}', [EmployeeApiController::class, 'show']);
    //         Route::put('detail/{id}', [EmployeeApiController::class, 'update']);
    //         Route::delete('detail/{id}', [EmployeeApiController::class, 'destroy']);
    //         Route::get('detailall/{id}', [EmployeeApiController::class, 'bemployee']);
    //     });
    //     Route::prefix('attendance')->group(function () {
    //         Route::get('/detail', [AttendanceApiController::class, 'index']);
    //         Route::post('/detail', [AttendanceApiController::class, 'store']);
    //         Route::get('detail/{id}', [AttendanceApiController::class, 'show']);
    //         Route::put('detail/{id}', [AttendanceApiController::class, 'update']);
    //         Route::delete('detail/{id}', [AttendanceApiController::class, 'destroy']);
    //     });
    // });
});

Route::controller(BusinessController::class)->group(function () {
    Route::any('test', 'Test'); //'uploadImage' image upload test
    Route::get('/business_categories', 'BusinessCategories');
    Route::get('/business_type', 'BusinessTypes');
    // Route::post('/login','checkLogin');

    // submit businessDetails
    Route::post('/business_details_submit', 'BusinessDetailsSubmit');
});

Route::post('/runmigrations/{tableName}', [EmployeeController::class, 'EmployeeTable']);
Route::any('/employee_add', [EmployeeController::class, 'Store']);
Route::get('/branch', [EmployeeController::class, 'Branch']);
Route::get('/department', [EmployeeController::class, 'Department']);
Route::any('/gatepass/{tableName}', [RequestController::class, 'GatepassTable']); // Umesh - Employee table route
Route::any('/misspunch/{tableName}', [RequestController::class, 'MisspunchTable']);
// Route::any('login/employee', [LoginApiController::class, 'login']);

// Route::post('login', [LoginApiController::class, 'login'])->name('newlogin');

// Route::post('loginWithOtp', [LoginApiController::class, 'loginWithOtp'])->name('loginWithOtp');
// Route::get('loginWithOtp', function () {
//     return view('auth/OtpLogin');
// })->name('loginWithOtp');

// Route::any('sendOtp', 'LoginApiController@sendOtp');

Route::any('/test/{id}', [EmployeeApiController::class, 'allemployee']);

Route::prefix('attendance')->group(function () {
    Route::get('/detail', [AttendanceApiController::class, 'index']);
});
