<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use App\Helpers\Central_unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use App\Models\PolicyHolidayDetail;
use App\Models\AttendanceMonthlyCount;
use Carbon\Carbon;
use App\Http\Livewire\Attendance\AttendanceModalLivewire;

class AttendanceByEmployeeLivewire extends Component
{
    use WithPagination;
    public $listeners = ['showPresentModel' => 'modeGet'];

    protected $paginationTheme = 'bootstrap';

    public $EmpID;
    public $monthFilter;
    public $perPage = 10;

    public $AllData = [];


    public function mount($empID)
    {
        $this->EmpID = $empID;
        $this->monthFilter = now()->format('Y-m');
        $this->AllData = [];
    }

    public function showPresentModel($data)
    {

        $this->emit('modeGet', $data);

    }
    public function render()
    {
        $month = date('m', strtotime($this->monthFilter));
        $year = date('Y', strtotime($this->monthFilter));
        $empId = $this->EmpID;
        $totalDay = $month == date('m') && $year == date('Y') ? date('d') : cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $page = $this->perPage;

        $empData = DB::table('employee_personal_details')->join('policy_master_endgame_method', 'employee_personal_details.master_endgame_id', '=', 'policy_master_endgame_method.id')
            ->where('employee_personal_details.business_id', Session::get('business_id'))
            ->where('employee_personal_details.emp_id', $this->EmpID)
            ->select('emp_date_of_joining', 'master_endgame_id', 'emp_id', 'emp_name', 'employee_type', 'employee_contractual_type', 'emp_gender', 'holiday_policy_ids_list', 'weekly_policy_ids_list', 'shift_settings_ids_list', 'leave_policy_ids_list', 'method_name', 'method_switch', 'emp_shift_type', 'policy_master_endgame_method.created_at as AppliedFrom')
            ->first();
        $shift_policy = json_decode($empData->shift_settings_ids_list ?? 0, true);
        $empDetails = DB::table('employee_personal_details')->where(['business_id' => Session::get('business_id'), 'emp_id' => $this->EmpID])->first();
        $shift = $empDetails->assign_shift_type == 2 && $empDetails->assign_shift_type != 0 ? DB::table('policy_attendance_shift_type_items')->where('id', $empDetails->emp_rotational_shift_type_item)->first() : DB::table('policy_attendance_shift_type_items')->where('attendance_shift_id', $empDetails->emp_shift_type)->first();
        $shiftName = DB::table('policy_attendance_shift_settings')->where('id', $shift->attendance_shift_id)->first()->shift_type_name;
        $byAttendanceCalculation = Central_unit::attendanceByEmpDetails($empData->emp_id, $year, $month);
        $monthlyCount = Central_unit::getMonthlyCountFromDB($empData->emp_id, $year, $month, Session::get('business_id'), $empDetails->branch_id);

        $accessPermission = Central_unit::AccessPermission();
        $moduleName = $accessPermission[0];
        $permissions = $accessPermission[1];


        $statusLabels = [
            1 => 'Present', //success
            2 => 'Absent', //danger
            3 => 'Present', //danger
            4 => 'Mispunch', //orange
            5 => '--', //secondary
            6 => 'Holiday', //yellow
            7 => 'Week Off', //gray
            8 => 'Halfday', //yellow
            9 => 'Present', //primary
            10 => 'Leave', //brown
            11 => 'Leave', //brown
            12 => 'Present', // EarlyExit
        ];
        $badgeColors = [
            1 => 'present-status-badge',
            2 => 'absent-status-badge',
            3 => 'present-status-badge',
            4 => 'mispunch-status-badge',
            5 => '',
            6 => 'holiday-status-badge',
            7 => 'weekoff-status-badge',
            8 => 'halfday-status-badge',
            9 => 'present-status-badge',
            10 => 'leave-status-badge',
            11 => 'leave-status-badge',
            12 => 'present-status-badge',
        ];



        for ($Days = 1; $Days <= $totalDay; $Days++) {
            $Date = date('Y-m-d', strtotime($year . '-' . $month . '-' . $Days));
            $index = $Days - 1;
            $status = Central_unit::getAttendanceSummaryDetaisl(['emp_id' => $empDetails->emp_id, 'punch_date' => $Date])[0];

            if (in_array($status, [1, 3, 4, 8, 9, 12])) {
                $list = DB::table('attendance_list')->where('emp_id', $this->EmpID)
                    ->where('punch_date', $Date)
                    ->join('static_attendance_methods', 'attendance_list.working_from_method', '=', 'static_attendance_methods.id')
                    ->select(
                        'attendance_list.*',
                        'static_attendance_methods.method_name',
                        DB::raw("IFNULL(DATE_FORMAT(attendance_list.applied_shift_comp_start_time, '%h:%i %p'), NULL) AS applied_shift_comp_start_time"),
                        DB::raw("IFNULL(DATE_FORMAT(attendance_list.applied_shift_comp_end_time, '%h:%i %p'), NULL) AS applied_shift_comp_end_time"),
                        DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_in_time, '%h:%i %p'), NULL) AS punch_in_time"),
                        DB::raw("IFNULL(DATE_FORMAT(attendance_list.punch_out_time, '%h:%i %p'), NULL) AS punch_out_time"),
                    )
                    ->first();

                $this->AllData[$index] = [
                    'Status' => $status,
                    'Event' => $statusLabels[$status],
                    'EventType' => 1,
                    'HolidayType' => 0,
                    'StatusColor' => $badgeColors[$status],
                    'Date' => date('d-M-Y', strtotime($Date)),
                    'PunchIn' => $list->punch_in_time ?? '--',
                    'PunchOut' => $list->punch_out_time ?? '--',
                    'InAddress' => $list->punch_in_address ?? '',
                    'OutAddress' => $list->punch_out_address ?? '',
                    'ShiftName' => $shiftName ?? '',
                    'ShiftStart' => date('h:i A', strtotime($shift->shift_start)),
                    'ShiftEnd' => date('h:i A', strtotime($shift->shift_end)),
                    'Break' => $list->brack_time ?? 0,
                    'Late' => $list->late_by ?? 0,
                    'Early' => $list->early_exit ?? 0,
                    'Overtime' => $list->overtime ?? 0,
                    'InSelfie' => $list->punch_in_selfie ?? '',
                    'OutSelfie' => $list->punch_out_selfie ?? '',
                    'TotalWorking' => $list->total_working_hour ?? '--',
                ];
            } elseif ($status == 10) {
                $leaveList = DB::table('request_leave_list')
                    ->join('static_leave_category', 'request_leave_list.leave_category', '=', 'static_leave_category.id')
                    ->where('business_id', Session::get('business_id'))
                    ->where('emp_id', $empDetails->emp_id)
                    ->whereDate('from_date', '<=', $Date)
                    ->whereDate('to_date', '>=', $Date)
                    ->where('final_status', 1)
                    ->first();

                $this->AllData[$index] = [
                    'Status' => $status,
                    'Event' => $leaveList->name,
                    'EventType' => 2,
                    'HolidayType' => 0,
                    'StatusColor' => $badgeColors[$status],
                    'Date' => date('d-M-Y', strtotime($Date)),
                    'PunchIn' => '--',
                    'PunchOut' => '--',
                    'InAddress' => '',
                    'OutAddress' => '',
                    'ShiftName' => $shiftName ?? '',
                    'ShiftStart' => date('h:i A', strtotime($shift->shift_start)),
                    'ShiftEnd' => date('h:i A', strtotime($shift->shift_end)),
                    'Break' => 0,
                    'Late' => 0,
                    'Early' => 0,
                    'Overtime' => 0,
                    'InSelfie' => '',
                    'OutSelfie' => '',
                    'TotalWorking' => '--',
                ];
            } elseif (in_array($status, [6, 7])) {
                $holidays = DB::table('attendance_holiday_list')
                    ->where('business_id', Session::get('business_id'))
                    ->where('master_end_method_id', $empData->master_endgame_id)
                    ->where('holiday_date', $Date)
                    ->first();

                $this->AllData[$index] = [
                    'Status' => $status,
                    'Event' => $holidays ? $holidays->name : '',
                    'EventType' => 3,
                    'HolidayType' => $holidays->holiday_type_id ?? 0,
                    'StatusColor' => $badgeColors[$status],
                    'Date' => date('d-M-Y', strtotime($Date)),
                    'PunchIn' => '--',
                    'PunchOut' => '--',
                    'InAddress' => '',
                    'OutAddress' => '',
                    'ShiftName' => $shiftName ?? '',
                    'ShiftStart' => date('h:i A', strtotime($shift->shift_start)),
                    'ShiftEnd' => date('h:i A', strtotime($shift->shift_end)),
                    'Break' => 0,
                    'Late' => 0,
                    'Early' => 0,
                    'Overtime' => 0,
                    'InSelfie' => '',
                    'OutSelfie' => '',
                    'TotalWorking' => '--',
                ];
            } else {
                $this->AllData[$index] = [
                    'Status' => $status,
                    'Event' => $statusLabels[$status],
                    'EventType' => 4,
                    'HolidayType' => 0,
                    'StatusColor' => $badgeColors[$status],
                    'Date' => date('d-M-Y', strtotime($Date)),
                    'PunchIn' => '--',
                    'PunchOut' => '--',
                    'InAddress' => '',
                    'OutAddress' => '',
                    'ShiftName' => $shiftName ?? '',
                    'ShiftStart' => date('h:i A', strtotime($shift->shift_start)),
                    'ShiftEnd' => date('h:i A', strtotime($shift->shift_end)),
                    'Break' => 0,
                    'Late' => 0,
                    'Early' => 0,
                    'Overtime' => 0,
                    'InSelfie' => '',
                    'OutSelfie' => '',
                    'TotalWorking' => '--',
                ];
            }
        }

        $AllDatas = $this->paginate($this->AllData)->withQueryString();
        return view('livewire.attendance.attendance-by-employee-livewire', compact('AllDatas', 'byAttendanceCalculation', 'monthlyCount', 'empDetails', 'permissions', 'moduleName'));
    }
    public function paginate($items)
    {
        $currentPage = $this->page ?: 1;
        $perPage = $this->perPage;

        // Manually paginate the array
        $offset = ($currentPage - 1) * $perPage;
        $items = array_slice($items, $offset, $perPage);

        // Create a LengthAwarePaginator instance
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            count($this->AllData),
            $perPage,
            $currentPage
        );
    }
}
