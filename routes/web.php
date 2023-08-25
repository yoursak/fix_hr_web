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
Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');

Route::prefix('login')->group(function(){
    Route::get('/',[LoginController::class,'index'])->name('login');
    Route::post('/otp',[LoginController::class,'login_otp'])->name('login.otp')->middleware('logincheck');
    Route::post('/submit', [LoginController::class, 'submit'])->name('login.submit')->middleware('logincheck');
    Route::post('/error', [LoginController::class, 'error'])->name('login.error');
});


Route::controller(AttendanceController::class)->group(function () {
    Route::get('attendance','index')->name('attendance');
    // Route::get('/orders/{id}', 'show');
    // Route::post('/orders', 'store');
});

// Route::prefix('signup')->group(function(){
//     Route::get('/',[signupController::class,'index'])->name('signup');
//     Route::get('/otp',[signupController::class,'signup_otp'])->name('signup.otp');
//     Route::get('/business',[signupController::class,'business'])->name('signup.business');
//     Route::post('/saveemail',[signupController::class,'saveEmail'])->name('signup.email');
//     Route::post('/saveotp',[signupController::class,'saveOTP'])->name('signup.otp');
//     Route::post('/savebusiness',[signupController::class,'saveBusiness'])->name('signup.business');
// });



Route::prefix('/admin')->group(function(){
    Route::get('/',[DashboardController::class,'index']);

    Route::prefix('/attendance')->group(function(){
        Route::get('/',[AttendanceController::class,'index']);
        Route::get('/details',[AttendanceController::class,'details']);
    });

    Route::prefix('/employee')->group(function(){
        Route::get('/',[EmployeeController::class,'index']);
        Route::get('/add',[EmployeeController::class,'add']);
        Route::get('/profile',[EmployeeController::class,'empProfile']);
    });

    Route::prefix('/onlinepay')->group(function(){
        Route::get('/',[OnlinepayController::class,'index']);
        Route::get('/deduction',[OnlinepayController::class,'deduction']);
        Route::get('/online_pay',[OnlinepayController::class,'onlinePay']);
        Route::get('/payment_entry',[OnlinepayController::class,'paymentEntry']);
    });

    Route::prefix('/report')->group(function(){
        Route::get('/',[ReportController::class,'index']);
    });

    Route::prefix('/requests')->group(function(){
        Route::get('/leaves',[RequestController::class,'leaves']);
        Route::get('/gatepass',[RequestController::class,'gatepass']);
        Route::get('/misspunch',[RequestController::class,'misspunch']);
    });

    Route::prefix('/settings')->group(function(){
        Route::get('/',[SettingController::class,'index']);

        Route::prefix('/account')->group(function(){
            Route::get('/',[SettingController::class,'index']);
        });

        Route::prefix('/business')->group(function(){
            Route::get('/',[SettingController::class,'index']);
            Route::get('/admin',[SettingController::class,'admin']);
            Route::get('/branches',[SettingController::class,'branches'])->name('admin.branch');
            Route::get('/department',[SettingController::class,'department'])->name('admin.department');
            Route::get('/designation',[SettingController::class,'designation'])->name('admin.designation');
            Route::get('/holiday_policy',[SettingController::class,'holidayPolicy']);
            Route::get('/invite_employee',[SettingController::class,'inviteEmpl']);
            Route::get('/leave_policy',[SettingController::class,'leavePolicy']);
            Route::get('/manage_emp',[SettingController::class,'manageEmpDetails']);
            Route::get('/manager',[SettingController::class,'manager']);
            Route::get('/weekly_holiday',[SettingController::class,'weeklyHoliday']);
        });

        Route::prefix('/businessinfo')->group(function(){
            Route::get('/',[SettingController::class,'index']);
        });

        Route::prefix('/attendance')->group(function(){
            Route::get('/',[SettingController::class,'index']);
            Route::get('/create_shift',[SettingController::class,'createShift']);
        });

        Route::prefix('/automation')->group(function(){
            Route::get('/',[SettingController::class,'index']);
        });

        Route::prefix('/salary')->group(function(){
            Route::get('/',[SettingController::class,'index']);
            Route::get('/salary_structure_temp',[SettingController::class,'salaryTemp']);
            Route::get('/employee_acc_detail',[SettingController::class,'EmpAcDetail']);
            Route::get('/other',[SettingController::class,'other']);
        });
    });
});

Route::prefix('/delete')->group(function(){
    Route::post('/branch/{id}',[SettingController::class,'DeleteBranch'])->name('delete.branch');
    Route::post('/department/{id}',[SettingController::class,'DeleteDepartment'])->name('delete.department');
    Route::post('/designation/{id}',[SettingController::class,'DeleteDesignation'])->name('delete.designation');
});

Route::prefix('/add')->group(function(){
    Route::post('/branch',[SettingController::class,'AddBranch'])->name('add.branch');
    Route::post('/department',[SettingController::class,'AddDepartment'])->name('add.department');
    Route::post('/designation',[SettingController::class,'AddDesignation'])->name('add.designation');
});


// temprary routes

