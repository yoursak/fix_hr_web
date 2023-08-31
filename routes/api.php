<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\BusinessController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\admin\Employee\EmployeeController;
use App\Http\Controllers\admin\Requests\RequestController;
use App\Http\Controllers\ApiController\ApiLoginController;
use App\Http\Controllers\ApiController\EmployeeLoginApiController   ;
use App\Http\Controllers\ApiController\EmployeeApiController;
// /public_html/app/Http/Controllers/ApiController
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


Route::prefix('admin')->group(function () {
    Route::post('/login', [ApiLoginController::class, 'login']);
    Route::any('/verify_otp', [ApiLoginController::class, 'VerifiedOtp']);
    
    Route::prefix('employee')->group(function () {
        Route::get('/details', [EmployeeApiController::class, 'index']);
        Route::post('/details', [EmployeeApiController::class, 'store']);
        Route::get('/detail/delete/{$id}', [EmployeeApiController::class, 'destroy']);
    }); 
});

// Employee login section 
Route::post('/login', [EmployeeLoginApiController::class, 'login']);
Route::any('/verify_otp', [EmployeeLoginApiController::class, 'VerifiedOtp']);


Route::controller(BusinessController::class)->group(function () {
    Route::any('test','Test');//'uploadImage' image upload test
    Route::get('/business_categories','BusinessCategories');
    Route::get('/business_type','BusinessTypes');
    // Route::post('/login','checkLogin');
   
    // submit businessDetails
    Route::post('/business_details_submit','BusinessDetailsSubmit');
});


Route::get('employee/{id}',[EmployeeApiController::class,'show']);
Route::post('/runmigrations/{tableName}', [EmployeeController::class, 'EmployeeTable']);
Route::any('/employee_add', [EmployeeController::class, 'Store']);
Route::get('/branch', [EmployeeController::class, 'Branch']);
Route::get('/department', [EmployeeController::class, 'Department']);
Route::any('/gatepass/{tableName}', [RequestController::class, 'GatepassTable']);  // Umesh - Employee table route
Route::any('/misspunch/{tableName}', [RequestController::class, 'MisspunchTable']);
// Route::any('login/employee', [LoginApiController::class, 'login']);


// Route::post('login', [LoginApiController::class, 'login'])->name('newlogin');

// Route::post('loginWithOtp', [LoginApiController::class, 'loginWithOtp'])->name('loginWithOtp');
// Route::get('loginWithOtp', function () {
//     return view('auth/OtpLogin');
// })->name('loginWithOtp');

// Route::any('sendOtp', 'LoginApiController@sendOtp');

Route::get('qr', [ApiLoginController::class, 'index']);