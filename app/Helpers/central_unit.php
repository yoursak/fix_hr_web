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
// use App\Models\admin\HolidayDetail;
use Session;


class Central_unit
{
   // public ;
   protected static $UserType, $BusinessID, $BranchID, $LoginRole, $LoginName, $LoginEmail, $LoginBusinessImage;

   public function __construct()
   {
      self::$BusinessID = Session::get('business_id');
      self::$UserType = Session::get('user_type');
      self::$BranchID = Session::get('branch_id');
      self::$LoginRole = Session::get('login_role');
      self::$LoginName = Session::get('login_name');
      self::$LoginEmail = Session::get('login_email');
      self::$LoginBusinessImage = Session::get('login_business_image');
      // dd(self::$BusinessID);
   }

   static function BusinessIdToName($email, $businessID)
   {
      $result = DB::table('business_details_list')
         ->where('business_email', $email)
         ->where('business_id', $businessID)->get();
      // ->first(); // Get the first row as an object

      // Check if a result was found
      if ($result) {
         return $result->business_name; // Access the 'business_name' property
      } else {
         // Handle the case where no result was found
         return "No matching business found";
      }
   }
   // standard helpers
   public static function RoleIdToName()
   {
      // $result = DB::table('universal_roles_define')->where('role_id', $roleId)->select('role_name')->first();


      $result = DB::table('roles')->where('id', self::$LoginRole)->select('name')->first();
      // dd($result);
      // Check if a result was found
      if ($result) {
         return $result->name; // Return the role_name property
      } else if (self::$LoginRole == 0) {
         return "Owner";
      } else if (self::$LoginRole == 1) {
         return "Admin";
      } else if (self::$LoginRole == 2) {
         return "Super Admin";
      } else if (self::$LoginRole == 3) {
         return "Employee";
      } else {
         return 'Unknown Role'; // You can change this default value as needed
      }
   }

   public static function BranchList()
   {
      return BranchList::select('*')->where('business_id', self::$BusinessID)->get();
   }
   static function Departmentget($id)
   {
      return DepartmentList::where(['branch_id' => $id, 'business_id' =>  self::$BusinessID])->select('depart_name')->get();
   }
   static function Branchget($id)
   {
      return BranchList::where(['branch_id' => $id, 'business_id' =>  self::$BusinessID])->select('branch_name')->first();
   }
   static function DepartmentList()
   {
      $department = DB::table('department_list')->where(['business_id' =>  self::$BusinessID])->join('branch_list', 'department_list.branch_id', '=', 'branch_list.branch_id')->select('*')->get();
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
         ->where('designation_list.business_id', self::$BusinessID) // Select all columns from all three tables
         ->select('designation_list.*', 'branch_list.*', 'department_list.*')
         ->orderBy('designation_list.desig_id', 'desc') // Order by designation_list.id in descending order
         ->get();
      return $designation;
   }

   static function EmployeeDetails()
   {
      $employee = DB::table('employee_personal_details')->where(['business_id' =>  self::$BusinessID])->select('*')->get();
      return $employee;
   }

   static function Template()
   {
      $template = DB::table('holiday_template')->where(['business_id' =>  self::$BusinessID])->select('*')->get();
      return $template;
   }
   static function Holiday()
   {
      $template = DB::table('holiday_details')->where(['business_id' =>  self::$BusinessID])->select('*')->get();
      return $template;
   }

   static function GetAttDetails()
   {
      $AttList = DB::table('attendance_list')->where(['business_id' =>  self::$BusinessID])->get();
      return $AttList;
   }

   static function GetBusinessType()
   {
      $AttList = DB::table('business_type_list')->get();
      return $AttList;
   }

   static function GetBusinessCategory()
   {
      $AttList = DB::table('business_categories_list')->get();
      return $AttList;
   }

   // static function GetBusinessCategoryName($id){
   //    $data = DB::table('business_categories_list')->find($id);
   //    return $data
   // }

   public static function GetBusinessCategoryName($id)
   {
      $data = DB::table('business_categories_list')->where('id', $id)->first();
      return $data;
   }

   public static function GetBusinessTypeName($id)
   {
      $data = DB::table('business_type_list')->where('id', $id)->first();
      return $data;
   }


   //  business_type_list

   static function Get()
   {
      $AttList = DB::table('business_type_list')->get();
      return $AttList;
   }
   static function GetRoles()
   {
      if (isset(self::$BusinessID) && isset(self::$BranchID)) {
         $Roles = DB::table('roles')
            ->where('business_id', self::$BusinessID)
            ->where('branch_id', self::$BranchID)
            ->select('*') // Select all columns from all three tables
            ->get();
         return $Roles;
      }
      if (isset(self::$BusinessID)) {
         $Roles = DB::table('roles')
            ->where('business_id', self::$BusinessID)
            ->select('*') // Select all columns from all three tables
            ->get();
         return $Roles;

         // ->where('setting_leave_policy.branch_id', $branchID)
      }
      if (isset(self::$BranchID)) {
         $Roles = DB::table('roles')
            ->where('branch_id', self::$BranchID)
            ->select('*') // Select all columns from all three tables
            ->get();
         return $Roles;
      }
      return '';

      // $Roles = DB::table('roles')->where(['business_id' =>  self::$BusinessID])->select('*')->get();
   }

   static function GetModelPermission()
   {
      $ModelPermission = DB::table('model_has_permissions')->where(['model_id' => Session::get('login_emp_id'), 'business_id' =>  self::$BusinessID])->get();
      return $ModelPermission;
   }

   static function GetBranchName()
   {
      $Branch = DB::table('branch_list')::where('branc_id', $request->branch_id)->first();
   }
}
