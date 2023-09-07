<?php

namespace App\Helpers;

use App\Models\admin\SidebarMenu;
use App\Models\admin\Branch_list;
use App\Models\employee\EmployeePersonalDetail;
use App\Models\admin\LoginAdmin;
use App\Models\admin\DepartmentList;
use App\Models\admin\BranchList;

/**
 * Laravel Custom Helper
 *
 * @package		Laravel
 * @subpackage  Layout Helper
 * @category	Helpers
 * @author		Aman Sahu
 */

class ApiResponse
{
    public static function getFirstWord($sentence)
    {
        $words = explode(' ', $sentence);
        if (!empty($words)) {
            return strtolower($words[0]); // Convert the first word to lowercase
        } else {
            return ''; // Return an empty string if the sentence is empty
        }
    }

    public static function concatenateFirstCharacters($sentence)
    {
        $words = explode(' ', $sentence);
        $concatenated = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $concatenated .= strtolower($word[0]);
            }
        }

        return $concatenated;
    }

    public static function customDateFormat($date)
    {
        return date('F j, Y', strtotime($date));
    }

    public static function JsonResponse($parameter)
    {
        return response()->json($parameter);
    }

    // business_id to all branch
    public static function allBranch($parameter)
    {
        $branch = BranchList::where('business_id', $parameter)->get();
        return response()->json(['result'=>$branch]);
    }

    // business_id to all employee
    public static function allEmployee($parameter)
    {
        $emp = EmployeePersonalDetail::where('business_id', $parameter)->get();
        return response()->json($emp);
    }


    // branch to all employee
    public static function branchtoallEmployee($parameter)
    {
        $emp = EmployeePersonalDetail::where('branch_id', $parameter)->get();
        return response()->json(["result"=>$emp]);
        // return response()->json($parameter);
    }

    // branch to all department
    public static function branchtoallDepartment($parameter)
    {
        $depart = DepartmentList::where('branch_id', $parameter)->get();
        return response()->json(["result"=>$depart]);
    }

    // department to all employee list
    public static function departmenttoallEmployeeList($parameter)
    {
        $emp = EmployeePersonalDetail::where('department_id', $parameter)->get();
        return response()->json($emp);
    }

    // public static function allEmployeeByBranchDepartment($parameter)
    // {
    //     $emp = EmployeePersonalDetail::where('department_id', $parameter)->get();
    //     return response()->json($emp);     
    // }
}
