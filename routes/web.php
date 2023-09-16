<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CreateBusinessController;
use App\Http\Controllers\admin\Dashboard\DashboardController;
use App\Http\Controllers\admin\Attendance\AttendanceController;
use App\Http\Controllers\admin\Employee\EmployeeController;
use App\Http\Controllers\admin\Onlinepay\OnlinepayController;
use App\Http\Controllers\admin\Report\ReportController;
use App\Http\Controllers\admin\Requests\RequestController;
use App\Http\Controllers\admin\Settings\SettingController;
use App\Http\Controllers\admin\Settings\BusinessController;
use App\Http\Controllers\admin\Settings\RolePermission\RolePermissionController;
use App\Http\Controllers\admin\Settings\RolePermission\RoleController;
use App\Http\Controllers\admin\Settings\RolePermission\PermissionController;
use App\Http\Controllers\admin\Settings\LeavePolicyController;
use App\Http\Controllers\admin\Settings\NotificationController;
use App\Http\Controllers\admin\Settings\LocalizationController;
use App\Http\Controllers\admin\Settings\ShiftController;

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



Route::middleware(['logincheck'])->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::any('/otp', [LoginController::class, 'login_otp'])->name('login.otp');
        Route::post('/submit', [LoginController::class, 'submit'])->name('login.submit');
    });

    Route::prefix('signup')->group(function(){
        Route::get('/',[CreateBusinessController::class,'index'])->name('signup');
        Route::get('/otp',[CreateBusinessController::class,'otp'])->name('signup.otp');
        Route::get('/create',[CreateBusinessController::class,'create'])->name('createBusiness');
        Route::post('/verify',[CreateBusinessController::class,'verify'])->name('businessVerify');
    });
});

Route::get('/thankyou', [LoginController::class, 'thankyou'])->name('login.thankyou');

