<?php

namespace App\Helpers;

use App\Models\admin\SidebarMenu;
use App\Models\admin\Branch_list;
use Illuminate\Support\Facades\DB;
use App\Models\admin\BranchList;
use App\Models\admin\DepartmentList;
use App\Models\admin\DesignationList;

/**
 * Laravel Custom Helper
 *
 * @package		Laravel
 * @subpackage  Layout Helper
 * @category	Helpers
 * @author		Aman Sahu
 */


 Class Layout
 {
    public static function  SidebarList(){
       $title = DB::table("sidebar")->where("status",1)->get();
      return $title;
    }
    public static function  SidebarMenu(){
      $menu = DB::table("sidebar_menu")->where('status',1)->get();
      return $menu;
    }

    public static function BranchName($id){
      $data = BranchList::select('branch_name')->where('branch_id',$id)->first();
      return $data ;
    }

    public static function DepartmentName($id){
      $data = DepartmentList::select('depart_name')->where('depart_id',$id)->first();
      // dd($data);
      return $data ;

    }

    public static function DasignationName($id){
      $data = DesignationList::select('desig_name')->where('desig_id',$id)->first();
      return $data ;
    }
}

?>