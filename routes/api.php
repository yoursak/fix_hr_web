<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ApiController\BusinessController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\admin\Employee\EmployeeController;
use App\Http\Controllers\admin\Requests\RequestController;
use App\Http\Controllers\ApiController\ApiLoginController;
use App\Http\Controllers\ApiController\EmployeeLoginApiController;
use App\Http\Controllers\ApiController\EmployeeApiController;
use App\Http\Controllers\ApiController\AttendanceApiController;
use App\Http\Controllers\ApiController\CommonApiController;
use App\Http\Controllers\ApiController\LeaveRequestApiController;
use App\Http\Controllers\ApiController\MisspuchApiController;
use App\Http\Controllers\ApiController\GatePassApiController;
use App\Http\Controllers\ApiController\UploadImageApiController;
// use App\Http\Middleware\LoginMiddleware\ApiLoginCheck;
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

Route::prefix('image')->group(function () {
        Route::post('upload',[UploadImageApiController::class, 'uploadImage']);
});

// Employee Section 
Route::prefix('employee')->group(function () {
    // Leave Request
    Route::prefix('leaverequest')->group(function () {
        // Route::get('detail',[LeaveRequestApiController::class, 'index']);
        Route::post('detail',[LeaveRequestApiController::class, 'store']);
        Route::get('detail/{id}',[LeaveRequestApiController::class, 'show']);
        Route::put('detail/{id}',[LeaveRequestApiController::class, 'update']);
        Route::delete('detail/{id}', [LeaveRequestApiController::class, 'destroy']);
    });

    // Gate Pass Request
    Route::prefix('gatepassrequest')->group(function () {
        // Route::get('detail',[GatePassApiController::class, 'index']);
        Route::post('detail',[GatePassApiController::class, 'store']);
        Route::get('detail/{id}',[GatePassApiController::class, 'show']);
        Route::put('detail/{id}',[GatePassApiController::class, 'update']);
        Route::delete('detail/{id}', [GatePassApiController::class, 'destroy']);
    });

    // Miss Punch Request
    Route::prefix('misspuchrequest')->group(function () {
        // Route::get('detail',[MisspuchApiController::class, 'index']);
        Route::get('detail/{id}', [MisspuchApiController::class, 'show']);
        Route::post('detail',[MisspuchApiController::class, 'store']);
        Route::put('detail/{id}',[MisspuchApiController::class, 'update']);
        Route::delete('detail/{id}',[MisspuchApiController::class, 'destroy']);
        
        // Route::delete('detail/{id}',[MisspuchApiController::class, 'destroy'])
    });
});

Route::any('/bussinesscheck', [CommonApiController::class, 'businesscheck']);

Route::prefix('admin')->group(function () {
    Route::post('/login', [ApiLoginController::class, 'login']);
    Route::any('/verify_otp', [ApiLoginController::class, 'VerifiedOtp']);

    Route::get('/branchlist/{id}', [ApiLoginController::class, 'branchList']);
    Route::get('/departmentlist/{id}', [ApiLoginController::class, 'departmentList']);
    Route::any('/allemployee', [ApiLoginController::class, 'employeeList']);

    Route::any('/attend', [ApiLoginController::class, 'attendence']); //Mode attendances
    Route::get('/business_name/{business_id}', [ApiLoginController::class, 'nameBusiness']); //Mode attendances
    Route::get('/brand_name/{brand_id}', [ApiLoginController::class, 'nameBrand']); //Mode attendances
    Route::get('/totalbranddetails/{business_id}', [ApiLoginController::class, 'nameTotalBrand']); //Mode attendances

    Route::prefix('employee')->group(function () {
        Route::get('detail/{id}', [EmployeeApiController::class, 'show']);
    });
    Route::group(['middleware' => 'apilogincheck'], function () {
        Route::prefix('employee')->group(function () {
            Route::get('/detail', [EmployeeApiController::class, 'index']);
            Route::post('/detail', [EmployeeApiController::class, 'store']);
            // Route::get('detail/{id}', [EmployeeApiController::class, 'show']);
            Route::put('detail/{id}', [EmployeeApiController::class, 'update']);
            Route::delete('detail/{id}', [EmployeeApiController::class, 'destroy']);
            Route::get('detailall/{id}', [EmployeeApiController::class, 'bemployee']);
        });
        Route::prefix('attendance')->group(function () {
            Route::get('/detail', [AttendanceApiController::class, 'index']);
            Route::post('/detail', [AttendanceApiController::class, 'store']);
            Route::get('detail/{id}', [AttendanceApiController::class, 'show']);
            Route::put('detail/{id}', [AttendanceApiController::class, 'update']);
            Route::delete('detail/{id}', [AttendanceApiController::class, 'destroy']);
        });
    });
});

// Employee login section
Route::prefix('employee')->group(function () {
    Route::post('/login', [EmployeeLoginApiController::class, 'login']);
    Route::any('/verify_otp', [EmployeeLoginApiController::class, 'VerifiedOtp']);
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
