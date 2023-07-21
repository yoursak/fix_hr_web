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

