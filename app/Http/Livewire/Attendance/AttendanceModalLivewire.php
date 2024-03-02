<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use DB;
use Session;
use App\Helpers\Central_unit;

class AttendanceModalLivewire extends Component
{
    public $listeners = ['modeGet'];

    public $InTime,
    $OutTime,
    $TotalWork,
    $InAddress,
    $OutAddress,
    $ShiftName,
    $BreakTime,
    $Overtime,
    $InSelfie,
    $OutSelfie,
    $CorrectedBy,
    $PunchDate,
    $ShiftStart,
    $ShiftEnd,
    $EmpId,
    $Status,
    $Event,
    $EventType,
    $HolidayType,
    $EmpName;





    public function modeGet($data)
    {
        $decodedData = json_decode($data);
        $this->InTime = $decodedData[0];
        $this->OutTime = $decodedData[1];
        $this->TotalWork = $decodedData[2];
        $this->InAddress = $decodedData[3];
        $this->OutAddress = $decodedData[4];
        $this->ShiftName = $decodedData[5];
        $this->BreakTime = $decodedData[6];
        $this->Overtime = $decodedData[7];
        $this->InSelfie = $decodedData[8];
        $this->OutSelfie = $decodedData[9];
        $this->CorrectedBy = $decodedData[10];
        $this->PunchDate = $decodedData[11];
        $this->ShiftStart = $decodedData[12];
        $this->ShiftEnd = $decodedData[13];
        $this->EmpId = $decodedData[14];
        $this->Status = $decodedData[15];
        $this->Event = $decodedData[16];
        $this->EventType = $decodedData[17];
        $this->HolidayType = $decodedData[18];

        // dd($this->OutTime);
        $EmpData = DB::table('employee_personal_details')->where(['business_id'=>Session::get('business_id'),'emp_id'=>$this->EmpId])->first();
        $this->EmpName = $EmpData->emp_name.' '.$EmpData->emp_mname.' '.$EmpData->emp_lname;
    }

    public function render()
    {

        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];
        return view('livewire.attendance.attendance-modal-livewire',compact('permissions','moduleName'));
    }
}
