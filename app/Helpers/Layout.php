<?php

namespace App\Helpers;

use App\Models\admin\SidebarMenu;
use App\Models\admin\Branch_list;
use Illuminate\Support\Facades\DB;

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
 }

?>