<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CronJobManagement\AutoAttendanceJobSchedular; //CronJob Setup
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CreateBusinessController;
use App\Http\Controllers\admin\Dashboard\DashboardController;
use App\Http\Controllers\admin\Attendance\AttendanceController;
use App\Http\Controllers\admin\Attendance\AttendanceSubmitController;
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
use App\Http\Controllers\admin\Settings\LocalizationController;
use App\Http\Controllers\admin\Settings\ShiftController;
use App\Http\Controllers\admin\setupController\setupController;
use App\Http\Controllers\admin\Settings\RolePermission\NewPermission;
use App\Http\Controllers\ApiController\CalendarController;
use App\Http\Controllers\admin\Report\ImportReportController;
use App\Http\Controllers\admin\Settigs\NotificationController;
use App\Http\Controllers\admin\Tadasetting\TadaController;
use App\Http\Controllers\MigrationController;
// payment-Gateways Load
use App\Http\Controllers\paymentGateway\PhonepeController;
use App\Http\Controllers\paymentGateway\CcAvenueController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ta_and_da;
//used as Live-wire add by jay
use App\Http\Livewire\EmployeeJoiningForm;
use App\Http\Livewire\BusinessRegistration\GstValidation; //live-wire
// use App\Http\Livewire\Admin\EmployeePage;
use App\Http\Livewire\ImageUploadComponent;
// Living Employee Page
use App\Http\Livewire\Admin\EmployeePage; //Replace by EmployeeController or employee-blade
use App\Http\Livewire\Admin\Subscription as SubscriptionLivewire;

// Salary In livewire
use App\Http\Livewire\PayrollManagement\CreateSalaryTemplate;
// Table-View
use App\Http\Livewire\EmployeePageTableView;
use Illuminate\Support\Facades\Artisan;

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
// Route::get('/map',function(){nce

//     return view('admin/setting/business/branches/demomap');
// });

// Route::any('phonepe', [PhonePeController::class, 'phonePe'])->name('phonepemode');
// Route::any('phonepe-response', [PhonePeController::class, 'responseSubmit'])->name('response');
// Route::any('phonepe',[PhonePeController::class,'phonePe'])->name('phonepemode');

Route::any('phonepe-active', [PhonePeController::class, 'nodeMode'])->name('phonepemode');
Route::any('phonepe-response', [PhonePeController::class, 'responseS'])->name('response');

Route::get('/thankyou', [LoginController::class, 'thankyou'])->name('login.thankyou');
Route::get('/companies', [SettingController::class, 'companyDetails']);
Route::any('image-upload-component', ImageUploadComponent::class);


// Route::get('/upload-image', ImageUploader::class)->name('upload.image');
Route::prefix('export')->group(function () {
    Route::prefix('attendance')->group(function () {
        Route::post('daily-attendance-report', [ReportController::class, 'DailyAttendanceReport'])->name('export.DailyAttendanceReport');
        Route::post('employee-muster-roll', [ReportController::class, 'employeeMusterRoll'])->name('export.AttendanceMusterRoll');
        Route::post('employee-monthly-attendance-report', [ReportController::class, 'employeeMonthlyAttendanceReport'])->name('export.EmpAttendanceMusterRoll');
        Route::post('employee-monthly-attendance-report-with-geo-location', [ReportController::class, 'employeeMonthlyAttendanceReportWithGeoLocation'])->name('export.EmpAttendanceMusterRollWithGeoLocation');
        Route::post('employee-monthly-ar-report', [ReportController::class, 'employeeARReport'])->name('export.EmployeeARReport');
    });

    Route::prefix('leave')->group(function () {
        Route::any('export_data/{id}', [ReportController::class, 'LeaveManagement'])->name('export.LeaveMusterRoll');
        Route::post('employee-leave-balance-muster-roll-report', [ReportController::class, 'employeeLeaveBalanceMusterRoll'])->name('export.LeaveMusterRollReport');
        // Route::get('compensatory-off-report', [ReportController::class, 'compensatoryOffReport']);
        // Route::get('monthly-availed-leave-report', [ReportController::class, 'monthlyAvailedLeaveReport']);
        // Route::get('detail-availed-leave-report', [ReportController::class, 'detailAvailedLeaveReport']);
        // Route::get('pending-leave-application-report', [ReportController::class, 'pendingLeaveApplicationReport']);
    });
});

