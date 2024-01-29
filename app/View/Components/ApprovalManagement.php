<?php

namespace App\View\Components;

use Illuminate\View\Component;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMailer;
use App\Helpers\Layout;
use Illuminate\Support\Facades\DB;
use Session;
use App\Helpers\Central_unit;
use App\Models\admin\setupsettings\MasterEndGameModel;
use Illuminate\Support\Facades\Route;
use App\Helpers\MasterRulesManagement\RulesManagement;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;


class ApprovalManagement extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        //
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $accessPermission = Central_unit::AccessPermission();

        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        $List = RulesManagement::ALLPolicyTemplates();

        $FinalEndGameRule = $List[0];
        $BusinessDetails = $List[1];
        $BranchList = $List[2];
        $LeavePolicy = $List[3];
        $HolidayPolicy = $List[4];
        $weeklyPolicy = $List[5];
        $attendanceModePolicy = $List[6];
        $attendanceShiftPolicy = $List[7];
        $attendanceTrackInOut = $List[8];
        $adminRoleList = $List[10];
// dd($adminRoleList);
        // dd($attendanceTrackInOut)
        // $attendaceShift = DB::table('attendance_shift_settings')->get();
        // alert()->success('Success Title', 'Success Message');

        // alert()->success('Success Title', 'Success Message');
        // alert()->success('Success Title', 'Success Message');
        // Alert::success('Success', 'Updated Rule Method Successfully');

        // dd($LeavePolicy);
        $root = compact('moduleName', 'permissions', 'BusinessDetails', 'FinalEndGameRule', 'BranchList', 'LeavePolicy', 'HolidayPolicy', 'weeklyPolicy', 'attendanceModePolicy', 'attendanceShiftPolicy', 'attendanceTrackInOut', 'adminRoleList');
        // if($casePass==1)
        // {

        //     return view('components.approval-management', $root);
        // }
        return view('components.approval-leaveManagement', $root);
        
    }
}
