<?php

namespace App\Helpers;

use App\Models\admin\SidebarMenu;
use App\Models\admin\BranchList;
use App\Models\admin\Department_list;
use App\Models\admin\Designation_list;
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
      return BranchList::select('*')->get();
   }
   static function DepartmentList()
   {
      $department = DB::table('department_list')->join('branch_list', 'department_list.branch_id', '=', 'branch_list.branch_id')->select('*')->get();
      // dd($department);
      return $department;
   }
   static function DesignationList()
   {
      $designation = DB::table('designation_list')->join('department_list', 'designation_list.department_id', '=', 'department_list.depart_id')->select('*')->get();
      // dd($designation);
      return $designation;
   }

   static function EmployeeDetails(){
      $employee =  DB::table('employee_personal_details')->join('designation_list', 'employee_personal_details.emp_designation', '=', 'designation_list.desig_id')->join('department_list', 'employee_personal_details.emp_department', '=', 'department_list.depart_id')->select('*')->get();
      return $employee;
   }

   static function Template(){
      $template = DB::table('holiday_template')->select('*')->get();
      return $template;
   }
   static function Holiday(){
      $template = DB::table('holiday_details')->select('*')->get();
      return $template;
   }

   static function GetAttDetails(){
      $AttList = DB::table('attendance_list')->where('business_id',Session::get('business_id'))->get();
      return $AttList;
  }

   static function GetBusinessType(){
      $AttList = DB::table('business_type_list')->get();
      return $AttList;
  }
   static function Get(){
      $AttList = DB::table('business_type_list')->get();
      return $AttList;
  }
}

?>