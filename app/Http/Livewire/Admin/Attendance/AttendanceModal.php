<?php

namespace App\Http\Livewire\Admin\Attendance;

use Livewire\Component;
use DB;

class AttendanceModal extends Component
{
    public $EmployeeID;
    public $punchDate;


    public function mount($employeeID, $punchDate)
    {
        $this->EmployeeID = $employeeID;
        $this->punchDate = $punchDate;
    }

    public function clickData(){
       dd('aa');
    }
    public function render()
    {
        $data = $this->getEmployeeDetails();
        $correction = $this->getCorrectionDetails();
       
        $EmpID = $data->emp_id;
        $ShiftName = $data->applied_shift_type_name;
        $ShiftStart = $data->applied_shift_comp_start_time;
        $shiftEnd = $data->applied_shift_comp_end_time;
        $BreakTime = $data->brack_time;
        $totalWork = $data->total_working_hour;
        $overtime = $data->overtime;
        
        $punchInLoc = $data->punch_in_address;
        $punchOutLoc = $data->punch_out_address;

        $punchInTime = $data->punch_in_time;
        $punchOutTime = $data->punch_out_time;
        $punchDate = $data->punch_date;

        $correctedBy = $correction->changer_name.'('.$correction->changer_role.')';

        $ROOT = compact('EmpID', 'ShiftName','ShiftStart','shiftEnd','BreakTime','totalWork','overtime','punchInLoc','punchOutLoc','punchInTime','punchOutTime','correctedBy');

        return view('livewire.admin.attendance.attendance-modal', $ROOT);
    }

    public function getEmployeeDetails()
    {
        $empAttendance = DB::table('attendance_list')
            ->where('business_id', session()->get('business_id'))
            ->where(['emp_id' => $this->EmployeeID, 'punch_date' => $this->punchDate])
            ->first();

        return $empAttendance;
    }

    public function getCorrectionDetails(){
        $correction = DB::table('attendance_time_log')->where(['punch_date'=>$this->punchDate,'emp_id'=>$this->EmployeeID])->latest('id')->first();
        return $correction;
    }

}
