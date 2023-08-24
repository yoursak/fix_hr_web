<?php

namespace App\Helpers;

use App\Models\admin\SidebarMenu;
use App\Models\admin\Branch_list;

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
       return  SidebarMenu::select('*')->get();
    }
 }

?>