Route::get('/admin/login', function () {
    return view('auth.admin.login');
});
Route::get('/admin/signup', function () {
    return view('auth.admin.signup');
});
Route::get('/admin/otp', function () {
    return view('auth.admin.otp');
});
Route::get('/admin/otp_mobile', function () {
    return view('auth.admin.otp_mobile');
});
Route::get('/admin/business', function () {
    return view('auth.admin.business');
});
Route::get('/admin/owner', function () {
    return view('auth.admin.owner');
});
Route::get('/admin/branch', function () {
    return view('auth.admin.branch');
});

Route::get('/employee/login', function () {
    return view('auth.employee.login');
});


// Route::get('/', function () {
//     return view('admin.dashboard.dashboard');
// });

Route::get('/emprofile', function () {
    return view('admin.employees.emp_profile');
});

Route::get('/summary', function () {
    return view('admin.dashboard.summary');
});

// Route::get('/attendance', function () {
//     return view('admin.attendance.attendance');
// });
Route::get('/employee-attendance', function () {
    return view('admin.attendance.emp_attendace');
});

Route::get('/employee', function () {
    return view('admin.employees.employee');
});

Route::get('/employee/add', function () {
    return view('admin.employees.addemp');
});

Route::get('/help', function () {
    return view('admin.help.help');
});

Route::get('/onlinepay', function () {
    return view('admin.onlinepay.onlinepay');
});

Route::get('/payroll', function () {
    return view('admin.payroll.payroll');
});

Route::get('/report', function () {
    return view('admin.reports.report');
});

Route::get('/setting', function () {
    return view('admin.setting.setting');
});
Route::get('/misspunch', function () {
    return view('admin.request.misspunch');
});
Route::get('/leave', function () {
    return view('admin.request.leave');
});
Route::get('/gatepass', function () {
    return view('admin.request.gatepass');
});


Route::get('/setting', function () {
    return view('admin.setting.account.account');
});
Route::get('settings/businesssetting', function () {
    return view('admin.setting.business.business');
});
Route::get('settings/businessinfosetting', function () {
    return view('admin.setting.businessinfo.businessinfo');
});
Route::get('settings/attendancesetting', function () {
    return view('admin.setting.attendance.attendance');
});
Route::get('settings/salarysetting', function () {
    return view('admin.setting.salary.salary');
});
Route::get('settings/salary/salaryTemp/create', function () {
    return view('admin.setting.salary.new_template');
});
Route::get('settings/salary/salaryTemp', function () {
    return view('admin.setting.salary.salary_structure_temp');
});
Route::get('settings/salary/employeeAcc', function () {
    return view('admin.setting.salary.employee_acc_detail');
});
Route::get('settings/othersetting', function () {
    return view('admin.setting.other.other');
});
Route::get('settings/aboutsetting', function () {
    return view('admin.setting.about.about');
});


Route::get('settings/attendancesetting/createshift', function () {
    return view('admin.setting.attendance.createshift');
});

Route::get('settings/attendancesetting/automationrule', function () {
    return view('admin.setting.attendance.automation');
});


Route::get('settings/attendancesetting/attendanceonholiday', function () {
    return view('admin.setting.attendance.attendance_on_holiday');
});
Route::get('settings/attendancesetting/automationrule/asignemp', function () {
    return view('admin.setting.attendance.rules.add_emp');
});
Route::get('settings/attendancesetting/automationrule/break', function () {
    return view('admin.setting.attendance.rules.break_rule');
});
Route::get('settings/attendancesetting/automationrule/earlyexit', function () {
    return view('admin.setting.attendance.rules.early_exit');
});
Route::get('settings/attendancesetting/automationrule/lateentry', function () {
    return view('admin.setting.attendance.rules.late_entry');
});
Route::get('settings/attendancesetting/automationrule/overtime', function () {
    return view('admin.setting.attendance.rules.overtime_rule');
});
Route::get('settings/attendancesetting/automationrule/earlyovertime', function () {
    return view('admin.setting.attendance.rules.early_overtimes');
});


Route::get('settings/business/adminsetting',function(){
    return view('admin.setting.business.admin.admin_setting');
});
Route::get('settings/business/branchesetting',function(){
    return view('admin.setting.business.branches.branches');
});
Route::get('settings/business/department',function(){
    return view('admin.setting.business.department.department');
});
Route::get('settings/business/designation',function(){
    return view('admin.setting.business.designation.designation');
});
Route::get('settings/business/holiday',function(){
    return view('admin.setting.business.holiday_policy.holiday_policy');
});
Route::get('settings/business/invite',function(){
    return view('admin.setting.business.invite_empl.invite_empl');
});
Route::get('settings/business/leave',function(){
    return view('admin.setting.business.leave_policy.leave_policy');
});
Route::get('settings/business/manageEmp',function(){
    return view('admin.setting.business.manage_emp.manage');
});
Route::get('settings/business/manager',function(){
    return view('admin.setting.business.manager.manager');
});
Route::get('settings/business/weeklyholiday',function(){
    return view('admin.setting.business.weekly_holiday.weekly_holiday');
});


Route::get('onlinepay/bulkallowance',function(){
    return view('admin.onlinepay.payment.deductions');
});
Route::get('onlinepay/makepayment',function(){
    return view('admin.onlinepay.payment.online_pay');
});
Route::get('onlinepay/payment_entry',function(){
    return view('admin.onlinepay.payment.payment_entry');
});


Route::get('/run-migrations/{tableName}/{name}', [MigrationController::class, 'runMigrations']);
