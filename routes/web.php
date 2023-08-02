<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('admin.dashboard.dashboard');
});

Route::get('/summary', function () {
    return view('admin.dashboard.summary');
});

Route::get('/attendance', function () {
    return view('admin.attendance.attendance');
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
