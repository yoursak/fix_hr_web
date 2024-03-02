<?php

namespace App\Http\Controllers\ApiController\ApiAdminController\Home;

use App\Exports\ApiUserExport;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use App\Models\admin\Business_categories_list;
use App\Models\admin\Business_type;
use App\Models\admin\AttendanceList;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiResponse;
use App\Helpers\Central_unit;
use App\Http\Resources\Api\AdminSideResponse\Dashboard\DailyCountResource;
use App\Models\Migration;
use DateTime;
use Illuminate\Database\Migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Exports\UsersExport;
use App\Imports\BioMetricImport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Http\Resources\Api\AdminSideResponse\Dashboard\PendingApprovalCountResource;


class DashobardController extends Controller
{
    public function getDashboardCount(Request $request)
    {

        $businessID = $request->business_id;
        $findDate = $request->date;
        $loginRole = $request->login_role;
        $loginEmpID = $request->login_emp_id;
        $getInfomation = Central_unit::getDailyCountForDashboardAndDailyList($businessID, $findDate, $loginRole, $loginEmpID);
        if (!empty($getInfomation)) {
            return response()->json(['result' => [$getInfomation], 'case' => 1, 'message' => 'success'], 200);
        } else {

            return response()->json(['result' => [], 'case' => 2, 'message' => 'failed'], 404);
        }
    }

    public function getPendingApprovalCount(Request $request)
    {
        $businessID = $request->business_id;
        $getInfomation = Central_unit::getThinksToDoCount($businessID);
        if (!empty($getInfomation)) {
            $resource = new PendingApprovalCountResource($getInfomation);

            return response()->json([
                'result' => [$resource],
                'case' => 1,
                'message' => 'success',
            ], 200);
        } else {
            return response()->json(['result' => [], 'case' => 2, 'message' => 'failed'], 404);
        }
    }
    public function getTodayAttendanceReport(Request $request)
    {
        $BID = $request->business_id;
        $Date = $request->date;
        $Emp = DB::table('employee_personal_details')
            ->where('active_emp', 1)
            ->where('business_id', $request->input('business_id', $BID))
            ->orderBy('emp_id')
            ->get();
        $branch = DB::table('branch_list')->where('business_id', $BID)->first();
        $length = $Emp->count();
        $month = date('m', strtotime($Date));
        $year = date('Y', strtotime($Date));
        $day = date('d', strtotime($Date));

        if ($Emp->isEmpty()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No records to export.'], 404);
            } else {
                return redirect()->back()->with('error', 'No records to export.');
            }
        }
        // else

        // return Excel::download(new ApiUserExport($Emp, $length, 7, $month, $year, $day, $branch->branch_name ?? 'All Branch', $BID), 'EmployeeDailyAttendanceReport.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        return Excel::download(
            new ApiUserExport($Emp, $length, 7, $month, $year, $day, $branch->branch_name ?? 'All Branch', $BID),
            'EmployeeDailyAttendanceReport.xlsx',
            \Maatwebsite\Excel\Excel::XLSX
        ); //->withHeaders(['Content-Type' => 'application/vnd.ms-excel'])
        // return Excel::download(new ApiUserExport($Emp, $length, 7, $month, $year, $day, $branch->branch_name ?? 'All Branch', $BID), 'api_user_export.xlsx')->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
