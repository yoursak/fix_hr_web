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
Route::get('settings/helpsetting', function () {
    return view('admin.setting.help.helps');
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

