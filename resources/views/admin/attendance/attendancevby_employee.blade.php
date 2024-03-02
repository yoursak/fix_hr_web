@extends('admin.pagelayout.master')

@section('title')
    Monthly Attendance Detail
@endsection
@section('css')
    <style>
        *,
        *::after,
        *::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        time {
            line-height: 1;
        }

        .timeline {
            padding: 3rem 2rem;
            max-width: 460px;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 4px 25px -20px rgba(0, 0, 0.2);
        }

        .tl-content .tl-header,
        .tl-content .tl-body {
            padding-left: 25.6px;
            border-left: 3px solid gainsboro;
        }

        .tl-body {
            padding-bottom: 10px;
        }

        .tl-content:last-child .tl-body {
            border-left: 3px solid transparent;
        }

        .tl-header {
            position: relative;
            display: grid;
            padding-bottom: 5px;
        }

        .tl-title {
            font-weight: 650;
            font-size: 12px;
        }

        .tl-time {
            font-size: 5px;
        }

        .tl-marker {
            display: block;
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50% / 50%;
            background: gainsboro;
            left: -1.1rem;
            transform: translate(50%, -50%);
        }

        .tl-content-active .tl-marker {
            padding: 1.6px;
            margin-top: 10px;
            left: -1.25rem;
            width: 18px;
            border: 2px solid #8c8c96;
            background-color: #8c8c96;
            background-clip: content-box;
            box-shadow: 0 0 15px -2px #8c8c96;
        }

        tr {
            line-height: 1.5;
        }
    </style>
@endsection

@section('js')
    <!-- CIRCLE-PROGRESS JS -->

    <script src="{{ asset('assets/js/hr/hr-attlist.js') }}"></script>

    <!-- INTERNAL INDEX JS -->
@endsection
@if (in_array('Attendance Summary.All', $permissions) || in_array('Attendance Summary.View', $permissions))
    @section('content')
        {{-- @php
            $root = new App\Helpers\Central_unit();
            $ruleManagement = new App\Helpers\MasterRulesManagement\RulesManagement();
            $byAttendanceCalculation = $root->attendanceByEmpDetails($emp->emp_id, date('Y'), date('m'));
            $monthlyCount = $root->getMonthlyCountFromDB($emp->emp_id, date('Y'), date('m'), Session::get('business_id'), $emp->branch_id);
            // $allStatusCount = $root->attendanceCount($emp->emp_id, date('Y'), date('m'));
            $getLeave = $root->getAttendanceSummaryDetaisl(['emp_id' => $emp->emp_id, 'punch_date' => date('Y-m-d')]);
            // dd($emp->branch_id);
            $root->MyCountForMonth($emp->emp_id, date('2024-01-01'), Session::get('business_id'), $emp->branch_id);
        @endphp --}}

        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li><a href="{{ url('/admin/attendance/month-summary') }}">Attendance Summary</a></li>
                <li class="active"><span><b>Attendance By</b></span></li>
            </ol>
        </div>

        <livewire:attendance.attendance-by-employee-livewire :empID="$emp->emp_id">

            <script>
                function checkInputNotEmpty() {
                    var inTime = document.getElementById('punchInTime');
                    var OutTime = document.getElementById('punchOutTime');
                    var inVal = inTime.value.trim();
                    var outVal = OutTime.value.trim();
                    console.log(inVal, outVal);
                    if (outVal === '' || outVal === '--' || outVal === '' || outVal === '--') {
                        alert('Input field cannot be empty!');
                        return false;
                    }
                    return true;
                }
                document.querySelector('#CorrectionSubmit').addEventListener('click', function(event) {
                    if (!checkInputNotEmpty()) {
                        event.preventDefault();
                    }
                });
            </script>
            <script>
                function correctionModalJs(e) {
                    var Name = $(e).data('name');
                    var EmpId = $(e).data('empid');
                    var inTime = $(e).data('in');
                    var outTime = $(e).data('out');
                    var shiftName = $(e).data('shiftname');
                    var shiftStart = $(e).data('shiftstart');
                    var shiftEnd = $(e).data('shiftend');
                    var punchDate = $(e).data('punchdate');



                    $('#correctAttendance').modal('show');
                    $('#correctionEmpID').html(EmpId);
                    $('#correctionEmpName').html(Name);
                    $('#correctionDate').html(punchDate);
                    $('#shiftName').html(shiftName);
                    $('#ShiftStart').html(shiftStart);
                    $('#ShiftEnd').html(shiftEnd);
                    $('#punchInTime').val(inTime);
                    $('#punchOutTime').val(outTime);

                    $('#inTime').val(inTime);
                    $('#outTime').val(outTime);
                    $('#empID').val(EmpId);
                    $('#punchDate').val(punchDate);
                }
            </script>

            <div class="modal fade" id="PunchIn">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content tx-size-sm">
                        <img id="inSelfie" src="" alt="">
                    </div>
                </div>
            </div>
            <div class="modal fade" id="PunchOut">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content tx-size-sm">
                        <img id="outSelfie" src="" alt="">
                    </div>
                </div>
            </div>
        @endsection
@endif
