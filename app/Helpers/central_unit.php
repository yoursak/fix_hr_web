<?php

namespace App\Helpers;

use App\Models\admin\SidebarMenu;
use App\Models\admin\BranchList;
use App\Models\Permissions\Role;
use App\Models\Permissions\ModelHasPermission;
use App\Models\admin\Department_list;
use App\Models\admin\Designation_list;

use App\Models\admin\DepartmentList;
use App\Models\employee\Employee_Details;
use Illuminate\Support\Facades\DB;
use App\Models\admin\HolidayTemplate;
use App\Models\admin\HolidayDetail;
use Session;

/**
 * Laravel Centra Logic Helper
 *
 * @package		Laravel
 * @subpackage Central Unit Helper
 * @category	Helpers
 * @author		Aman Sahu
 */


class Central_unit
{
   static function BranchList()
   {
      return BranchList::select('*')->where(['business_id' => Session::get('business_id')])->get();
   }
   static function Departmentget($id)
   {
      return DepartmentList::where(['branch_id' => $id, 'business_id' => Session::get('business_id')])->select('depart_name')->get();
   }
   static function Branchget($id)
   {
      return BranchList::where(['branch_id' => $id, 'business_id' => Session::get('business_id')])->select('branch_name')->first();
   }
   static function DepartmentList()
   {
      $department = DB::table('department_list')->where(['business_id' => Session::get('business_id')])->join('branch_list', 'department_list.branch_id', '=', 'branch_list.branch_id')->select('*')->get();
      // dd($department);
      return $department;
   }
   static function LeavePolicyList($businessID, $branchID)
   {

      if (isset($businessID) && isset($branchID)) {
         $Rooted = DB::table('setting_leave_policy')
            ->where('setting_leave_policy.business_id', $businessID)
            ->where('setting_leave_policy.branch_id', $branchID)
            ->select('setting_leave_policy.*') // Select all columns from all three tables
            ->get();
      }
      if (isset($businessID)) {
         $Rooted = DB::table('setting_leave_policy')
            ->where('setting_leave_policy.business_id', $businessID)
            ->select('setting_leave_policy.*') // Select all columns from all three tables
            ->get();
         // ->where('setting_leave_policy.branch_id', $branchID)
      }
      if (isset($branchID)) {
         $Rooted = DB::table('setting_leave_policy')
            ->where('setting_leave_policy.branch_id', $branchID)
            ->select('setting_leave_policy.*') // Select all columns from all three tables
            ->get();
      }
      // ->join('setting_leave_category', 'setting_leave_category.business_id', '=', 'setting_leave_policy.business_id')
      // ->join('setting_leave_category', )
      // ->orderBy('designation_list.desig_id', 'desc') // Order by designation_list.id in descending order
      // ->join('setting_leave_category', 'setting_leave_category.leave_policy_id', '=', 'setting_leave_policy.id')

      return $Rooted;
   }
   static function DesignationList()
   {
      $designation = DB::table('designation_list')
         ->join('branch_list', 'branch_list.branch_id', '=', 'designation_list.branch_id')
         ->join('department_list', 'designation_list.department_id', '=', 'department_list.depart_id')
         ->select('designation_list.*', 'branch_list.*', 'department_list.*') // Select all columns from all three tables
         ->orderBy('designation_list.desig_id', 'desc') // Order by designation_list.id in descending order
         ->get();
      return $designation;
   }

   static function EmployeeDetails()
   {
      $employee = DB::table('employee_personal_details')->where(['business_id' => Session::get('business_id')])->select('*')->get();
      return $employee;
   }

   static function Template()
   {
      $template = DB::table('holiday_template')->where(['business_id' => Session::get('business_id')])->select('*')->get();
      return $template;
   }
   static function Holiday()
   {
      $template = DB::table('holiday_details')->where(['business_id' => Session::get('business_id')])->select('*')->get();
      return $template;
   }

   static function GetAttDetails()
   {
      $AttList = DB::table('attendance_list')->where(['business_id' => Session::get('business_id')])->get();
      return $AttList;
   }

   static function GetBusinessType()
   {
      $AttList = DB::table('business_type_list')->get();
      return $AttList;
   }
   static function Get()
   {
      $AttList = DB::table('business_type_list')->get();
      return $AttList;
   }
   static function GetRoles()
   {
      $Roles = Role::select('*')->get();
      return $Roles;
   }

   static function GetModelPermission()
   {
      $ModelPermission = DB::table('model_has_permissions')->where(['model_id' => Session::get('login_emp_id'), 'business_id' => Session::get('business_id')])->get();
      return $ModelPermission;
   }

   static function GetBranchName()
   {
      $Branch = DB::table('branch_list')::where('branc_id', $request->branch_id)->first();
   }
}
