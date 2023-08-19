<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard.dashboard');
    }
}
