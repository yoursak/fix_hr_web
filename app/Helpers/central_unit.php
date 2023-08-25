<?php

namespace App\Helpers;

use App\Models\admin\SidebarMenu;
use App\Models\admin\Branch_list;
use App\Models\admin\Department_list;
use App\Models\admin\Designation_list;
use Illuminate\Support\Facades\DB;

/**
 * Laravel Centra Logic Helper
 *
 * @package		Laravel
 * @subpackage  Central Unit Helper
 * @category	Helpers
 * @author		Aman Sahu
 */


class Central_unit
{
   static function BranchList()
   {
      return Branch_list::select('*')->get();
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
}

?>