Route::middleware(['email_verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');

    Route::prefix('/Role-permission')->group(function () {
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/permission', 'index');
            Route::post('/permission-add', 'store')->name('permission.add');
        });

        Route::controller(RoleController::class)->group(function () {
            Route::get('/role', 'index')->name('role');
            Route::post('/add', 'store')->name('role.add');
        });

        Route::controller(RolePermissionController::class)->group(function () {
            // Route::get('/allot-permission/{data}','index')->name('rolePermission');
            Route::get('/allot-permission', 'index')->name('rolePermission');
            Route::get('/admin-list', 'AdminList');
            Route::post('/add-admin', 'addAdmin')->name('add.admin');
            Route::any('/make-admin', 'makeAdmin')->name('make.admin');
            Route::post('/assign-permission-to-role', 'assignPermissionToModel')->name('assignPermission.Model');
            Route::post('/assign-role-to-model', 'assignRoleToModel')->name('assign.role');
            Route::post('/get-permissions', 'getPermissions')->name('getPermissions');
            Route::post('/remove-permission', 'removePermission')->name('removePermissions');
        });
    });

    Route::prefix('/admin')->group(function () {
        Route::any('/', [DashboardController::class, 'index']);

        Route::prefix('/attendance')->group(function () {
            Route::get('/', [AttendanceController::class, 'index']);
            Route::get('/details/{emp_id}', [AttendanceController::class, 'details'])->name('attendance.detail');
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
            // Route::post('/gatepassupdate/{id}', [RequestController::class, 'UpdateGatepass'])->name('admin.gatepassupdate');
            Route::any('/gatepassupdate/{id}', [RequestController::class, 'DestroyGatepass'])->name('admin.gatepassdelete');
            Route::put('/gatepassapprove/{id}', [RequestController::class, 'ApproveGatepass'])->name('admin.gatepassapprove');

            Route::get('/misspunch', [RequestController::class, 'misspunch']);
        });

        Route::prefix('/settings')->group(function () {
            Route::get('/', [SettingController::class, 'index']);

            Route::get('/roles-and-permissions', [PermissionController::class, 'index'])->name('settings.permission');
            
            Route::prefix('/localization')->group(function () {
                Route::get('/', [LocalizationController::class, 'index']);
            });

            Route::prefix('/notification')->group(function () {
                Route::get('/',[NotificationController::class,'index']);
            });

            Route::prefix('/account')->group(function () {
                Route::get('/', [SettingController::class, 'account']);
            });

            Route::prefix('/business')->group(function () {
                Route::get('/', [SettingController::class, 'business']);
                Route::get('/admin', [SettingController::class, 'admin']);

                Route::get('/branches', [SettingController::class, 'branches'])->name('admin.branch');
                Route::get('/department', [SettingController::class, 'department'])->name('admin.department');
                Route::any('/designation/{id?}', [SettingController::class, 'designation'])->name('admin.designation');
                Route::post('/leave_policy_submit',[SettingController::class,'leavePolicySubmit'])->name('admin.leavepolicySubmit');
                // ajax dropdown
                Route::post('/alldepartment',[SettingController::class, 'allDepartment']);//save
                Route::get('/all_designation_details/{id}',[SettingController::class,'designationDetails'])->name('admin.editSetValueDesignation');
                //update 
                Route::post('/updatebranch', [SettingController::class, 'UpdateBranch'])->name('admin.branchupdate');
                Route::post('/updatedepartment/{id}', [SettingController::class, 'UpdateDepartment'])->name('admin.updatedepartment');
                Route::post('/updatedesignation/{id}', [SettingController::class, 'UpdateDesignation'])->name('admin.designationupdate');
                
                Route::get('/holiday_policy', [SettingController::class, 'holidayPolicy']);
                Route::get('/invite_employee', [SettingController::class, 'inviteEmpl']);
                Route::get('/leave_policy', [SettingController::class, 'leavePolicy']);
                Route::get('/manage_emp', [SettingController::class, 'manageEmpDetails']);
                Route::get('/manager', [SettingController::class, 'manager']);
                Route::get('/weekly_holiday', [SettingController::class, 'weeklyHoliday']);
            });

            Route::prefix('/business')->group(function () {
                Route::post('/policy_sumbit', [LeavePolicyController::class, 'store'])->name('leave.policy');
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

    Route::prefix('/update')->group(function () {
        Route::post('/employee', [EmployeeController::class, 'UpdateEmployee'])->name('update.employee');
    });

    Route::prefix('/delete')->group(function () {
        Route::post('/branch/{id}', [SettingController::class, 'DeleteBranch'])->name('delete.branch');
        Route::post('/department/{id}', [SettingController::class, 'DeleteDepartment'])->name('delete.department');
        Route::post('/designation/{id}', [SettingController::class, 'DeleteDesignation'])->name('delete.designation');
        Route::post('/employee/{id}', [EmployeeController::class, 'DeleteEmployee'])->name('delete.employee');
    });

    Route::prefix('/add')->group(function () {
        Route::post('/branch', [SettingController::class, 'AddBranch'])->name('add.branch');
        Route::post('/department', [SettingController::class, 'AddDepartment'])->name('add.department');
        Route::post('/designation', [SettingController::class, 'AddDesignation'])->name('add.designation');
        Route::post('/employee', [EmployeeController::class, 'AddEmployee'])->name('add.employee');
        Route::post('/contractual-employee', [EmployeeController::class, 'AddContractualEmployee'])->name('add.employee.contractual');
        Route::post('/holiday', [BusinessController::class, 'CreateHoliday'])->name('add.holiday');
        Route::post('/manager', [BusinessController::class, 'AddManager'])->name('add.manager');
        Route::post('/shift', [ShiftController::class,'addShift'])->name('add.shift');
    });
});

// temprary routes

Route::get('/run-migrations/{tableName}/{name}', [MigrationController::class, 'runMigrations']);

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');

    return 'Cache cleared successfully';
});
