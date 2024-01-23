<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CronJobManagement\AutoAttendanceJobSchedular; //CronJob Setup

use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CreateBusinessController;
use App\Http\Controllers\admin\Dashboard\DashboardController;
use App\Http\Controllers\admin\Attendance\AttendanceController;
use App\Http\Controllers\admin\Employee\EmployeeController;
use App\Http\Controllers\admin\Onlinepay\OnlinepayController;
use App\Http\Controllers\admin\Report\ReportController;
use App\Http\Controllers\admin\Requests\RequestController;
use App\Http\Controllers\admin\Settings\SettingController;
use App\Http\Controllers\admin\Settings\CompOffController;
use App\Http\Controllers\admin\Settings\BusinessController;
use App\Http\Controllers\admin\Settings\RolePermission\RolePermissionController;
use App\Http\Controllers\admin\Settings\RolePermission\RoleController;
use App\Http\Controllers\admin\Settings\RolePermission\PermissionController;
use App\Http\Controllers\admin\Settings\LeavePolicyController;
use App\Http\Controllers\admin\Settings\HolidayPolicyController;
use App\Http\Controllers\FirebasePushController;
// use App\Http\Controllers\admin\Settings\NotificationController;
use App\Http\Controllers\admin\Settings\LocalizationController;
use App\Http\Controllers\admin\Settings\ShiftController;
use App\Http\Controllers\admin\setupController\setupController;
use App\Http\Controllers\admin\Settings\RolePermission\NewPermission;
use App\Http\Controllers\ApiController\CalendarController;

// payment-Gateways Load
use App\Http\Controllers\paymentGateway\PhonepeController;
use App\Http\Controllers\paymentGateway\CcAvenueController;

//used as Live-wire add by jay
use App\Http\Livewire\EmployeeJoiningForm;
use App\Http\Livewire\BusinessRegistration\GstValidation; //live-wire
// use App\Http\Livewire\Admin\EmployeePage;
use App\Http\Livewire\ImageUploadComponent;
// Living Employee Page
use App\Http\Livewire\Admin\EmployeePage; //Replace by EmployeeController or employee-blade

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
// Route::get('/map',function(){

//     return view('admin/setting/business/branches/demomap');
// });


Route::get('/thankyou', [LoginController::class, 'thankyou'])->name('login.thankyou');
Route::get('/companies', [SettingController::class, 'companyDetails']);
Route::any('image-upload-component', ImageUploadComponent::class);


// Route::get('/upload-image', ImageUploader::class)->name('upload.image');
Route::prefix('export')->group(function () {
    Route::prefix('attendance')->group(function () {
        Route::get('monthly-attendance-report', [ReportController::class, 'monthlyAttendanceReport']);
        Route::get('muster-roll-report', [ReportController::class, 'employeeMusterRoll']);
        Route::get('monthly-late-report', [ReportController::class, 'monthlyLateReport']);
        Route::get('monthly-early-exit-report', [ReportController::class, 'monthlyEarlyExitReport']);
        Route::get('monthly-mispunch-report', [ReportController::class, 'monthlyMispunchReport']);
        Route::get('monthly-overtime-report', [ReportController::class, 'monthlyOvertimeReport']);
        Route::get('monthly-halfday-report', [ReportController::class, 'monthlyHalfdayReport']);
        Route::post('daily-attendance-report', [ReportController::class, 'DailyAttendanceReport'])->name('export.DailyAttendanceReport');
        Route::get('gate-pas-report', [ReportController::class, 'GatePasReport']);
        Route::post('employee-muster-roll', [ReportController::class, 'employeeMusterRoll'])->name('export.AttendanceMusterRoll');
        Route::post('employee-monthly-attendance-report', [ReportController::class, 'employeeMonthlyAttendanceReport'])->name('export.EmpAttendanceMusterRoll');
    });

    Route::prefix('leave')->group(function () {
        Route::post('employee-leave-balance-muster-roll-report', [ReportController::class, 'employeeLeaveBalanceMusterRoll'])->name('export.LeaveMusterRoll');
        Route::get('compensatory-off-report', [ReportController::class, 'compensatoryOffReport']);
        Route::get('monthly-availed-leave-report', [ReportController::class, 'monthlyAvailedLeaveReport']);
        Route::get('detail-availed-leave-report', [ReportController::class, 'detailAvailedLeaveReport']);
        Route::get('pending-leave-application-report', [ReportController::class, 'pendingLeaveApplicationReport']);
    });
});

