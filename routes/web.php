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
use App\Http\Controllers\admin\Settings\HolidayPolicyController;
use App\Http\Controllers\admin\Settings\NotificationController;
use App\Http\Controllers\admin\Settings\LocalizationController;
use App\Http\Controllers\admin\Settings\ShiftController;
use App\Http\Controllers\admin\setupController\setupController;
use App\Http\Controllers\admin\Settings\RolePermission\NewPermission;

// payment-Gateways Load
use App\Http\Controllers\paymentGateway\PhonepeController;


//used as Live-wire add by jay
use App\Http\Livewire\EmployeeJoiningForm;
use App\Http\Livewire\BusinessRegistration\GstValidation; //live-wire
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



Route::get('/thankyou', [LoginController::class, 'thankyou'])->name('login.thankyou');
Route::get('/companies', [SettingController::class, 'companyDetails']);

// Route::any('/handlecardclick',[LoginController::class,'handleCardClick'])->name('admin.handleCard');

Route::middleware(['web', 'logincheck'])->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::any('/otp', [LoginController::class, 'login_otp'])->name('login.otp');
        Route::any('/logintype', [LoginController::class, 'loginTypeCheck'])->name('login.type_check');
        Route::any('/submit', [LoginController::class, 'submit'])->name('login.submit');
    });

    Route::get('/gst-validation', GstValidation::class);
    Route::prefix('signup')->group(function () {
        Route::get('/', [CreateBusinessController::class, 'index'])->name('signup');
        Route::get('/otp', [CreateBusinessController::class, 'otp'])->name('signup.otp');
        Route::get('/create', [CreateBusinessController::class, 'create'])->name('createBusiness');
        Route::post('/verify', [CreateBusinessController::class, 'verify'])->name('businessVerify');
    });
    Route::post('/admin/handle-card', [LoginController::class, 'handleCardClick'])->name('admin.handleCard');
});


// Route::middleware(['web'])->get('/custom-route', [CustomController::class, 'customAction']);
Route::get('/payment', function () {
    return <<<HTML
<html>
<head>
<style>
  body, html {
    height: 100%;
    margin-left: 20%;
    justify-content: center;
    align-items: center;
  }
</style>
</head>
<body>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var iframe = document.createElement("iframe");
      iframe.src = "https://phplaravel-1083191-3790162.cloudwaysapps.com/phonepe";
      iframe.style.border = "none";
      iframe.style.width = "40%";
      iframe.style.height = "100%";

      document.body.appendChild(iframe);

      document.body.style.overflow = "hidden";
    });
  </script>
</body>
</html>
HTML;
})->name('payment');


Route::any('phonepe', [PhonepeController::class, 'phonePe'])->name('phonepe');
Route::any('response', [PhonepeController::class, 'responseSubmit']);

// , 'web'

