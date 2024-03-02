@extends('admin.pagelayout.master')
@section('title', 'Submit-Attendance')
@section('css')
    <style>
        .table-container {
            overflow-x: auto;
        }

        .table thead th:first-child,
        .table tbody td:first-child {
            position: -webkit-sticky;
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 2;
        }

        .table thead th {
            z-index: 1;
        }
    </style>
@endsection
@if (in_array('Submit Attendance.Update', $permissions))
    @section('content')
        @php
            $EmployeeDate;
            $NofDay;
            $root = new App\Helpers\Central_unit();
            $Department = $root->DepartmentList();
            $Branch = $root->BranchList();
            $Employee = $root->EmployeeDetails();
            $EmpID = $root->EmpPlaceHolder();
            $Designation = $root->DesignationList();
            $LOADED = new App\Helpers\MasterRulesManagement\RulesManagement();
            $ITEM = $LOADED->SectionEmployeeCounters();
        @endphp
        <div class=" p-0 py-2">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                <li class="active"><span><b>Submit Attendance Preview</b></span></li>
            </ol>
        </div>
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Submit Attendance Preview {{ $MonthName . ' - ' . $year }}
                        </div>
                        <div class="page-rightheader ms-auto">
                            <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                <div class="row">
                                    <div class="col-6 d-flex" id="addSubmitBtn">
                                        <button id="addAttendanceBtn" class="btn btn-md btn-primary"
                                            data-effect="effect-scale" data-bs-toggle="modal" href="#finalSubmitAttendance"
                                            {{ empty($EmployeeDate) ? 'disabled' : '' }}>Submit Attendance</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive hr-attlist">
                            <div id="hr-attendance_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="" id="evaluationDetails">
                                            {{-- <h5>Submit Attendance of {{$MonthName.' - '.$year}}</h5> --}}
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table text-nowrap border border-bottom" id="evaluationtable">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('finallySubmitAttendance') }}" method="POST">
                            @csrf
                            <div class="table-responsive hr-attlist">
                                <div id="hr-attendance_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-vcenter text-nowrap border-bottom">
                                                    <thead> 
                                                        <tr role="row">
                                                            <th class="border-bottom-0 reorder sorting sorting_asc"
                                                                tabindex="0" aria-controls="hr-attendance" rowspan="1"
                                                                colspan="1" aria-sort="ascending"
                                                                aria-label="Employee Name: activate to sort column descending"
                                                                style="width: 165.031px;">Employee Name</th>
                                                            <?php $day = 0; ?>
                                                            @while (++$day <= $NofDay)
                                                                <th class="border-bottom-0 w-5 sorting_disabled text-center"
                                                                    rowspan="1" colspan="1" aria-label="1"
                                                                    style="width: 14.5px;">
                                                                    {{ $day }}</th>
                                                            @endwhile
                                                            <th class="text-center border-bottom-0 ">P</th>
                                                            <th class="text-center border-bottom-0 ">A</th>
                                                            <th class="text-center border-bottom-0 ">LT</th>
                                                            <th class="text-center border-bottom-0 ">EE</th>
                                                            <th class="text-center border-bottom-0 ">MSP</th>
                                                            <th class="text-center border-bottom-0 ">HO</th>
                                                            <th class="text-center border-bottom-0 ">WO</th>
                                                            <th class="text-center border-bottom-0 ">HD</th>
                                                            <th class="text-center border-bottom-0 ">OT</th>
                                                            <th class="text-center border-bottom-0 ">L</th>
                                                            <th class="text-center border-bottom-0 ">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="resBody" class="my_body">
                                                        @if (empty($EmployeeDate))
                                                            <tr class="text-center">
                                                                <td colspan="30" class="text-center">No data available in
                                                                    table</td>
                                                            </tr>
                                                        @else
                                                            @foreach ($EmployeeDate as $key => $emp)
                                                                <tr class="odd border border-bottum">
                                                                    <td class="reorder sorting_01">
                                                                        <div class="d-flex">
                                                                            <span
                                                                                class="avatar avatar-md brround me-3 rounded-circle"
                                                                                style="background-image: url('/employee_profile/{{ $emp['imgURL'] }}')"></span>
                                                                            <div class="me-3 mt-0 mt-sm-2 d-block">
                                                                                <h6 class="mb-1 fs-14">
                                                                                    <a
                                                                                        href="{{ route('employeeProfile', [$emp['empId']]) }}">
                                                                                        {{ $emp['name'] }}{{ '(' . $emp['empId'] . ')' }}
                                                                                    </a>
                                                                                </h6>
                                                                                <p class="text-muted mb-0 fs-12">
                                                                                    {{ $emp['designation'] }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    @php
                                                                        $present = 0;
                                                                        $absent = 0;
                                                                        $halfday = 0;
                                                                        $mispunch = 0;
                                                                        $weekoff = 0;
                                                                        $holiday = 0;
                                                                        $overtime = 0;
                                                                        $leave = 0;
                                                                    @endphp
                                                                    @foreach ($emp['status'] as $key => $status)
                                                                        @php
                                                                            // $root->MyCountForMonth($emp['empId'], date('Y-m-d', strtotime($emp['year'] . '-' . $emp['month'] . '-' . $key)), Session::get('business_id'),$emp['branch_id']);
                                                                            // $root->MyCountForDaily(date('Y-m-d', strtotime($emp['year'] . '-' . $emp['month'] . '-' . $key)), Session::get('business_id'),$emp['branch_id'], Session::get('login_role'), Session::get('login_emp_id'));
                                                                        @endphp
                                                                        <td>
                                                                            <span>
                                                                                <small class="badge badge-info-light"
                                                                                    data-bs-trigger="hover"
                                                                                    style="background-color:transparent;"
                                                                                    data-bs-container="body"
                                                                                    data-bs-content="{{ date('d-m-Y', strtotime($key . '-' . $emp['month'] . '-' . $emp['year'])) }}"
                                                                                    data-bs-placement="right"
                                                                                    data-bs-popover-color="primary"
                                                                                    data-bs-toggle="popover"
                                                                                    data-bs-html="true"
                                                                                    title="{{ $status == 1 || $status == 3 || $status == 9 || $status == 12 ? 'Present' : ($status == 4 ? 'Mispunch' : ($status == 6 ? 'Holiday' : ($status == 7 ? 'WeekOff' : ($status == 8 ? 'Halfday' : ($status == 10 ? 'Leave' : 'Absent'))))) }}"
                                                                                    data-bs-original-title="Data">
                                                                                    <span
                                                                                        class="fs-14 text-dark btn">{{ $status == 1 || $status == 3 || $status == 9 || $status == 12 ? 'P' : ($status == 4 ? 'MSP' : ($status == 6 ? 'HO' : ($status == 7 ? 'WO' : ($status == 8 ? 'HD' : ($status == 10 ? 'L' : 'A'))))) }}</span>
                                                                                </small>
                                                                            </span>

                                                                        </td>
                                                                    @endforeach

                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['present']">
                                                                        <input type="text" id="{{ $emp['empId'] }}P"
                                                                            name="{{ $emp['empId'] }}[present]"
                                                                            value="{{ $emp['count']['present'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>

                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['absent']">
                                                                        <input type="text" id="{{ $emp['empId'] }}A"
                                                                            name="{{ $emp['empId'] }}[absent]"
                                                                            value="{{ $emp['count']['absent'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>
                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['late']">
                                                                        <input type="text" id="{{ $emp['empId'] }}A"
                                                                            name="{{ $emp['empId'] }}[late]"
                                                                            value="{{ $emp['count']['late'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>
                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['early']">
                                                                        <input type="text" id="{{ $emp['empId'] }}A"
                                                                            name="{{ $emp['empId'] }}[early]"
                                                                            value="{{ $emp['count']['early'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>

                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['mispunch']">
                                                                        <input type="text" id="{{ $emp['empId'] }}MSP"
                                                                            name="{{ $emp['empId'] }}[mispunch]"
                                                                            value="{{ $emp['count']['mispunch'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>
                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['holiday']">
                                                                        <input type="text" id="{{ $emp['empId'] }}HO"
                                                                            name="{{ $emp['empId'] }}[holiday]"
                                                                            value="{{ $emp['count']['holiday'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>

                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['weekoff']">
                                                                        <input type="text" id="{{ $emp['empId'] }}WO"
                                                                            name="{{ $emp['empId'] }}[weekoff]"
                                                                            value="{{ $emp['count']['weekoff'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>
                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['halfday']">
                                                                        <input type="text" id="{{ $emp['empId'] }}HD"
                                                                            name="{{ $emp['empId'] }}[halfday]"
                                                                            value="{{ $emp['count']['halfday'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>
                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['overtime']">
                                                                        <input type="text" id="{{ $emp['empId'] }}OT"
                                                                            name="{{ $emp['empId'] }}[overtime]"
                                                                            value="{{ $emp['count']['overtime'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>
                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['leave']">
                                                                        <input type="text" id="{{ $emp['empId'] }}L"
                                                                            name="{{ $emp['empId'] }}[leave]"
                                                                            value="{{ $emp['count']['leave'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>
                                                                    <td class="text-center"
                                                                        id="{{ $emp['empId'] }}['total']">
                                                                        <input type="text" id="{{ $emp['empId'] }}T"
                                                                            name="{{ $emp['empId'] }}[total]"
                                                                            value="{{ $emp['count']['total'] }}"
                                                                            style="border: solid black 1px; width:2vw; text-align:center;border-radius:5px"
                                                                            readonly>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="finalSubmitAttendance" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">Final Submit Attendance</h6><button type="reset"
                                                aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                                    aria-hidden="true">&times;</span></button>
                                        </div>

                                        <div class="modal-body">
                                            <h6>Are you sure want to Submit Attendance Permanently</h6>
                                        </div>
                                        <input type="text" id="yearInputHidden" value="{{ $emp['year'] ?? 'N/A' }}"
                                            name="year" hidden>
                                        <input type="text" id="monthInputHidden" value="{{ $emp['month'] ?? 'N/A' }}"
                                            name="month" hidden>
                                        {{-- <input type="text" id="businessInputHidden" name="businessId" hidden> --}}
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END ROW -->
    @endsection

    @section('js')
        {{-- <script>
        function statusChange(e) {
            var value = e.value;
            var empId = e.getAttribute('data-emp');
            var prevStatus = e.getAttribute('data-status');
            console.log(value, empId, prevStatus);

            var present = document.getElementById(empId + "P").value;
            var absent = document.getElementById(empId + "A").value;
            var mispunch = document.getElementById(empId + "MSP").value;
            var halfday = document.getElementById(empId + "HD").value;
            var leave = document.getElementById(empId + "L").value;
            var overtime = document.getElementById(empId + "OT").value;
            var holiday = document.getElementById(empId + "HO").value;
            var weekoff = document.getElementById(empId + "WO").value;
            var total = document.getElementById(empId + "T").value;
            // console.log(present,absent,mispunch,halfday,leave,overtime,holiday,weekoff,total);

            if (value == 1) {
                if (prevStatus == 2) {
                    absent--;
                    present++;
                }
                if (prevStatus == 8) {
                    halfday--;
                    present++;
                }
                if (prevStatus == 4) {
                    mispunch--;
                    present++;
                }
            }


            if (value == 8) {
                if (prevStatus == 2) {
                    absent--;
                    halfday++;
                }
                if (prevStatus == 1) {
                    halfday++;
                    present--;
                }
                if (prevStatus == 4) {
                    mispunch--;
                    halfday++;
                }
            }

            if (value == 2) {

                if (prevStatus == 8) {
                    absent++;
                    halfday--;
                }
                if (prevStatus == 1) {
                    absent++;
                    present--;
                }
                if (prevStatus == 4) {
                    mispunch--;
                    absent++;
                }
            }


            // console.log(present,absent,mispunch,halfday,leave,overtime,holiday,weekoff,total);
            document.getElementById(empId + "P").value = present;
            document.getElementById(empId + "A").value = absent;
            document.getElementById(empId + "MSP").value = mispunch;
            document.getElementById(empId + "HD").value = halfday;
            document.getElementById(empId + "L").value = leave;
            document.getElementById(empId + "OT").value = overtime;
            document.getElementById(empId + "HO").value = holiday;
            document.getElementById(empId + "WO").value = weekoff;
            document.getElementById(empId + "T").value = parseInt(present) + parseInt(halfday)/2;

            // e.getAttribute('data-status', value);
            e.setAttribute("data-status", value);
        //    var load = $(e).data('status').val();
        //     load = value;
            console.log(e);
        }
    </script> --}}
    @endsection
@endif