Route::prefix('import')->group(function () {
    Route::post('import-bio-metric-excel-file', [ImportReportController::class, 'ImportBioMetric'])->name('importBiometricExcel');
    Route::post('download-biometric-template', [ImportReportController::class, 'downloadBiometricSample'])->name('BiometricExcelTemplate');
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
        Route::any('/getstate', [CreateBusinessController::class, 'getstate'])->name('getstate');
        Route::any('/getCity', [CreateBusinessController::class, 'getCity'])->name('getCity');
        Route::post('/verify', [CreateBusinessController::class, 'verify'])->name('businessVerify');
    });
    Route::post('/admin/handle-card', [LoginController::class, 'handleCardClick'])->name('admin.handleCard');
});
// Route::any('response', [PhonepeController::class, 'responseSubmit'])->name('response');
Route::get('/checklives', [StudentController::class, 'Loaded']);

Route::middleware(['web', 'email_verified'])->group(function () {

    Route::get('admin/auto_attendance_call', [AutoAttendanceJobSchedular::class, 'AutoAttendanceCall']); //Job TASK Runinning
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::redirect('/admin', '/dashboard', 301);

    Route::get('/logout', [DashboardController::class, 'logout'])->name('admin.logout');
    Route::get('push-notification', [FirebasePushController::class, 'Notification']);
    Route::post('sendNotification', [FirebasePushController::class, 'sendNotification'])->name('send.notification');

    Route::get('subscription', [SettingController::class, 'subscription'])->name('subscription');
    // Route::any('phonepemode', [PhonepeController::class, 'phonePe'])->name('phonepemode');
    // Route::post('razorpay-payment', [RazorpayController::class, 'callPaymentMethod'])->name('razorpay.payment.store');

    // Payment methodly
    Route::prefix('/payment')->group(function () {
        Route::prefix('/rozarpay')->group(function () {
            Route::post('submit-request', [SubscriptionLivewire::class, 'RozaryPay'])->name('rozarpaymode');
            Route::get('thankyou/{id}', [SubscriptionLivewire::class, 'thankyou'])->name('thankyou');
        });
    });

    //exportFileexportFile
    // ExployeePage
    Route::prefix('/export')->group(function () {
        Route::prefix('/employeePage')->group(function () {
            Route::get('export-file/{id}', [EmployeeController::class, 'generateEmployeePage'])->name('employee.page.print');
            // Route::any('/print-mode', [EmployeeController::class,'printMode'])->name('printmode');
        });
    });
    // Route::get('/razorpay_payment', [PhonepeController::class, 'index']);
    // Route::post('/submit _payment', [PhonepeController::class, 'razorpaystore']);
    // Route::get('/ccavenue_payment', [CcAvenueController::class, 'index']);

    Route::prefix('/setup')->group(function () {
        Route::get('/clear-session', [setupController::class, 'clearSession'])->name('clear-session');
        Route::get('/dashboard', [setupController::class, 'dashboard']);
        Route::get('/employee', [setupController::class, 'index']);
        Route::get('/account-settings', [setupController::class, 'accountSetup']);
        Route::get('/set-all-mode', [setupController::class, 'ActiveModeSetup']);
        Route::get('/activepermissioncheck', [setupController::class, 'ActivePermissionCheck']);
        Route::get('/subscription', [setupController::class, 'subscription']);
        Route::prefix('/business-settings')->group(function () {
            Route::get('/', [setupController::class, 'businessSetup']);
            Route::get('/branches', [setupController::class, 'branchesSetup']);
            Route::get('/grade', [setupController::class, 'gradeSetup']);
            Route::get('/department', [setupController::class, 'departmentSetup']);
            Route::get('/designation', [setupController::class, 'designationSetup']);
            Route::get('/holiday', [setupController::class, 'holidayPolicySetup']);
            Route::get('/leave', [setupController::class, 'leavePolicySetup']);
            Route::get('/compoff-lwop', [setupController::class, 'compOffLWPSetup']);
            Route::get('/notice', [setupController::class, 'noticeSetup']);
            Route::get('/weekly-holiday', [setupController::class, 'weeklyHolidaySetup']);
            Route::any('/get_holiday_api', [CalendarController::class, 'getHolidays']);
        });

        Route::prefix('/attendance-settings')->group(function () {
            Route::get('/', [setupController::class, 'attendanceSetup']);
            Route::get('/create_shift', [setupController::class, 'createShiftSetup']);
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
        Route::prefix('/attendance')->group(function () {
            Route::get('/', [AttendanceController::class, 'index']);
            Route::get('/force-update-attendance', [AttendanceSubmitController::class, 'updateAttendancePage']);
            Route::any('/get-Employee-Shift-Details', [AttendanceSubmitController::class, 'getEmpShiftAjax'])->name('EmployeeShiftDetails');
            Route::any('/submit-attendance', [AttendanceSubmitController::class, 'attendanceSubmitPage']);
            Route::any('/dfreeze-attendance/{id}', [AttendanceSubmitController::class, 'DefreezeAttendance'])->name('defreezeAttendance');
            Route::any('/submit-post/{date}', [AttendanceSubmitController::class, 'index'])->name('submitAttendancePage');
            Route::post('/force-correct-attendance', [AttendanceSubmitController::class, 'forcefulyCorrectionMethod'])->name('forceAttendanceCorrection');
            Route::post('/create-submit-attendance', [AttendanceSubmitController::class, 'createAttendanceSubmit'])->name('createSubmitAttendance');
            Route::any('/get-submit-attendance', [AttendanceSubmitController::class, 'getAttendanceSubmitData'])->name('getAttendanceData');
            Route::post('/get-submit-attendance-changes', [AttendanceSubmitController::class, 'onStatusChangeFunction'])->name('onStatusChangeCalculate');
            Route::post('/final-submit-attendance', [AttendanceSubmitController::class, 'finalAttendanceSubmit'])->name('finallySubmitAttendance');
            Route::post('/correct-punch-time', [AttendanceSubmitController::class, 'correctAttendanceTiming'])->name('correctPunchTime');
            Route::get('/pending_attendance_approve', [AttendanceController::class, 'pendingAttendanceApprove']);
            Route::get('/month-summary', [AttendanceController::class, 'attendanceSummary']);
            Route::any('/attendance_mark', [AttendanceController::class, 'attendanceMark'])->name('attendanceMark.checkboxUpdate');
            Route::any('/attendace_update', [AttendanceController::class, 'attendanceUpdate'])->name('attendance.update'); // modal attendace update route
            Route::any('/attendance-count-restore', [AttendanceController::class, 'restoreAllAttendanceCount']);
            Route::post('/dashboard_attendance_count', [AttendanceController::class, 'dashboardAttendanceCountFilter']);
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
            Route::get('/export_file/{id}', [EmployeeController::class, 'ExportFileEmpDetails']);
            Route::any('/import_file', [EmployeeController::class, 'ImportAddEmployeeDetails'])->name('import');;
            Route::get('/add', [EmployeeController::class, 'add']);
            Route::any('/employeefilter', [EmployeeController::class, 'filterEmployees'])->name('filter.employees');
            Route::any('/all_employee', [EmployeeController::class, 'allEmployee']);
            Route::any('/emp_id', [EmployeeController::class, 'empId']);
            Route::any('/emp_id_check', [EmployeeController::class, 'empIdCheck']);
            Route::get('/profile/{id}', [EmployeeController::class, 'empProfile'])->name('employeeProfile');
            Route::post('/update/profile', [EmployeeController::class, 'UpdateContractualEmployee']);
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
            Route::get('/outdoor', [RequestController::class, 'outdoor']);
            Route::get('/leaves', [RequestController::class, 'leaves']);
            Route::get('/gatepass', [RequestController::class, 'gatepass']);
            Route::any('/gatepass/detail', [RequestController::class, 'EditGatepassDataGet']);
            Route::any('/gatepassemployeefilter', [RequestController::class, 'gatepassEmployeeFilter']);
            Route::any('/outdooremployeefilter', [RequestController::class, 'outdoorEmployeeFilter']);
            Route::any('/gatepassdepartmentfilter', [RequestController::class, 'allGatepassFilterDepartment']);
            Route::any('/outdoordepartmentfilter', [RequestController::class, 'allOutdoorFilterDepartment']);
            Route::any('/gatepassdesignationfilter', [RequestController::class, 'allGatepassFilterDesignation']);
            Route::any('/outdoordesignationfilter', [RequestController::class, 'allOutdoorsFilterDesignation']);
            Route::any('/leavedepartmentfilter', [RequestController::class, 'allLeaveFilterDepartment']);
            Route::any('/leavedesignationfilter', [RequestController::class, 'allLeaveFilterDesignation']);
            Route::any('/mispunchdepartmentfilter', [RequestController::class, 'allMispunchFilterDepartment']);
            Route::any('/mispunchdesignationfilter', [RequestController::class, 'allMispunchFilterDesignation']);
            // Route::post('/gatepassupdate/{id}', [RequestController::class, 'UpdateGatepass'])->name('admin.gatepassupdate');
            Route::any('/gatepassdelete', [RequestController::class, 'DestroyGatepass'])->name('admin.gatepassdelete');
            Route::any('/leavedelete', [RequestController::class, 'DestroyLeave'])->name('leavedelete');
            Route::any('/mispunchdelete/{id}', [RequestController::class, 'Destroymispunch'])->name('admin.mispunchdelete');
            Route::any('/mispunch/detail', [RequestController::class, 'EditMispunchDataGet']);
            Route::any('/leave/detail', [RequestController::class, 'EditLeaveDataGet']);
            Route::any('/mispunchemployeefilter', [RequestController::class, 'MispunchEmployeeFilter']);
            Route::any('/leaveemployeefilter', [RequestController::class, 'LeaveEmployeeFilter']);
            Route::post('/gatepassapprove', [RequestController::class, 'ApproveGatepass'])->name('admin.gatepassapprove');
            Route::post('/mispunchapprove', [RequestController::class, 'Approvemispunch'])->name('admin.mispunchapprove');
            Route::post('/leaveupdate', [RequestController::class, 'ApproveLeave'])->name('admin.leaveapprove');
            Route::get('/mispunch', [RequestController::class, 'mispunch']);
            Route::get('/leaves/balance', [RequestController::class, 'leaveBalance']);
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
                Route::post('/address', [SettingController::class, 'saddressupdate'])->name('saddress.update');
                Route::post('/btype/{id}', [SettingController::class, 'sbtypeupdate'])->name('sbussinesstype.update');
                Route::post('/uploadlogo/{id}', [SettingController::class, 'uploadlogo'])->name('upload.logo');
                // Route::post('/email/{id}', [SettingController::class, 'semailupdate'])->name('email.update');
            });

            Route::prefix('/business')->group(function () {
                Route::get('/', [SettingController::class, 'business']);
                Route::get('/admin', [SettingController::class, 'admin']);
                Route::post('/get-state-city-country', [SettingController::class, 'getCountryStateCityAjax'])->name('getCityStateCountry');

                Route::get('/branches', [SettingController::class, 'branches'])->name('admin.branch');
                Route::get('/department', [SettingController::class, 'department'])->name('admin.department');
                Route::any('/designation/{id?}', [SettingController::class, 'designation'])->name('admin.designation');
                Route::any('/grade', [SettingController::class, 'grade'])->name('admin.grade');
                Route::post('/leave_policy_submit', [SettingController::class, 'leavePolicySubmit'])->name('admin.leavepolicySubmit');
                // ajax dropdown  verify usefull
                Route::post('/allrotationalshift', [SettingController::class, 'allRotationalShift']); //save
                Route::post('/allfilterdepartment', [SettingController::class, 'allFilterDepartment']); //save
                Route::post('/allfilterdesignation', [SettingController::class, 'allFilterDesignation']); //save
                Route::any('/alldepartment', [SettingController::class, 'allDepartment']); //save
                Route::post('/alldesignation', [SettingController::class, 'allDesignation']);
                Route::post('/check', [SettingController::class, 'check']);
                Route::post('/allemployeefilter', [SettingController::class, 'allEmployeeFilter']);
                Route::get('/allpermissiontype', [SettingController::class, 'allPermissionType']);
                Route::get('/allbranch', [SettingController::class, 'allBranch']);
                Route::any('/selectbranch', [SettingController::class, 'selectBranch']);
                Route::get('/all_designation_details/{id}', [SettingController::class, 'designationDetails'])->name('admin.editSetValueDesignation');
                Route::any('/all_weekly_holiday', [SettingController::class, 'allWeeklyHoliday']);
                Route::any('/all_leave_policy', [SettingController::class, 'allLeavePolicy']);
                Route::any('/check_master_endgame', [SettingController::class, 'UpdateCheMastEndLeavePolicy']);
                Route::any('/all_holiday_policy', [SettingController::class, 'allHolidayPolicy']);
                //update
                Route::post('/updatebranch', [SettingController::class, 'UpdateBranch'])->name('admin.branchupdate');
                Route::post('/updatedepartment', [SettingController::class, 'UpdateDepartment'])->name('admin.updatedepartment');
                Route::post('/updategrade', [SettingController::class, 'UpdateGrade'])->name('admin.updateGrade');
                Route::post('/updatedesignation', [SettingController::class, 'UpdateDesignation'])->name('admin.designationupdate');
                Route::post('/update_leave_policy', [SettingController::class, 'updateLeavePolicy'])->name('update.leavepolicy');
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
            Route::prefix('/tadasettings')->group(function () {
                Route::get('/testing', [TadaController::class, 'testing']);
                Route::get('/', [TadaController::class, 'index']);
                Route::get('/traveltype', [TadaController::class, 'travelType'])->name('admin.travetypey');
                Route::get('/travelmode', [TadaController::class, 'travelModeCategory'])->name('admin.travemodecategory');
                Route::get('/travelgrade', [TadaController::class, 'travelGrade'])->name('admin.travlegrade');
                Route::get('/lodging', [TadaController::class, 'lodging'])->name('admin.lodging');
                Route::get('/da', [TadaController::class, 'daily_allowance'])->name('admin.daily_allowance');
                Route::post('/trave_allowance_submit', [TadaController::class, 'traveAllowanceSubmit'])->name('admin.traveallowancetada');
                Route::post('/travelmode_submit', [TadaController::class, 'traveModeSubmit'])->name('admin.travelmode');
                Route::any('/countrytocityfilter', [TadaController::class, 'countryToCityFilter'])->name('admin.countrytocityfilter');
                Route::post('/travel_grade_category', [TadaController::class, 'travelGradeCategory'])->name('admin.travelgradecategory');
                Route::get('/travel_types', [TadaController::class, 'travelTypes']);

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
            Route::prefix('/tada')->group(function () {
                Route::get('/', [ta_and_da::class, 'index']);
                Route::get('ta', [ta_and_da::class, 'travel']);
                Route::get('daily', [ta_and_da::class, 'daily']);
                Route::get('lodging', [ta_and_da::class, 'lodging']);
                Route::get('toll', [ta_and_da::class, 'toll']);

                Route::get('other ', [ta_and_da::class, 'other']);
                Route::post('other_amount ', [ta_and_da::class, 'other_amount']);
                Route::post('edit/other_amount ', [ta_and_da::class, 'edit_other_amount']);
                Route::post('delete/other_amount ', [ta_and_da::class, 'deleteotheramount']);
                Route::get('travel_mode', [ta_and_da::class, 'travel_mode_view']);
                Route::get('travel_country', [ta_and_da::class, 'travel_country']);
                Route::post('travel_country/save', [ta_and_da::class, 'travel_country_save']);
                Route::any('/getCity', [ta_and_da::class, 'getCity']);
                // for modes of travel
                Route::post('/differentmodes', [ta_and_da::class, 'select_modes']);
                // for lodging'
                Route::post('/lodging/person', [ta_and_da::class, 'lodgingExp']);
                // for lodging edit
                Route::post('lodgingedit', [ta_and_da::class, 'lodgingedit']);
                Route::get('/city', [ta_and_da::class, 'city']);


                // for save form data of toll
                Route::post('tollcharge', [ta_and_da::class, 'tollexpense']);
                //   for update toll values
                Route::post('update_tollvalues', [ta_and_da::class, 'updateTollList']);
                // delete toll amount
                Route::post('delete/tollamount', [ta_and_da::class, 'deletetollamount']);
            });
            // for payrollsetup
            Route::prefix('/payroll')->group(function () {
                Route::get('/', [PayrollController::class, 'index']);
                Route::get('salaryset', [PayrollController::class, 'salarysetting']);
                Route::get('earnings', [PayrollController::class, 'Earnsetting']);
                Route::get('deductions', [PayrollController::class, 'Deductionsetting']);
                Route::get('indirect/allowance', [PayrollController::class, 'indirect_allowance']);
                Route::post('add/earning', [PayrollController::class, 'addEarning'])->name('add.earning');
                // Route::post('/deductamount', [PayrollController::class, 'add_deduction'])->name('add.deduction');

                Route::post('update/earning', [PayrollController::class, 'updateEarning'])->name('update.earning');
                Route::post('delete/earning', [PayrollController::class, 'deleteEarn']);
                // Route::post('/deductamount', [PayrollController::class, 'adddeduction'])->name('add.deduction');
                Route::post('/salarysetvalues', [PayrollController::class, 'salarysettingvalues']);                // for salarysetvalues
                Route::prefix('/salary_template')->group(function () {
                    Route::get('/', [PayrollController::class, 'salaryTemplateIndex'])->name('salary-template');
                    Route::get('/create_salary_template', [PayrollController::class, 'salaryTemplateCreate'])->name('salary-template-create');
                });

                Route::post('add/indirect_allowance',[PayrollController::class,'indirectAllowanceAdd'])->name('add.indirect_allowance');
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
        Route::post('/attendance-access', [SettingController::class, 'updateAttendanceAccess'])->name('update.AttendanceAccess');
    });

    Route::prefix('/delete')->group(function () {
        Route::post('/branch', [SettingController::class, 'DeleteBranch'])->name('delete.branch');
        Route::post('/department/{id}', [SettingController::class, 'DeleteDepartment'])->name('delete.department');
        Route::post('/grade', [SettingController::class, 'DeleteGrade'])->name('delete.grade');
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
        Route::post('/grade', [SettingController::class, 'AddGrade'])->name('add.grade');
        // Route::post('/employee', [EmployeeController::class, 'AddEmployee'])->name('add.employee');
        Route::post('/employee', [EmployeeJoiningForm::class, 'AddEmployee'])->name('add.employee'); //call by live-wire

        Route::post('/contractual-employee', [EmployeeController::class, 'AddContractualEmployee'])->name('add.employee.contractual');
        Route::post('/holiday', [BusinessController::class, 'CreateHolidays'])->name('add.holiday');
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