// Route::any('/handlecardclick',[LoginController::class,'handleCardClick'])->name('admin.handleCard');

Route::get('/', [LoginController::class, 'demoPage']);
Route::middleware(['web', 'logincheck'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::prefix('login')->group(function () {
        Route::any('/otp', [LoginController::class, 'login_otp'])->name('login.otp');
        Route::any('/logintype', [LoginController::class, 'loginTypeCheck'])->name('login.type_check');
        Route::any('/submit', [LoginController::class, 'submit'])->name('login.submit');
    });

    Route::get('/gst-validation', GstValidation::class);
    Route::get('/signup', [CreateBusinessController::class, 'index'])->name('signup');
    Route::prefix('signup')->group(function () {
        Route::get('/otp', [CreateBusinessController::class, 'otp'])->name('signup.otp');
        Route::get('/create', [CreateBusinessController::class, 'create'])->name('createBusiness');
        Route::post('/verify', [CreateBusinessController::class, 'verify'])->name('businessVerify');
    });
    Route::post('/admin/handle-card', [LoginController::class, 'handleCardClick'])->name('admin.handleCard');
});
Route::any('response', [PhonepeController::class, 'responseSubmit'])->name('response');
Route::get('/checklives', [StudentController::class, 'Loaded']);

Route::middleware(['web', 'email_verified'])->group(function () {

    Route::get('admin/auto_attendance_call', [AutoAttendanceJobSchedular::class, 'AutoAttendanceCall']); //Job TASK Runinning
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::redirect('/admin', '/dashboard', 301);

    Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');
    Route::get('push-notification', [FirebasePushController::class, 'Notification']);
    Route::post('sendNotification', [FirebasePushController::class, 'sendNotification'])->name('send.notification');

    Route::get('subscription', [SettingController::class, 'subscription'])->name('subscription');
    Route::any('phonepemode', [PhonepeController::class, 'phonePe'])->name('phonepemode');

    // Route::get('/razorpay_payment', [PhonepeController::class, 'index']);
    // Route::post('/submit_payment', [PhonepeController::class, 'razorpaystore']);
    // Route::get('/ccavenue_payment', [CcAvenueController::class, 'index']);

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
            Route::any('/get_holiday_api', [CalendarController::class, 'getHolidays']);
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
            Route::get('/approval_get_set/{id}', 'SetApprovalSectionData'); //ajax
        });
    });

    Route::prefix('/admin')->group(function () {
        // Route::any('/', [DashboardController::class, 'index']);


        Route::prefix('/attendance')->group(function () {
            Route::get('/', [AttendanceController::class, 'index']);
            Route::get('/submit-attendance', [AttendanceController::class, 'attendanceSubmitPage']);
            Route::get('/pending_attendance_approve', [AttendanceController::class, 'pendingAttendanceApprove']);
            Route::get('/month-summary', [AttendanceController::class, 'attendanceSummary']);
            Route::any('/attendance_mark', [AttendanceController::class, 'attendanceMark'])->name('attendanceMark.checkboxUpdate');
            Route::any('/attendace_update', [AttendanceController::class, 'attendanceUpdate'])->name('attendance.update'); // modal attendace update route
            Route::any('/attendance_list_filter', [AttendanceController::class, 'attendanceListFilter']);
            Route::post('/attendance_by_calculation', [AttendanceController::class, 'AttendanceByAjaxFilter']);
            Route::post('/attendance_calculation', [AttendanceController::class, 'allAttendanceCalculationAjax']);
            Route::post('/dashboard_attendance_count', [AttendanceController::class, 'dashboardAttendanceCountFilter']);
            Route::post('/monthly_attendance_calculation', [AttendanceController::class, 'monthlyAtendanceAjax'])->name('dashboardCount');
            Route::get('/details', [AttendanceController::class, 'details'])->name('attendance.detail');
            Route::get('/byemployee/{id}', [AttendanceController::class, 'byemployee'])->name('attendance.byemployee');

            // Route::get('/details/{emp_id}', [AttendanceController::class, 'details'])->name('attendance.detail');
            Route::any('/track_in_out', [AttendanceController::class, 'submitTrackInTrackOut'])->name('attendance.trackInOut');
            // endgames rules
            Route::get('/active_mode_set', [SettingController::class, 'ActiveMode'])->name('attendance.activeMode');
            Route::post('/endgames', [SettingController::class, 'FinalStartRuleEndGame'])->name('attendance.endgameSubmit');

            // Route::get('/submit_endgames', [AttendanceController::class, 'FinalStartRuleEndGame']);

        });
        // Route::any('/',[EmployeePage::class]);

        Route::prefix('/employee')->group(function () {
            Route::any('/', [EmployeeController::class, 'index']);
            // Route::any('/editStudent/{id}',[EmployeePage::class,'editStudent'])->name('editStudent');
            Route::get('/export_file', [EmployeeController::class, 'ExportFileEmpDetails']);
            Route::any('/import_file', [EmployeeController::class, 'ImportAddEmployeeDetails'])->name('import');;
            Route::get('/add', [EmployeeController::class, 'add']);
            Route::any('/employeefilter', [EmployeeController::class, 'filterEmployees'])->name('filter.employees');
            Route::any('/all_employee', [EmployeeController::class, 'allEmployee']);
            Route::any('/emp_id', [EmployeeController::class, 'empId']);
            Route::any('/emp_id_check', [EmployeeController::class, 'empIdCheck']);
            Route::get('/profile/{id}', [EmployeeController::class, 'empProfile'])->name('employeeProfile');
            Route::post('/shift_check', [EmployeeController::class, 'shiftCheck']);
            Route::post('/country-state', [EmployeeController::class, 'getCountryStateCity']);
            Route::post('/country-city', [EmployeeController::class, 'getStateToCity']);
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
            Route::any('/gatepassdepartmentfilter', [RequestController::class, 'allGatepassFilterDepartment']);
            Route::any('/gatepassdesignationfilter', [RequestController::class, 'allGatepassFilterDesignation']);
            Route::any('/leavedepartmentfilter', [RequestController::class, 'allLeaveFilterDepartment']);
            Route::any('/leavedesignationfilter', [RequestController::class, 'allLeaveFilterDesignation']);
            Route::any('/mispunchdepartmentfilter', [RequestController::class, 'allMispunchFilterDepartment']);
            Route::any('/mispunchdesignationfilter', [RequestController::class, 'allMispunchFilterDesignation']);
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
                Route::get('/', [SettingController::class, 'account'])->name('account.settings');
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
                Route::post('/allrotationalshift', [SettingController::class, 'allRotationalShift']); //save
                Route::post('/allfilterdepartment', [SettingController::class, 'allFilterDepartment']); //save
                Route::post('/allfilterdesignation', [SettingController::class, 'allFilterDesignation']); //save
                Route::post('/alldepartment', [SettingController::class, 'allDepartment']); //save
                Route::post('/alldesignation', [SettingController::class, 'allDesignation']);
                Route::post('/check', [SettingController::class, 'check']);
                Route::post('/allemployeefilter', [SettingController::class, 'allEmployeeFilter']);
                Route::get('/all_designation_details/{id}', [SettingController::class, 'designationDetails'])->name('admin.editSetValueDesignation');
                Route::any('/all_weekly_holiday', [SettingController::class, 'allWeeklyHoliday']);
                Route::any('/all_leave_policy', [SettingController::class, 'allLeavePolicy']);
                Route::any('/all_holiday_policy', [SettingController::class, 'allHolidayPolicy']);
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
                Route::any('/holiday_policy', [SettingController::class, 'holidayPolicy']);
                Route::get('/invite_employee', [SettingController::class, 'inviteEmpl']);
                Route::get('/leave_policy', [SettingController::class, 'leavePolicy']);
                Route::get('/manage_emp', [SettingController::class, 'manageEmpDetails']);
                Route::get('/manager', [SettingController::class, 'manager']);
                Route::get('/weekly_holiday', [SettingController::class, 'weeklyHoliday']);
                Route::get('/notice', [SettingController::class, 'notice']);
                Route::post('/create_notice', [SettingController::class, 'createNotice'])->name('create.notice');
                Route::get('/compoff-lwop', [CompOffController::class, 'CompOffAndWOPPolicyView']);
                Route::post('/compoff-lwop-create', [CompOffController::class, 'CompOffAndWOPPolicyCreate'])->name('createCompOff');
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
                // Route::any('/edit_camera_access_data', [SettingController::class, 'editCameraAccessDataGet']);
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
        Route::post('/branch', [SettingController::class, 'DeleteBranch'])->name('delete.branch');
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
        Route::post('/holiday', [BusinessController::class, 'CreateHolidays']);//->name('add.holiday');
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
