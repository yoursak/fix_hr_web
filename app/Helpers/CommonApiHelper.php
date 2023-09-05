<?php 
namespace App\Helpers;

/**
 * Laravel Common Api Helper
 *
 * @package		Laravel
 * @subpackage  CommonApiHelper
 * @category	Helpers
 * @author		Umesh Sahu
 */

use App\Models\User;

public static function BranchCheck($branch_id){
    $branch = BranchList::where('branch_id',$branch_id)->first();
    return $branch;
}

?>