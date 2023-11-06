<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\MigrationController;
use App\Http\Controllers\ApiController\CommonApiController;
use App\Http\Controllers\ApiController\LeaveRequestApiController;
use App\Http\Controllers\ApiController\MisspuchApiController;
use App\Http\Controllers\ApiController\UploadImageApiController;

// Admin Side
use App\Http\Controllers\ApiController\ApiAdminController\ApiLoginController;
use App\Http\Controllers\ApiController\ApiAdminController\Employee\EmployeeController;
use App\Http\Controllers\ApiController\ApiAdminController\Attendance\AttendanceController;
use App\Http\Controllers\ApiController\ApiAdminController\Setting\BusinessController;

// User Side
use App\Http\Controllers\ApiController\ApiUserController\Request\MispunchApiController;

use App\Http\Controllers\ApiController\ApiUserController\Login\EmployeeLoginApiController;
use App\Http\Controllers\ApiController\ApiUserController\Employee\EmployeeApiController;
use App\Http\Controllers\ApiController\ApiUserController\Request\GatePassApiController;
use App\Http\Controllers\ApiController\ApiUserController\Attendance\AttendanceApiController;


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

// Full Employee Section *****************************************************
Route::prefix('user')->group(function () {
    Route::prefix('/employee')->group(function () {
        Route::post('/login', [EmployeeLoginApiController::class, 'login']); //QA
        Route::any('/verify_otp', [EmployeeLoginApiController::class, 'VerifiedOtp']);

        Route::any('/master_rule', [EmployeeLoginApiController::class, 'MasterRule']);
        Route::any('/attendance_mode', [EmployeeLoginApiController::class, 'AttendanceMode']);
        Route::any('/shift_type_list', [EmployeeLoginApiController::class, 'ShiftTypeList']);
        Route::prefix('attendance')->group(function () {
            // Route::get('/detail', [AttendanceApiController::class, 'index']); 
            Route::any('/current_attendances_status', [AttendanceApiController::class, 'currentAttendanceStatus']);
            Route::post('/detail', [AttendanceApiController::class, 'store']);
            Route::post('attendance_store', [AttendanceApiController::class, 'storeAttendance']);
            Route::get('detail/{id}', [AttendanceApiController::class, 'show']);
            Route::any('filter_attendance', [AttendanceApiController::class, 'filterAttenDetail']);
            Route::any('attendance_detail', [AttendanceApiController::class, 'attendanceDetail']);
            Route::put('detail/{id}', [AttendanceApiController::class, 'update']);
            Route::delete('detail/{id}', [AttendanceApiController::class, 'destroy']);
        });

        // Route::prefix('/')->group(function () {
        Route::post('employee_details', [EmployeeApiController::class, 'show']);
        // });

        // Leave Request
        Route::prefix('leaverequest')->group(function () {
            // Route::get('detail',[LeaveRequestApiController::class, 'index']);
            Route::post('detail', [LeaveRequestApiController::class, 'store']);
            Route::get('detail/{id}', [LeaveRequestApiController::class, 'show']);
            Route::get('leaveidtodata/{id}', [LeaveRequestApiController::class, 'leaveIdToData']);
            Route::put('detail/{id}', [LeaveRequestApiController::class, 'update']);
            Route::delete('detail/{id}', [LeaveRequestApiController::class, 'destroy']);
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
            Route::put('detail/{id}', [GatePassApiController::class, 'update']);
            Route::any('delete', [GatePassApiController::class, 'destroy']);
        });

        // MisPunch Request
        Route::prefix('mispuchrequest')->group(function () {
            // Route::get('detail',[MispunchApiController::class, 'index']);
            Route::get('detail/{id}', [MispunchApiController::class, 'show']);
            Route::any('mispunch_data_list', [MispunchApiController::class, 'mispunchDataList']);
            Route::post('detail', [MispunchApiController::class, 'store']);
            Route::put('detail/{id}', [MispunchApiController::class, 'update']);
            Route::delete('detail/{id}', [MispunchApiController::class, 'destroy']);

            // Route::delete('detail/{id}',[MispunchApiController::class, 'destroy'])
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
    
    Route::any('/verify_otp', [ApiLoginController::class, 'VerifiedOtp']);
    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/branchlist/{id}', [EmployeeController::class, 'branchList']);
        Route::get('/departmentlist/{id}', [EmployeeController::class, 'departmentList']);
        Route::any('/allemployee', [EmployeeController::class, 'employeeList']);
        Route::any('/camera_permission',[ApiLoginController::class,'cameraPermission']);//check_camera
        Route::post('/attendance_list', [AttendanceController::class, 'allAttendanceList']);
        Route::any('/attend', [ApiLoginController::class, 'attendence']); //Mode attendances
        Route::get('/business_name/{business_id}', [BusinessController::class, 'nameBusiness']); //Mode attendances
        Route::get('/brand_name/{brand_id}', [ApiLoginController::class, 'nameBrand']); //Mode attendances
        Route::get('/totalbranddetails/{business_id}', [ApiLoginController::class, 'nameTotalBrand']); //Mode attendances

        Route::prefix('employee')->group(function () {
            Route::post('/personal_details', [AttendanceController::class, 'allEmployeePersonalData']);


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
