<?php

namespace App\Exports;

use Carbon\Carbon;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Session;
use Illuminate\Support\Facades\File;

class ApiUserExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    protected $Emp;
    protected $length;
    protected $export_type;
    protected $month;
    protected $year;
    protected $day;
    protected $BranchName;
    protected $BID;
    protected $businesssImage;
    public function __construct($Emp, $length, $export_type, $month, $year, $day, $BranchName, $businessID)
    {
        $this->BID = $businessID;
        $leaveList = [];
        // ->where("branch_id", Session::get('branch_id'))
        $businessDetails = DB::table('business_details_list')
            ->where('business_id', $this->BID)
            ->first();
        $this->businesssImage = $businessDetails->business_logo;
        $branchDetails = DB::table('branch_list')
            ->where('business_id', $this->BID)
            ->first();
        // $leaveType = DB::table('employee_leave_balance')->distinct()->pluck('leave_type');
        $leaveTypes = DB::table('policy_setting_leave_category')
            ->join('static_leave_category', 'policy_setting_leave_category.category_name', '=', 'static_leave_category.id')
            ->where('business_id', $this->BID)
            ->groupBy('category_name')
            ->get();

        foreach ($leaveTypes as $key => $Type) {
            $leaveList[$key] = [
                'name' => $Type->name,
                'categoryId' => $Type->category_name,
            ];
        }

        $this->leaveTypes = $leaveList;
        $this->Emp = $Emp;
        $this->DataLength = $length + 8;
        $this->export_type = $export_type;
        $this->businessName = $businessDetails->business_name;
        $this->branchName = isset($branchDetails) ? $branchDetails->branch_name : $businessDetails->business_name;
        $this->month = $month;
        $this->year = $year;
        $this->day = $day;
        $this->BranchName = $BranchName;
    }
    public function startCell(): string
    {
        return 'A8';
    }

    public function collection()
    {
        if ($this->export_type == 9) {
            $data = [];
            foreach ($this->Emp as $key => $item) {
                $monthDay = $this->month == date('m') ? date('j') : date('t');
                $dataWithActive = [
                    'S.no.' => ++$key,
                    'Name' => $item->emp_name . ' ' . $item->emp_mname . ' ' . $item->emp_lname,
                    'EmpId' => $item->emp_id,
                ];

                for ($count = 1; $count <= $monthDay; $count++) {
                    // dd($count);
                    $resCode = RulesManagement::getAttendanceSummaryDetaisl(['emp_id' => $item->emp_id, 'punch_date' => date($this->year . '-' . $this->month . '-' . $count)], $this->BID);
                    $status = $resCode[0] ?? 2;
                    $formattedDate = $count;
                    if ($resCode[0] == 1 || $resCode[0] == 3 || $resCode[0] == 9 || $resCode[0] == 12) {
                        $dataWithActive[$count] = 'P';
                    } elseif ($resCode[0] == 2) {
                        $dataWithActive[$count] = 'A';
                    } elseif ($resCode[0] == 4) {
                        $dataWithActive[$count] = 'MSP';
                    } elseif ($resCode[0] == 6) {
                        $dataWithActive[$count] = 'HO';
                    } elseif ($resCode[0] == 7) {
                        $dataWithActive[$count] = 'WO';
                    } elseif ($resCode[0] == 10 || $resCode[0] == 11) {
                        $leave = RulesManagement::getEmpLeaveDetails($item->emp_id, date($this->year . '-' . $this->month . '-' . $count), $this->BID);
                        $dataWithActive[$count] = $leave->sort_name;
                    } elseif ($resCode[0] == 8) {
                        $dataWithActive[$count] = 'HD';
                    } else {
                        $dataWithActive[$count] = 'A';
                    }
                }

                $monthlyCount = DB::table('attendance_monthly_count')
                    ->where('month', $this->month)
                    ->where('year', $this->year)
                    ->where('emp_id', $item->emp_id)
                    ->first();
                $total = ($monthlyCount->present ?? 0) + ($monthlyCount->half_day ?? 0) / 2;
                $dataWithActive = array_merge($dataWithActive, [$monthlyCount->present ?? 0, $monthlyCount->absent ?? 0, $monthlyCount->half_day ?? 0, $monthlyCount->leave ?? 0, $monthlyCount->week_off ?? 0, $monthlyCount->holiday ?? 0, $monthlyCount->mispunch ?? 0, $monthlyCount->overtime ?? 0, $monthlyCount->late ?? 0, $monthlyCount->early_exit ?? 0, $total ?? 0]);

                $data[$key + 8] = $dataWithActive;
            }
            return collect($data);
        } elseif ($this->export_type == 1) {
            $dataWithActive = [];
            $startingRow = 7;

            for ($i = 1; $i <= 6; $i++) {
                $dataWithActive[$i] = [];
            }

            foreach ($this->Emp as $key => $item) {
                $monthData = DB::table('attendance_monthly_count')
                    ->where(['emp_id' => $item->emp_id, 'month' => date('m'), 'year' => date('Y')])
                    ->where('business_id', $this->BID)
                    ->first();
                // dd($monthData);
                $rowData = [
                    'S.no.' => ++$key,
                    'Name' => $item->emp_name . ' ' . $item->emp_mname . ' ' . $item->emp_lname,
                    'EmpId' => $item->emp_id,
                    'Present' => ($monthData->present ?? 0) + ($monthData->late ?? 0) + ($monthData->early_exit ?? 0) + ($monthData->overtime ?? 0),
                    'Absent' => $monthData->absent ?? 0,
                    'Halfday' => $monthData->half_day ?? 0,
                    'leave' => $monthData->leave ?? 0,
                    'Mispunch' => $monthData->mispunch ?? 0,
                    'overtime' => $monthData->overtime ?? 0,
                    'Fine' => $monthData->half_day ?? 0,
                    'Total' => ($monthData->present ?? 0) + ($monthData->late ?? 0) + ($monthData->early_exit ?? 0) + ($monthData->overtime ?? 0) + ($monthData->half_day ?? 0),
                ];
                $dataWithActive[$key + $startingRow - 1] = $rowData;
            }

            return collect($dataWithActive);
        } elseif ($this->export_type == 10) {
            $data = [];
            foreach ($this->Emp as $key => $item) {
                $leaveData = [];
                $monthDay = date('t');
                $dataWithActive = [
                    'S.no.' => ++$key,
                    'Name' => $item->emp_name . ' ' . $item->emp_mname . ' ' . $item->emp_lname,
                    'EmpId' => $item->emp_id,
                    'DOJ' => $item->emp_date_of_joining,
                ];

                foreach ($this->leaveTypes as $value) {
                    $leaveData = RulesManagement::calculateLeaveCountApi($item->emp_id, $value['categoryId'], $this->month, $this->year, $this->BID);
                    $dataWithActive = array_merge($dataWithActive, [$leaveData['opening'], $leaveData['alloted'], $leaveData['used'], $leaveData['remaining']]);
                }

                $data[$key + 8] = $dataWithActive;
            }
            // dd($data);
            return collect($data);
        } elseif ($this->export_type == 7) {
            $data = [];
            foreach ($this->Emp as $key => $item) {
                $attendanceDate = date('Y-m-d', strtotime($this->year . '-' . $this->month . '-' . $this->day));
                $empDailyAttendance = DB::table('attendance_list')
                    ->where(['punch_date' => $attendanceDate, 'emp_id' => $item->emp_id, 'business_id' => $this->BID])
                    ->first();
                if (!$empDailyAttendance) {
                    $resCode = RulesManagement::getAttendanceSummaryDetaisl(['emp_id' => $item->emp_id, 'punch_date' => $attendanceDate], $this->BID);
                    if ($resCode[0] == 10) {
                        $leave = RulesManagement::getEmpLeaveDetails($item->emp_id, $attendanceDate, $this->BID);
                        $empStatus = $leave->name;
                    } else {
                        $empStatus = DB::table('static_status_attendance')
                            ->where('id', $empDailyAttendance->today_status ?? 2)
                            ->first();
                        $empStatus = $empStatus->status_labels;
                    }
                } else {
                    $empStatus = DB::table('static_status_attendance')
                        ->where('id', $empDailyAttendance->today_status ?? 2)
                        ->first();
                    $empStatus = $empStatus->status_labels;
                }
                $shiftStartTime = ($empDailyAttendance->applied_shift_comp_start_time ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->applied_shift_comp_start_time) : '-';
                $shiftEndTime = ($empDailyAttendance->applied_shift_comp_end_time ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->applied_shift_comp_end_time) : '-';
                $punchInTime = ($empDailyAttendance->punch_in_time ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->punch_in_time) : '-';
                $punchOutTime = ($empDailyAttendance->punch_out_time ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->punch_out_time) : '-';

                $totalWorking = ($empDailyAttendance->total_working_hour ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->total_working_hour) : '-';

                $shiftStart = ($empDailyAttendance->applied_shift_comp_start_time ?? 0) != 0 ? $shiftStartTime->format('g:i A') : '-';
                $shiftEnd = ($empDailyAttendance->applied_shift_comp_end_time ?? 0) != 0 ? $shiftEndTime->format('g:i A') : '-';
                $punchIn = ($empDailyAttendance->punch_in_time ?? 0) != 0 ? $punchInTime->format('g:i A') : '-';
                $punchOut = ($empDailyAttendance->punch_out_time ?? 0) != 0 ? $punchOutTime->format('g:i A') : '-';
                $punchInOutStatus = $empDailyAttendance->emp_today_current_status ?? 0;

                $empDetails = DB::table('employee_personal_details')
                    ->where(['business_id' => $this->BID, 'emp_id' => $item->emp_id])
                    ->first();
                $shift =
                    $empDetails->assign_shift_type == 2
                        ? DB::table('policy_attendance_shift_type_items')
                            ->where('id', $empDetails->emp_rotational_shift_type_item)
                            ->select('policy_attendance_shift_type_items.*', DB::raw("IFNULL(DATE_FORMAT(policy_attendance_shift_type_items.shift_start, '%h:%i %p'), NULL) AS shift_start"), DB::raw("IFNULL(DATE_FORMAT(policy_attendance_shift_type_items.shift_end, '%h:%i %p'), NULL) AS shift_end"))
                            ->first()
                        : DB::table('policy_attendance_shift_type_items')
                            ->where('attendance_shift_id', $empDetails->emp_shift_type)
                            ->select('policy_attendance_shift_type_items.*', DB::raw("IFNULL(DATE_FORMAT(policy_attendance_shift_type_items.shift_start, '%h:%i %p'), NULL) AS shift_start"), DB::raw("IFNULL(DATE_FORMAT(policy_attendance_shift_type_items.shift_end, '%h:%i %p'), NULL) AS shift_end"))
                            ->first();
                // print_r($shift);

                $dataWithActive = [
                    'S.No.' => ++$key,
                    'Name' => $item->emp_name . ' ' . $item->emp_mname . ' ' . $item->emp_lname,
                    'EmpId' => $item->emp_id,
                    'Shift Name' => isset($empDailyAttendance) ? $empDailyAttendance->applied_shift_template_name ?? '-' : $shift->shift_name ?? '-',
                    'Shift Start' => isset($empDailyAttendance) ? $shiftStart ?? '-' : $shift->shift_start ?? '-',
                    'Shift End' => isset($empDailyAttendance) ? $shiftEnd ?? '-' : $shift->shift_end ?? '-',
                    'Status' => $empStatus ?? '-',
                    'Punch In' => $punchInOutStatus >= 1 ? $punchIn ?? '-' : '-',
                    'Punch Out' => $punchInOutStatus == 2 ? $punchOut ?? '-' : '-',
                    'Break' => $empDailyAttendance->brack_time ?? '-',
                    'Late By' => ($empDailyAttendance->late_by ?? 0) != 0 ? intval($empDailyAttendance->late_by / 60) . ' hr ' . $empDailyAttendance->late_by % 60 . ' min ' : '-',
                    'Early Exit By' => ($empDailyAttendance->early_exit ?? 0) != 0 ? intval($empDailyAttendance->early_exit / 60) . ' hr ' . $empDailyAttendance->early_exit % 60 . ' min ' : '-',
                    'Overtime' => ($empDailyAttendance->overtime ?? 0) != 0 ? intval($empDailyAttendance->overtime / 60) . ' hr ' . $empDailyAttendance->overtime % 60 . ' min ' : '-',
                    'Total Working Hour' => ($empDailyAttendance->total_working_hour ?? 0) != 0 ? $totalWorking->hour . ' hr ' . $totalWorking->minute . ' min ' : '-',
                ];

                $data[$key + 7] = $dataWithActive;
            }
            // dd($data);
            return collect($data);
        } elseif ($this->export_type == 11) {
            $data = [];
            $dayStart = 0;
            $NofDayInMonth = $this->DataLength - 7;
            while ($NofDayInMonth >= ++$dayStart) {
                $attendanceDate = date('Y-m-d', strtotime($dayStart . '-' . $this->month . '-' . $this->year));
                $empDailyAttendance = DB::table('attendance_list')
                    ->where(['punch_date' => $attendanceDate, 'emp_id' => $this->Emp->emp_id, 'business_id' => $this->BID])
                    ->first();
                $Status = RulesManagement::getAttendanceSummaryDetaisl(['punch_date' => $attendanceDate, 'emp_id' => $this->Emp->emp_id], $this->BID);

                if ($Status[0] == 10) {
                    $leave = RulesManagement::getEmpLeaveDetails($this->Emp->emp_id, $attendanceDate, $this->BID);
                    $empStatus = $leave->name;
                } else {
                    $empStatus = DB::table('static_status_attendance')
                        ->where('id', $empDailyAttendance->today_status ?? 2)
                        ->first();
                    $empStatus = $empStatus->status_labels;
                }

                // $empStatus = DB::table('static_status_attendance')->where('id', ($Status[0] ?? 2))->first();
                $shiftStartTime = ($empDailyAttendance->applied_shift_comp_start_time ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->applied_shift_comp_start_time) : '-';
                $shiftEndTime = ($empDailyAttendance->applied_shift_comp_end_time ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->applied_shift_comp_end_time) : '-';
                $punchInTime = ($empDailyAttendance->punch_in_time ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->punch_in_time) : '-';
                $punchOutTime = ($empDailyAttendance->punch_out_time ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->punch_out_time) : '-';

                $totalWorking = ($empDailyAttendance->total_working_hour ?? 0) != 0 ? Carbon::createFromFormat('H:i:s', $empDailyAttendance->total_working_hour) : '-';

                $shiftStart = ($empDailyAttendance->applied_shift_comp_start_time ?? 0) != 0 ? $shiftStartTime->format('g:i A') : '-';
                $shiftEnd = ($empDailyAttendance->applied_shift_comp_end_time ?? 0) != 0 ? $shiftEndTime->format('g:i A') : '-';
                $punchIn = ($empDailyAttendance->punch_in_time ?? 0) != 0 ? $punchInTime->format('g:i A') : '-';
                $punchOut = ($empDailyAttendance->punch_out_time ?? 0) != 0 ? $punchOutTime->format('g:i A') : '-';

                $dataWithActive = [
                    'S.No.' => $dayStart,
                    'Date' => date('d-M-Y', strtotime($attendanceDate)),
                    'Day' => date('l', strtotime($attendanceDate)),
                    'Shift Name' => $empDailyAttendance->applied_shift_template_name ?? '-',
                    'Shift Start' => $shiftStart ?? '-',
                    'Shift End' => $shiftEnd ?? '-',
                    'Status' => $empStatus ?? '-',
                    'Punch In' => $punchIn ?? '-',
                    'Punch Out' => $punchOut ?? '-',
                    'Break' => $empDailyAttendance->brack_time ?? '-',
                    'Late By' => ($empDailyAttendance->late_by ?? 0) != 0 ? intval($empDailyAttendance->late_by / 60) . ' hr ' . $empDailyAttendance->late_by % 60 . ' min ' : '-',
                    'Early Exit By' => ($empDailyAttendance->early_exit ?? 0) != 0 ? intval($empDailyAttendance->early_exit / 60) . ' hr ' . $empDailyAttendance->early_exit % 60 . ' min ' : '-',
                    'Overtime' => ($empDailyAttendance->overtime ?? 0) != 0 ? intval($empDailyAttendance->overtime / 60) . ' hr ' . $empDailyAttendance->overtime % 60 . ' min ' : '-',
                    'Total Working Hour' => ($empDailyAttendance->total_working_hour ?? 0) != 0 ? $totalWorking->hour . ' hr ' . $totalWorking->minute . ' min ' : '-',
                ];

                $data[$dayStart + 7] = $dataWithActive;
            }
            return collect($data);
        } elseif ($this->export_type == 12) {
            $NofDayInMonth = $this->DataLength - 7;
            $dayStart = 0;
            $key = 0;
            while ($NofDayInMonth >= ++$dayStart) {
                $dateFor = date('Y-m-d', strtotime($this->year . '-' . $this->month . '-' . $dayStart));

                $timeLog = self::getTimeLog($dateFor);
                if (isset($timeLog)) {
                    $dataWithActive[] = [
                        'S#' => ++$key,
                        'Punch Date' => $timeLog->punch_date,
                        'Day' => date('l', strtotime($timeLog->punch_date)),
                        'Shift Name' => $timeLog->applied_shift_template_name,
                        'Shift Start' => $timeLog->applied_shift_comp_start_time,
                        'Shift End' => $timeLog->applied_shift_comp_end_time,
                        'Punch In' => $timeLog->prev_in_time,
                        'Punch Out' => $timeLog->prev_out_time,
                        'Working Hour' => $timeLog->prev_total_work,
                        'AR Date' => $timeLog->change_date,
                        'AR In Time' => $timeLog->punch_in_time,
                        'AR Out Time' => $timeLog->punch_out_time,
                        'AR Hour' => $timeLog->total_working_hour,
                        'AR By' => $timeLog->changer_name,
                        'Remark' => $timeLog->reason,
                    ];
                } else {
                    continue;
                }
            }

            $data[$dayStart + 7] = $dataWithActive;
            $this->logLength = count($dataWithActive);

            // dd(count($dataWithActive))s
            return collect($data);
        }
    }

    public function headings(): array
    {
        $load = [];
        if ($this->export_type == 9) {
            $monthDay = $this->month == date('m') ? date('j') : date('t');
            $load = ['S.No.', 'Name', 'EmpId'];

            for ($count = 1; $count <= $monthDay; $count++) {
                $formattedDate = $count;
                $load[] = $formattedDate;
            }

            $load = array_merge($load, ['P', 'A', 'HD', 'L', 'WO', 'HO', 'MSP', 'OT', 'LE', 'EE', 'Total']);
            $this->endPosition = array_search('Total', $load);
        } elseif ($this->export_type == 1) {
            $load = ['S.No.', 'Name', 'EmpId', 'P', 'ABS', 'HD', 'L', 'MSP', 'OT', 'Fine', 'Total'];
        } elseif ($this->export_type == 10) {
            $load = ['S.No.', 'Name', 'EmpId', 'DOJ'];
            foreach ($this->leaveTypes as $key => $value) {
                $load = array_merge($load, ['Opening', 'Alloted', 'Taken', 'Remaining']);
            }

            $this->firstStartPosition = array_search('Opening', $load);
        } elseif ($this->export_type == 7) {
            $load = ['S#', 'Name', 'EmpId', 'Shift Name', 'Shift Start Time', 'Shift End Time', 'Status', 'Punch In', 'Punch Out', 'Break', 'Late By', 'Early Exit By', 'Overtime', 'Total Working Hour'];
        } elseif ($this->export_type == 11) {
            $load = ['S#', 'Date', 'Day', 'Shift Name', 'Shift Start Time', 'Shift End Time', 'Status', 'Punch In', 'Punch Out', 'Break', 'Late By', 'Early Exit By', 'Overtime', 'Total Working Hour'];
        } elseif ($this->export_type == 12) {
            $load = ['S#', 'Date', 'Day', 'Shift Name', 'Shift Start', 'Shift End', 'Punch In', 'Punch Out', 'Working Hour', 'AR Date', 'AR In Time', 'AR Out Time', 'AR Hour', 'AR By', 'Remark'];
        }

        return $load;
    }

    public function registerEvents(): array
    {
        $logoPath = public_path('business_logo/' . $this->businesssImage);

        return [
            AfterSheet::class => function (AfterSheet $event) use ($logoPath) {
                try {
                    $drawing = new Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo Image');
                    $drawing->setPath($logoPath);
                    $drawing->setHeight(90);

                    $drawing->setCoordinates('A1');

                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    $drawing->setWorksheet($event->sheet->getDelegate());

                    // Set business name in C1 cell
                    $event->sheet->getDelegate()->mergeCells('C2:I2');
                    $event->sheet->getDelegate()->setCellValue('C2', $this->businessName);
                    $event->sheet->getDelegate()->mergeCells('C3:I3');
                    $event->sheet->getDelegate()->mergeCells('C4:I4');
                    $event->sheet->getDelegate()->setCellValue('C4', 'For the Month of ' . date('F', strtotime($this->year . '-' . $this->month . '-01')) . '-' . date('Y', strtotime($this->year . '-' . $this->month . '-01')));
                    $event->sheet
                        ->getDelegate()
                        ->getStyle('C2')
                        ->applyFromArray([
                            'font' => [
                                'bold' => true,
                            ],
                        ]);
                    $event->sheet->getDelegate()->mergeCells('C5:I5');
                    $event->sheet->getDelegate()->setCellValue('C5', $this->BranchName);

                    $event->sheet->setShowGridlines(false);

                    $sheet = $event->sheet->getDelegate();

                    $businessNameStyle = $event->sheet->getDelegate()->getStyle('C1');
                    $businessNameStyle->getFont()->setSize(12);
                    $businessNameStyle->getFont()->setBold(true);

                    if ($this->export_type == 9) {
                        $event->sheet->getDelegate()->freezePane('A9');

                        $NumOfDay = $this->month == date('m') ? date('j') : date('t');

                        if ($NumOfDay == 31) {
                            $endCell1 = 'AH';
                            $startCell1 = 'AI';
                            $endCell2 = 'AS';
                        } elseif ($NumOfDay == 30) {
                            $endCell1 = 'AG';
                            $startCell1 = 'AH';
                            $endCell2 = 'AR';
                        } elseif ($NumOfDay == 29) {
                            $endCell1 = 'AF';
                            $startCell1 = 'AG';
                            $endCell2 = 'AQ';
                        } elseif ($NumOfDay == 28) {
                            $endCell1 = 'AE';
                            $startCell1 = 'AF';
                            $endCell2 = 'AP';
                        } else {
                            // $endCell2 = $this->endPosition;
                            $endCell1 = Coordinate::stringFromColumnIndex($this->endPosition - 10);
                            $startCell1 = Coordinate::stringFromColumnIndex($this->endPosition - 9);
                            $endCell2 = Coordinate::stringFromColumnIndex($this->endPosition + 1);
                        }

                        $event->sheet->getDelegate()->setAutoFilter('A8:' . $endCell2 . '8');

                        $event->sheet->getDelegate()->setCellValue('C3', 'Attendance Muster Roll');
                        $event->sheet->getDelegate()->mergeCells('A7:A8');
                        $event->sheet->getDelegate()->setCellValue('A7', 'S#');
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A7:A8')
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A7')
                            ->getAlignment()
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                        $event->sheet->getDelegate()->mergeCells('B7:B8');
                        $event->sheet->getDelegate()->setCellValue('B7', 'Name');
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('B7:B8')
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('B7')
                            ->getAlignment()
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                        $event->sheet->getDelegate()->mergeCells('C7:C8');
                        $event->sheet->getDelegate()->setCellValue('C7', 'Emp ID');
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('C7:C8')
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('C7')
                            ->getAlignment()
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                        $event->sheet->getDelegate()->mergeCells('D7:' . $endCell1 . '7');
                        $event->sheet->getDelegate()->setCellValue('D7', date('F', strtotime($this->year . '-' . $this->month . '-01')) . '-' . date('Y', strtotime($this->year . '-' . $this->month . '-01')));
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('D7:' . $endCell1 . '7')
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('D7')
                            ->getAlignment()
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                        $event->sheet->getDelegate()->mergeCells($startCell1 . '7:' . $endCell2 . '7');
                        $event->sheet->getDelegate()->setCellValue($startCell1 . '7', 'SUMMARY');
                        $event->sheet
                            ->getDelegate()
                            ->getStyle($startCell1 . '7:' . $endCell2 . '7')
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $event->sheet
                            ->getDelegate()
                            ->getStyle($startCell1 . '7')
                            ->getAlignment()
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('D8:' . $endCell2 . $this->DataLength)
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $boldStyle = $event->sheet->getDelegate()->getStyle('A7:' . $endCell2 . '8');
                        $boldStyle->getFont()->setBold(true);

                        $boldBorderStyle = $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:' . $endCell2 . $this->DataLength)
                            ->getBorders();
                        $boldBorderStyle->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                        $event->sheet->getDelegate()->mergeCells('A' . ($this->DataLength + 1) . ':' . $endCell2 . ($this->DataLength + 1));
                        $event->sheet->getDelegate()->setCellValue('A' . ($this->DataLength + 1), 'P => Present, A => Absent, HD => Halfday, L => Leave, WO => Weekoff, HO => Holidfay, MSP => Mispunch, OT => Overtime, LE => Late Entry, EE => Early Exit');
                        $event->sheet->getDelegate()->mergeCells('A' . ($this->DataLength + 3) . ':' . $endCell2 . ($this->DataLength + 3));
                        $event->sheet->getDelegate()->setCellValue('A' . ($this->DataLength + 3), 'Exported By ' . Session::get('login_name') . ' at: ' . now());
                    } elseif ($this->export_type == 1) {
                        $event->sheet->getDelegate()->freezePane('A8');

                        $event->sheet->getDelegate()->setCellValue('C3', 'Monthly Attendance Sheet');
                        $boldStyle = $event->sheet->getDelegate()->getStyle('A6:K6');
                        $boldStyle->getFont()->setBold(true);
                        $boldStyle
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_MEDIUM);
                        $boldStyle
                            ->getBorders()
                            ->getAllBorders()
                            ->getColor()
                            ->setRGB('808080');

                        $boldBorderStyle = $event->sheet
                            ->getDelegate()
                            ->getStyle('A7:K50')
                            ->getBorders();
                        $boldBorderStyle->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                        $boldBorderStyle
                            ->getAllBorders()
                            ->getColor()
                            ->setRGB('808080');
                    } elseif ($this->export_type == 10) {
                        $event->sheet->getDelegate()->setCellValue('C3', 'Employee Leave Balance Muster Roll Report');
                        $event->sheet->getDelegate()->freezePane('A9');

                        if ($this->firstStartPosition !== false) {
                            $position = $this->firstStartPosition;
                            foreach ($this->leaveTypes as $key => $value) {
                                $position += 1;
                                $firstStart = Coordinate::stringFromColumnIndex($position);

                                $position += 3;
                                $firstEnd = Coordinate::stringFromColumnIndex($position);

                                $event->sheet->getDelegate()->mergeCells('A7:D7');
                                $event->sheet->getDelegate()->mergeCells($firstStart . '7:' . $firstEnd . '7');
                                $event->sheet->getDelegate()->setCellValue($firstStart . '7', $value['name']);

                                $boldStyle = $event->sheet->getDelegate()->getStyle('A7:' . $firstEnd . '8');
                                $boldStyle->getFont()->setBold(true);

                                $boldBorderStyle = $event->sheet
                                    ->getDelegate()
                                    ->getStyle('A7:' . $firstEnd . $this->DataLength + 1)
                                    ->getBorders();
                                $boldBorderStyle->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                                $event->sheet
                                    ->getDelegate()
                                    ->getStyle('E7:' . $firstEnd . $this->DataLength + 1)
                                    ->getAlignment()
                                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                                $event->sheet
                                    ->getDelegate()
                                    ->getStyle('A7:D8')
                                    ->getAlignment()
                                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                            }
                            $event->sheet->getDelegate()->setAutoFilter('A8:' . $firstEnd . '8');

                            $positionCounter = $this->firstStartPosition + 1;

                            while ($positionCounter <= $position) {
                                $Cell = Coordinate::stringFromColumnIndex($positionCounter++);
                                $event->sheet->getColumnDimension($Cell)->setAutoSize(false);
                                $event->sheet->getColumnDimension($Cell)->setWidth(12);
                                $event->sheet
                                    ->getDelegate()
                                    ->getStyle($Cell)
                                    ->getAlignment()
                                    ->setWrapText(true);
                            }

                            // die;
                        } else {
                            // "Opening" not found in headers
                            dd('Opening not found in headers');
                        }
                    } elseif ($this->export_type == 7) {
                        $event->sheet->getColumnDimension('A')->setAutoSize(false);
                        $event->sheet->getColumnDimension('A')->setWidth(5);
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setWrapText(true);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:A' . $this->DataLength)
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $event->sheet->getDelegate()->setCellValue('C4', 'For the Date of  ' . date('d-M-Y', strtotime($this->year . '-' . $this->month . '-' . $this->day)) . ' ' . date('l', strtotime($this->year . '-' . $this->month . '-' . $this->day)));

                        $event->sheet->getDelegate()->setCellValue('C3', 'Employee Daily Attendance Report');
                        $event->sheet->getDelegate()->freezePane('A9');
                        $event->sheet->getDelegate()->setAutoFilter('A8:N8');

                        $boldStyle = $event->sheet->getDelegate()->getStyle('A8:N8');
                        $boldStyle->getFont()->setBold(true);

                        $boldBorderStyle = $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:N' . $this->DataLength)
                            ->getBorders();
                        $boldBorderStyle->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:C8')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('D8:N' . $this->DataLength)
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $columns = ['E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];

                        foreach ($columns as $column) {
                            $event->sheet->getColumnDimension($column)->setAutoSize(false);
                            $event->sheet->getColumnDimension($column)->setWidth(15);
                            $event->sheet
                                ->getDelegate()
                                ->getStyle($column)
                                ->getAlignment()
                                ->setWrapText(true);
                        }

                        $Count = DB::table('attendance_daily_count')
                            ->where('business_id', $this->BID)
                            ->where('date', date('Y-m-d', strtotime($this->year . '-' . $this->month . '-' . $this->day)))
                            ->first();
                        $present = $Count->present;
                        $event->sheet->getDelegate()->mergeCells('A' . $this->DataLength + 1 . ':N' . $this->DataLength + 1);
                        $event->sheet->getDelegate()->setCellValue('A' . $this->DataLength + 1, ' Present-' . $present . ',  Absent-' . $Count->absent . ',  Halfday-' . $Count->halfday . ', Mispunch-' . $Count->mispunch . ',  Late-' . $Count->late . ',  Early-' . $Count->early . ',  Leave-' . $Count->leave . ',');
                        $event->sheet
                            ->getStyle('A' . $this->DataLength + 1)
                            ->getFont()
                            ->setBold(true);

                        $event->sheet->getDelegate()->mergeCells('A' . $this->DataLength + 3 . ':N' . $this->DataLength + 3);
                        $event->sheet->getDelegate()->setCellValue('A' . $this->DataLength + 3, 'Exported By: ' . Session::get('login_name') . ' At: ' . now());
                    } elseif ($this->export_type == 11) {
                        $event->sheet->getDelegate()->mergeCells('A7:C7');
                        $event->sheet->getDelegate()->setCellValue('A7', 'Action Details');
                        $event->sheet->getDelegate()->mergeCells('D7:F7');
                        $event->sheet->getDelegate()->setCellValue('D7', 'Shift Details');

                        $event->sheet->getDelegate()->mergeCells('G7:N7');
                        $event->sheet->getDelegate()->setCellValue('G7', 'Attendance Details');

                        $boldStyle = $event->sheet->getDelegate()->getStyle('A7:N7');
                        $boldStyle->getFont()->setBold(true);

                        $event->sheet->getDelegate()->mergeCells('J2:L2');
                        $event->sheet->getDelegate()->setCellValue('J2', 'Name: ' . $this->Emp->emp_name . ' ' . $this->Emp->emp_mname);
                        $event->sheet->getDelegate()->mergeCells('J3:L3');
                        $event->sheet->getDelegate()->setCellValue('J3', 'Employee ID: ' . $this->Emp->emp_id);
                        $event->sheet->getDelegate()->mergeCells('J4:L4');

                        $boldStyle1 = $event->sheet->getDelegate()->getStyle('J2:L2');
                        $boldStyle1->getFont()->setBold(true);

                        $boldStyle2 = $event->sheet->getDelegate()->getStyle('J3:L3');
                        $boldStyle2->getFont()->setBold(true);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A7:N7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $event->sheet->getColumnDimension('A')->setAutoSize(false);
                        $event->sheet->getColumnDimension('A')->setWidth(5);
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setWrapText(true);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:A' . $this->DataLength + 1)
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $event->sheet->getDelegate()->setCellValue('D4', 'For the Date of  ' . date('d-M-Y') . ' ' . date('l'));

                        $event->sheet->getDelegate()->setCellValue('C3', 'Employee Monthly Attendance Report');
                        $event->sheet->getDelegate()->freezePane('A9');
                        $event->sheet->getDelegate()->setAutoFilter('A8:N8');

                        $boldStyle = $event->sheet->getDelegate()->getStyle('A8:N8');
                        $boldStyle->getFont()->setBold(true);

                        $boldBorderStyle = $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:N' . $this->DataLength + 1)
                            ->getBorders();
                        $boldBorderStyle->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                        $boldBorderStyle = $event->sheet
                            ->getDelegate()
                            ->getStyle('A7:N7')
                            ->getBorders();
                        $boldBorderStyle->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:N' . $this->DataLength)
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $columns = ['E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];

                        foreach ($columns as $column) {
                            $event->sheet->getColumnDimension($column)->setAutoSize(false);
                            $event->sheet->getColumnDimension($column)->setWidth(15);
                            $event->sheet
                                ->getDelegate()
                                ->getStyle($column)
                                ->getAlignment()
                                ->setWrapText(true);
                        }

                        $tatalCalculationDsata = $this->calculation();

                        $event->sheet->getDelegate()->mergeCells('A' . ($this->DataLength + 1) . ':N' . ($this->DataLength + 1));
                        $event->sheet->getDelegate()->setCellValue('A' . ($this->DataLength + 1), $tatalCalculationDsata);

                        $boldStyle = $event->sheet->getDelegate()->getStyle('A' . ($this->DataLength + 1) . ':N' . ($this->DataLength + 1));
                        $boldStyle->getFont()->setBold(true);
                        $boldStyle
                            ->getFont()
                            ->setBold(true)
                            ->setSize(10);
                        // dd($func);
                    } elseif ($this->export_type == 12) {
                        $event->sheet->getDelegate()->mergeCells('J2:L2');
                        $event->sheet->getDelegate()->setCellValue('J2', 'Name: ' . $this->Emp->emp_name . ' ' . $this->Emp->emp_mname);
                        $event->sheet->getDelegate()->mergeCells('J3:L3');
                        $event->sheet->getDelegate()->setCellValue('J3', 'Employee ID: ' . $this->Emp->emp_id);
                        $event->sheet->getDelegate()->mergeCells('J4:L4');

                        $boldStyle1 = $event->sheet->getDelegate()->getStyle('J2:L2');
                        $boldStyle1->getFont()->setBold(true);

                        $boldStyle2 = $event->sheet->getDelegate()->getStyle('J3:L3');
                        $boldStyle2->getFont()->setBold(true);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A7:N7')
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $event->sheet->getColumnDimension('A')->setAutoSize(false);
                        $event->sheet->getColumnDimension('A')->setWidth(5);
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setWrapText(true);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:A' . $this->DataLength + 1)
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $event->sheet->getDelegate()->setCellValue('D4', 'For the Date of  ' . date('d-M-Y') . ' ' . date('l'));

                        $event->sheet->getDelegate()->setCellValue('C3', 'Employee Monthly Attendance Regularization Report');
                        $event->sheet->getDelegate()->freezePane('A9');
                        $event->sheet->getDelegate()->setAutoFilter('A8:O8');

                        $boldStyle = $event->sheet->getDelegate()->getStyle('A8:O8');
                        $boldStyle->getFont()->setBold(true);

                        $boldBorderStyle = $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:O' . $this->logLength + 8)
                            ->getBorders();
                        $boldBorderStyle->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                        $event->sheet
                            ->getDelegate()
                            ->getStyle('A8:O' . $this->logLength)
                            ->getAlignment()
                            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $columns = ['E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];

                        foreach ($columns as $column) {
                            $event->sheet->getColumnDimension($column)->setAutoSize(false);
                            $event->sheet->getColumnDimension($column)->setWidth(15);
                            $event->sheet
                                ->getDelegate()
                                ->getStyle($column)
                                ->getAlignment()
                                ->setWrapText(true);
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Error adding image to Excel sheet: ' . $e->getMessage());
                    \Log::error('Stack trace: ' . $e->getTraceAsString());
                }
            },
        ];
    }

    public function calculation()
    {
        $empAttendance = DB::table('attendance_list');
        $totalHours = 0;
        $totalMinutes = 0;

        $totalOTHours = 0;
        $totalOTMinutes = 0;
        $totalOTTime = 0;

        $totalWorkHour = $empAttendance
            ->where('emp_id', $this->Emp->emp_id)
            ->whereMonth('punch_date', $this->month)
            ->whereYear('punch_date', $this->year)
            ->get();

        foreach ($totalWorkHour as $workHour) {
            [$hours, $minutes, $seconds] = explode(':', $workHour->total_working_hour);
            $totalHours += (int) $hours;
            $totalMinutes += (int) $minutes;

            $totalOTTime += $workHour->overtime;
        }
        $totalHours += intval($totalMinutes / 60);
        $totalMinutes = $totalMinutes % 60;

        // dd($totalOTTime);

        $totalOTHours += intval($totalOTTime / 60);
        $totalOTMinutes = $totalOTTime % 60;

        $counts = DB::table('attendance_monthly_count')
            ->where('emp_id', $this->Emp->emp_id)
            ->where('month', $this->month)
            ->where('year', $this->year)
            ->first();
        $present = $counts->present;
        $halfDay = $counts->half_day;
        $leaves = $counts->leave;
        $holiday = $counts->holiday;
        $weekOff = $counts->week_off;
        $mispunch = $counts->mispunch;

        $stringValue = 'Total Duration: ' . $totalHours . ' hours and ' . $totalMinutes . ' mins , PresentDays = ' . $present . ', HalfDays = ' . $halfDay . ', Leaves = ' . $leaves . ', Week Off = ' . $weekOff . ', Holiday = ' . $holiday . ', Absent + MSP (Deductible) = 0.00, MSP = ' . $mispunch . ', Total OverTime Duration : ' . $totalOTHours . ' hours and ' . $totalOTMinutes . ' mins';

        return $stringValue;
    }

    public function getTimeLog($date)
    {
        $attendance = DB::table('attendance_list')
            ->join('attendance_time_log', 'attendance_list.punch_date', '=', 'attendance_time_log.punch_date')
            ->where('attendance_list.emp_id', $this->Emp->emp_id)
            ->where('attendance_list.business_id', $this->BID)
            ->where('attendance_time_log.punch_date', $date)
            ->latest('attendance_time_log.created_at')
            // ->select('attendance_time_log.*')
            ->first();

        return $attendance;
    }
}
