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


 Class Api_response
 {
    public static function Index($parameter){
      return response()->json($parameter);
    }
 }

?>