// Route::group(['middleware' => ['web', 'email_verified']], function () {
    Route::middleware(['web', 'email_verified'])->group(function () {
    // Route::group(['middleware' => ['email_verified']], function () {
    // Route::middleware(['email_verified','web'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');
    
    Route::get('subscription', [SettingController::class, 'subscription'])->name('subscription');
    
    Route::get('/razorpay_payment', [PhonepeController::class, 'index']);
    Route::post('/submit_payment', [PhonepeController::class, 'razorpaystore']);

    Route::prefix('/setup')->group(function () {
        Route::get('/employee', [setupController::class, 'index']);
        Route::get('/account-settings', [setupController::class, 'accountSetup']);
        Route::get('/set-all-mode', [setupController::class, 'ActiveModeSetup']);
        Route::get('/subscription', [setupController::class, 'subscription']);
        Route::prefix('/business-settings')->group(function () {
            Route::get('/', [setupController::class, 'businessSetup']);
            Route::get('/branches', [setupController::class, 'branchesSetup']);
            Route::get('/department', [setupController::class, 'departmentSetup']);
            Route::get('/designation', [setupController::class, 'designationSetup']);
            Route::get('/holiday', [setupController::class, 'holidayPolicySetup']);
            Route::get('/leave', [setupController::class, 'leavePolicySetup']);
            Route::get('/notice', [setupController::class, 'noticeSetup']);
            Route::get('/weekly-holiday', [setupController::class, 'weeklyHolidaySetup']);
        });

        Route::prefix('/attendance-settings')->group(function () {
            Route::get('/', [setupController::class, 'attendanceSetup']);
            Route::get('/attendance-access', [setupController::class, 'attendanceAccessSetup']);
            Route::get('/automation', [setupController::class, 'automationSetup']);
            Route::get('/camera-access', [setupController::class, 'cameraAccessSetup']);
        });
    });

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

        Route::controller(NewPermission::class)->group(function () {
            Route::get('/role_permission', 'index');
            Route::post('/role_submit', 'createRoleSubmit')->name('SubmitRole');
            Route::post('/role_permission_submit', 'createAssignPermission')->name('submitAssignPermission');
            Route::post('/delete_permission', 'deletePermission')->name('deletePermissionAssign');
            // new Loading loaded 
            Route::post('/role_permission_updated', 'previewAssignedUsers'); //edit method
            // ajax
            Route::post('/get_assign', 'GetAssignUser');
            // Permission delete
            Route::post('/delete_assign_admin', 'DeleteAdminAssign')->name('deleteAssign');


            // Approval Management
            Route::get('/approval_settings', 'ApprovalSettings');
            Route::post('/approval_submit', 'ApprovalSubmit')->name('approval_submit');
            Route::get('/approval_get_set/{id}','SetApprovalSectionData');//ajax
        });
    });

    Route::prefix('/admin')->group(function () {
        Route::any('/', [DashboardController::class, 'index']);

        Route::prefix('/attendance')->group(function () {
            Route::get('/', [AttendanceController::class, 'index']);
            Route::get('/pending_attendance_approve', [AttendanceController::class, 'pendingAttendanceApprove']);
            Route::get('/month-summary', [AttendanceController::class, 'attendanceSummary']);
            Route::any('/attendance_mark', [AttendanceController::class, 'attendanceMark'])->name('attendanceMark.checkboxUpdate');
            Route::any('/attendace_update', [AttendanceController::class, 'attendanceUpdate'])->name('attendance.update'); // modal attendace update route
            Route::any('/attendance_list_filter', [AttendanceController::class, 'attendanceListFilter']);
            Route::post('/attendance_calculation', [AttendanceController::class, 'allAttendanceCalculationAjax']);
            Route::post('/monthly_attendance_calculation', [AttendanceController::class, 'monthlyAtendanceAjax']);
            Route::get('/details', [AttendanceController::class, 'details'])->name('attendance.detail');
            Route::get('/byemployee/{id}', [AttendanceController::class, 'byemployee'])->name('attendance.byemployee');

            // Route::get('/details/{emp_id}', [AttendanceController::class, 'details'])->name('attendance.detail');
            Route::any('/track_in_out', [AttendanceController::class, 'submitTrackInTrackOut'])->name('attendance.trackInOut');
            // endgames rules
            Route::get('/active_mode_set', [SettingController::class, 'ActiveMode'])->name('attendance.activeMode');
            Route::post('/endgames', [SettingController::class, 'FinalStartRuleEndGame'])->name('attendance.endgameSubmit');

            // Route::get('/submit_endgames', [AttendanceController::class, 'FinalStartRuleEndGame']);

        });

        Route::prefix('/employee')->group(function () {
            Route::get('/', [EmployeeController::class, 'index']);
            Route::get('/export_file', [EmployeeController::class, 'ExportFileEmpDetails']);
            Route::any('/import_file', [EmployeeController::class, 'ImportAddEmployeeDetails'])->name('import');;
            Route::get('/add', [EmployeeController::class, 'add']);
            Route::any('/employeefilter', [EmployeeController::class, 'filterEmployees'])->name('filter.employees');
            Route::any('/all_employee', [EmployeeController::class, 'allEmployee']);
            Route::any('/emp_id', [EmployeeController::class, 'empId']);
            Route::any('/emp_id_check', [EmployeeController::class, 'empIdCheck']);
            Route::get('/profile/{id}', [EmployeeController::class, 'empProfile'])->name('employeeProfile');
            Route::post('/shift_check', [EmployeeController::class, 'shiftCheck']);

            // included live-wire add
            // Route::get('/',EmployeeJoiningForm::class);
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
            Route::any('/gatepass/detail', [RequestController::class, 'EditGatepassDataGet']);
            Route::any('/gatepassemployeefilter', [RequestController::class, 'gatepassEmployeeFilter']);

            // Route::post('/gatepassupdate/{id}', [RequestController::class, 'UpdateGatepass'])->name('admin.gatepassupdate');
            Route::any('/gatepassdelete', [RequestController::class, 'DestroyGatepass'])->name('admin.gatepassdelete');
            Route::any('/leavedelete/{id}', [RequestController::class, 'DestroyLeave'])->name('admin.leavedelete');
            Route::any('/mispunchdelete/{id}', [RequestController::class, 'Destroymispunch'])->name('admin.mispunchdelete');
            Route::any('/mispunch/detail', [RequestController::class, 'EditMispunchDataGet']);
            Route::any('/leave/detail', [RequestController::class, 'EditLeaveDataGet']);
            Route::any('/mispunchemployeefilter', [RequestController::class, 'MispunchEmployeeFilter']);
            Route::any('/leaveemployeefilter', [RequestController::class, 'LeaveEmployeeFilter']);
            Route::post('/gatepassapprove', [RequestController::class, 'ApproveGatepass'])->name('admin.gatepassapprove');
            Route::post('/mispunchapprove', [RequestController::class, 'Approvemispunch'])->name('admin.mispunchapprove');
            Route::post('/leaveupdate', [RequestController::class, 'ApproveLeave'])->name('admin.leaveapprove');

            Route::get('/mispunch', [RequestController::class, 'mispunch']);
        });

        Route::prefix('/settings')->group(function () {
            Route::get('/', [SettingController::class, 'index']);

            Route::get('/roles-and-permissions', [PermissionController::class, 'index'])->name('settings.permission');

            Route::prefix('/localization')->group(function () {
                Route::get('/', [LocalizationController::class, 'index']);
            });

            Route::prefix('/notification')->group(function () {
                Route::get('/', [NotificationController::class, 'index']);
            });

            Route::prefix('/account')->group(function () {
                Route::get('/', [SettingController::class, 'account']);
                Route::any('/businessdetail', [SettingController::class, 'BusinessDetail']);
                // Route::put('/gatepassapprove/{id}', [RequestController::class, 'ApproveGatepass'])->name('admin.gatepassapprove');

                Route::post('/name', [SettingController::class, 'nameupdate'])->name('name.update');
                Route::post('/email/{id}', [SettingController::class, 'semailupdate'])->name('email.update');
                Route::post('/business/{id}', [SettingController::class, 'sbussinessnameupdate'])->name('sbussinessname.update');
                Route::post('/phone/{id}', [SettingController::class, 'sphoneupdate'])->name('sphone.update');
                Route::post('/address/{id}', [SettingController::class, 'saddressupdate'])->name('saddress.update');
                Route::post('/btype/{id}', [SettingController::class, 'sbtypeupdate'])->name('sbussinesstype.update');
                Route::post('/uploadlogo/{id}', [SettingController::class, 'uploadlogo'])->name('upload.logo');
                // Route::post('/email/{id}', [SettingController::class, 'semailupdate'])->name('email.update');
            });

            Route::prefix('/business')->group(function () {
                Route::get('/', [SettingController::class, 'business']);
                Route::get('/admin', [SettingController::class, 'admin']);

                Route::get('/branches', [SettingController::class, 'branches'])->name('admin.branch');
                Route::get('/department', [SettingController::class, 'department'])->name('admin.department');
                Route::any('/designation/{id?}', [SettingController::class, 'designation'])->name('admin.designation');
                Route::post('/leave_policy_submit', [SettingController::class, 'leavePolicySubmit'])->name('admin.leavepolicySubmit');
                // ajax dropdown  verify usefull
                Route::post('/alldepartment', [SettingController::class, 'allDepartment']); //save
                Route::post('/alldesignation', [SettingController::class, 'allDesignation']);
                Route::post('/check', [SettingController::class, 'check']);
                Route::post('/allemployeefilter', [SettingController::class, 'allEmployeeFilter']);
                Route::get('/all_designation_details/{id}', [SettingController::class, 'designationDetails'])->name('admin.editSetValueDesignation');
                Route::any('/all_weekly_holiday', [SettingController::class, 'allWeeklyHoliday']);
                Route::any('/all_leave_policy', [SettingController::class, 'allLeavePolicy']);
                //update 
                Route::post('/updatebranch', [SettingController::class, 'UpdateBranch'])->name('admin.branchupdate');
                Route::post('/updatedepartment', [SettingController::class, 'UpdateDepartment'])->name('admin.updatedepartment');
                Route::post('/updatedesignation', [SettingController::class, 'UpdateDesignation'])->name('admin.designationupdate');
                Route::post('/update_leave_policy', [SettingController::class, 'updateLeavePolicy']);
                Route::post('/delete_leave_policy', [SettingController::class, 'DeleteLeavePolicy'])->name('delete.leavePolicy');
                Route::post('/update_weekly_policy', [SettingController::class, 'updateWeeklyHoliday'])->name('update.WeeklyPolicy');


                // create

                Route::post('/create_weekly_policy', [SettingController::class, 'createWeeklyHoliday'])->name('create.CreateWeeklyPolicy');
                Route::any('/delete_weekly_policy', [SettingController::class, 'deleteWeeklyHoliday'])->name('delete.DeleteWeeklyPolicy');
                Route::get('/holiday_policy', [SettingController::class, 'holidayPolicy']);
                Route::get('/invite_employee', [SettingController::class, 'inviteEmpl']);
                Route::get('/leave_policy', [SettingController::class, 'leavePolicy']);
                Route::get('/manage_emp', [SettingController::class, 'manageEmpDetails']);
                Route::get('/manager', [SettingController::class, 'manager']);
                Route::get('/weekly_holiday', [SettingController::class, 'weeklyHoliday']);
                Route::get('/notice', [SettingController::class, 'notice']);
                Route::post('/create_notice', [SettingController::class, 'createNotice'])->name('create.notice');
            });

            Route::prefix('/business')->group(function () {
                Route::post('/policy_sumbit', [LeavePolicyController::class, 'store'])->name('leave.policy');
                Route::post('/holiday_sumbit', [HolidayPolicyController::class, 'store'])->name('holiday.policy');
                Route::post('/holiday_policy/{id}', [HolidayPolicyController::class, 'DeleteHolidayPolicy'])->name('delete.holidaypolicy');
                Route::post('/holiday_policy_update', [HolidayPolicyController::class, 'UpdateHolidayPolicy'])->name('update.holidaypolicy');
            });

            Route::prefix('/businessinfo')->group(function () {
                Route::get('/', [SettingController::class, 'businessinfo']);
            });

            Route::prefix('/attendance')->group(function () {
                Route::get('/', [SettingController::class, 'attendance']);
                Route::get('/create_shift', [AttendanceController::class, 'createShift']);
                Route::get('/attendance-access', [SettingController::class, 'attendanceAccess']);
                Route::get('/camera-access', [SettingController::class, 'cameraAccess']);
                Route::post('/set-camera-access', [SettingController::class, 'accessCamera'])->name('accessCamera');
                Route::post('/remove-camera-access/{id}', [SettingController::class, 'removeCamera'])->name('removeCamera');
                Route::post('/updateCameraAccess', [SettingController::class, 'updateCamera'])->name('updateCamera');

                // ajax 
                Route::any('/get_datails', [AttendanceController::class, 'getAttendaceShiftList']);
                Route::post('/update_attendace_shift', [AttendanceController::class, 'updateAttendaceShift']);
                // ajax masterrules policy ajax 
                Route::any('get_master_rule', [SettingController::class, 'getMasterRules']);
                Route::post('edit_master_rule', [SettingController::class, 'editMasterRules']);
                Route::any('mode_master_rule', [SettingController::class, 'modeMasterRules']);
                Route::post('delete_master_rule', [SettingController::class, 'deleteMasterRules']);

                Route::prefix('/automation')->group(function () {
                    Route::get('/', [SettingController::class, 'automation']);
                    Route::post('/set', [SettingController::class, 'setAutomationRule'])->name('setAutomationRule');
                });
                Route::get('/att_onHoliday', [SettingController::class, 'attOnHoliday']);
                Route::any('/mode', [SettingController::class, 'setAttendaceMode'])->name('attendanceMode');
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
        Route::post('/holiday', [BusinessController::class, 'UpdateHoliday'])->name('update.holiday');
        Route::post('/leaveTemplate', [SettingController::class, 'UpdateLeaveTemp'])->name('update.leaveTemp');
        Route::post('/attendance-access', [SettingController::class, 'updateAttendanceAccess'])->name('update.AttendanceAccess');
    });

    Route::prefix('/delete')->group(function () {
        Route::post('/branch/{id}', [SettingController::class, 'DeleteBranch'])->name('delete.branch');
        Route::post('/department/{id}', [SettingController::class, 'DeleteDepartment'])->name('delete.department');
        Route::post('/designation/{id}', [SettingController::class, 'DeleteDesignation'])->name('delete.designation');
        Route::post('/employee', [EmployeeController::class, 'DeleteEmployee'])->name('delete.employee');
        Route::post('/holiday', [BusinessController::class, 'DeleteHoliday'])->name('delete.holiday');
        Route::post('/holidayTemplate', [BusinessController::class, 'DeleteHolidayTemp'])->name('delete.holidayTemp');
        Route::post('/leave', [SettingController::class, 'DeleteLeave'])->name('delete.leave');
        Route::post('/shift', [AttendanceController::class, 'deleteShift'])->name('delete.shift');
        Route::post('/attendance-access', [SettingController::class, 'deleteAttendanceAccess'])->name('delete.AttendanceAccess');
        Route::post('/delete_notice/{id}', [SettingController::class, 'deleteNotice'])->name('delete.notice');
    });

    Route::prefix('/add')->group(function () {
        Route::post('/branch', [SettingController::class, 'AddBranch'])->name('add.branch');
        Route::post('/department', [SettingController::class, 'AddDepartment'])->name('add.department');
        Route::post('/designation', [SettingController::class, 'AddDesignation'])->name('add.designation');
        // Route::post('/employee', [EmployeeController::class, 'AddEmployee'])->name('add.employee');
        Route::post('/employee', [EmployeeJoiningForm::class, 'AddEmployee'])->name('add.employee'); //call by live-wire

        Route::post('/contractual-employee', [EmployeeController::class, 'AddContractualEmployee'])->name('add.employee.contractual');
        Route::post('/holiday', [BusinessController::class, 'CreateHoliday'])->name('add.holiday');
        Route::post('/manager', [BusinessController::class, 'AddManager'])->name('add.manager');
        Route::post('/shift', [AttendanceController::class, 'addShift'])->name('add.shift');
        Route::post('/attendance-access', [SettingController::class, 'addAttendanceAccess'])->name('add.AttendanceAccess');
    });
});


// Stronger Route Controller Permanent Method SET LIKE


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
