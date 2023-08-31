<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\signupController;
use App\Http\Controllers\admin\Dashboard\DashboardController;
use App\Http\Controllers\admin\Attendance\AttendanceController;
use App\Http\Controllers\admin\Employee\EmployeeController;
use App\Http\Controllers\admin\Onlinepay\OnlinepayController;
use App\Http\Controllers\admin\Report\ReportController;
use App\Http\Controllers\admin\Requests\RequestController;
use App\Http\Controllers\admin\Settings\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/error', [LoginController::class, 'error'])->name('login.error');


// Route::controller(AttendanceController::class)->group(function () {
//     Route::get('attendance', 'index')->name('attendance');
//     // Route::get('/orders/{id}', 'show');
//     // Route::post('/orders', 'store');
// });

// Route::prefix('signup')->group(function(){
//     Route::get('/',[signupController::class,'index'])->name('signup');
//     Route::get('/otp',[signupController::class,'signup_otp'])->name('signup.otp');
//     Route::get('/business',[signupController::class,'business'])->name('signup.business');
//     Route::post('/saveemail',[signupController::class,'saveEmail'])->name('signup.email');
//     Route::post('/saveotp',[signupController::class,'saveOTP'])->name('signup.otp');
//     Route::post('/savebusiness',[signupController::class,'saveBusiness'])->name('signup.business');
// });


Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::any('/otp', [LoginController::class, 'login_otp'])->name('login.otp');
    Route::post('/submit', [LoginController::class, 'submit'])->name('login.submit');
});
Route::get('/thankyou', [LoginController::class, 'thankyou'])->name('login.thankyou');
Route::get('/logout', [DashboardController::class, 'logout']);

Route::middleware(['email_verified'])->group(function () {
    
    Route::get('/', [DashboardController::class, 'index']);
   
    Route::prefix('/admin')->group(function () {
        Route::any('/', [DashboardController::class, 'index']);

        Route::prefix('/attendance')->group(function () {
            Route::get('/', [AttendanceController::class, 'index']);
            Route::get('/details', [AttendanceController::class, 'details']);
        });

        Route::prefix('/employee')->group(function () {
            Route::get('/', [EmployeeController::class, 'index']);
            Route::get('/add', [EmployeeController::class, 'add']);
            Route::get('/profile/{id}', [EmployeeController::class, 'empProfile'])->name('employeeProfile');
        });

        Route::prefix('/onlinepay')->group(function () {
            Route::get('/', [OnlinepayController::class, 'index']);
            Route::get('/deduction', [OnlinepayController::class, 'deduction']);
            Route::get('/online_pay', [OnlinepayController::class, 'onlinePay']);
            Route::get('/payment_entry', [OnlinepayController::class, 'paymentEntry']);
        });

        Route::prefix('/report')->group(function () {
            Route::get('/', [ReportController::class, 'index']);
        });

        Route::prefix('/requests')->group(function () {
            Route::get('/leaves', [RequestController::class, 'leaves']);
            Route::get('/gatepass', [RequestController::class, 'gatepass']);
            Route::get('/misspunch', [RequestController::class, 'misspunch']);
        });

        Route::prefix('/settings')->group(function () {
            Route::get('/', [SettingController::class, 'index']);

            Route::prefix('/account')->group(function () {
                Route::get('/', [SettingController::class, 'account']);
            });

            Route::prefix('/business')->group(function () {
                Route::get('/', [SettingController::class, 'business']);
                Route::get('/admin', [SettingController::class, 'admin']);
                Route::get('/branches', [SettingController::class, 'branches'])->name('admin.branch');
                Route::get('/department', [SettingController::class, 'department'])->name('admin.department');
                Route::get('/designation', [SettingController::class, 'designation'])->name('admin.designation');
                Route::get('/holiday_policy', [SettingController::class, 'holidayPolicy']);
                Route::get('/invite_employee', [SettingController::class, 'inviteEmpl']);
                Route::get('/leave_policy', [SettingController::class, 'leavePolicy']);
                Route::get('/manage_emp', [SettingController::class, 'manageEmpDetails']);
                Route::get('/manager', [SettingController::class, 'manager']);
                Route::get('/weekly_holiday', [SettingController::class, 'weeklyHoliday']);
            });

            Route::prefix('/businessinfo')->group(function () {
                Route::get('/', [SettingController::class, 'businessinfo']);
            });

            Route::prefix('/attendance')->group(function () {
                Route::get('/', [SettingController::class, 'attendance']);
                Route::get('/create_shift', [SettingController::class, 'createShift']);
                Route::prefix('/automation')->group(function () {
                    Route::get('/', [SettingController::class, 'automation']);
                    Route::get('/asign_employee', [SettingController::class, 'asignEmp']);
                    Route::get('/break_rule', [SettingController::class, 'breakRule']);
                    Route::get('/early_exit', [SettingController::class, 'earlyExit']);
                    Route::get('/late_entry', [SettingController::class, 'lateEntry']);
                    Route::get('/overtime_rule', [SettingController::class, 'overtimeRule']);
                    Route::get('/early_overtimes', [SettingController::class, 'earlyOvertimes']);
                });
                Route::get('/att_onHoliday', [SettingController::class, 'attOnHoliday']);
            });

            Route::prefix('/salary')->group(function () {
                Route::get('/', [SettingController::class, 'index']);
                Route::get('/salary_structure_temp', [SettingController::class, 'salaryTemp']);
                Route::get('/employee_acc_detail', [SettingController::class, 'EmpAcDetail']);
                Route::get('/other', [SettingController::class, 'other']);
            });
        });
    });
});


Route::prefix('/delete')->group(function () {
    Route::post('/branch/{id}', [SettingController::class, 'DeleteBranch'])->name('delete.branch');
    Route::post('/department/{id}', [SettingController::class, 'DeleteDepartment'])->name('delete.department');
    Route::post('/designation/{id}', [SettingController::class, 'DeleteDesignation'])->name('delete.designation');
});

Route::prefix('/add')->group(function () {
    Route::post('/branch', [SettingController::class, 'AddBranch'])->name('add.branch');
    Route::post('/department', [SettingController::class, 'AddDepartment'])->name('add.department');
    Route::post('/designation', [SettingController::class, 'AddDesignation'])->name('add.designation');
    Route::post('/employee', [EmployeeController::class, 'AddEmployee'])->name('add.employee');
});


// temprary routes


Route::get('/run-migrations/{tableName}/{name}', [MigrationController::class, 'runMigrations']);


Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');

    return "Cache cleared successfully";
});