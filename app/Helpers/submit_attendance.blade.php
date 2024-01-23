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
@section('content')
    @php
        $root = new App\Helpers\Central_unit();
        $Department = $root->DepartmentList();
        $Branch = $root->BranchList();
        $root = new App\Helpers\Central_unit();
        $Employee = $root->EmployeeDetails();
        $EmpID = $root->EmpPlaceHolder();
        $Designation = $root->DesignationList();
        $LOADED = new App\Helpers\MasterRulesManagement\RulesManagement();
        $ITEM = $LOADED->SectionEmployeeCounters();
        
        // dd($Employee);
    @endphp
    <div class=" p-0 py-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li class="active"><span><b>Submit Attendance</b></span></li>
        </ol>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Submit Attendance
                    </div>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="row">
                                <div class="col-6 d-flex" id="addSubmitBtn">
                                    <button id="addAttendanceBtn" class="btn btn-md btn-primary" data-effect="effect-scale"
                                        data-bs-toggle="modal" href="#selectdate">Add Attendance</button>
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
                    <div class="table-responsive hr-attlist">
                        <div id="hr-attendance_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap border border-bottom">
                                            <thead>
                                                <tr role="row" class="border-bottom">
                                                    <th class="border-bottom-0 ">S.No.</th>
                                                    <th class="border-bottom-0 ">Month</th>
                                                    <th class="border-bottom-0 ">Created Date</th>
                                                    <th class=" text-center border-bottom-0 ">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($submittedData as $key => $item)
                                                    <tr class="border-bottom">
                                                        <td>{{ ++$key }}.</td>
                                                        <td>{{ date('M', strtotime('2023-' . $item->month . '-01')) . '-' . date('Y', strtotime($item->year)) }}
                                                        </td>
                                                        <td>{{ date('d-m-Y', strtotime($item->created)) }}</td>
                                                        <td class="text-center">
                                                            <button class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                                                data-bs-toggle="tooltip" data-original-title="View" {{ $item->submited == 1 ? 'disabled' : '' }}>
                                                                <a href="{{route('submitAttendancePage',[date('Y-m-d',strtotime($item->year.'-'.$item->month.'-01'))])}}"
                                                                    class="<?= $item->submited == 1 ? 'text-muted' : '' ?>"
                                                                    onclick="" id="monthEvaluateBtn"
                                                                    data-month="{{ $item->month }}"
                                                                    data-year="{{ $item->year }}" {{ $item->submited == 1 ? 'disabled' : '' }}>
                                                                    <i class="feather feather-edit"></i>
                                                                </a>
                                                            </button>
                                                            <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                                                data-bs-toggle="tooltip" data-original-title="View">
                                                                <a href="" onclick="">
                                                                    <i class="feather feather-printer"></i>
                                                                </a>
                                                            </div>
                                                            <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                                                data-bs-toggle="tooltip" data-original-title="View">
                                                                <a href="">
                                                                    <i class="feather feather-download"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <script>
                                            function openSubmitModal(e) {
                                                // alert('clickerd');
                                                $('#finalSubmitAttendance').modal('show');
                                            }

                                            function createSubmitBTN() {
                                                var appendBtnDiv = document.getElementById('addSubmitBtn');

                                                document.getElementById('addAttendanceBtn').classList.add('d-none');


                                                // Create a button element
                                                var newButton = document.createElement('button');
                                                newButton.className = 'btn btn-md btn-primary';
                                                newButton.setAttribute('data-effect', 'effect-scale');
                                                newButton.setAttribute('data-bs-toggle', 'modal');
                                                newButton.setAttribute('onclick', 'openSubmitModal(this)');
                                                newButton.setAttribute('id', 'finalSubmitBtn');
                                                newButton.href = '#finalSubmitAttendance';
                                                newButton.textContent = 'Submit Now';

                                                // Append the button to the div
                                                appendBtnDiv.appendChild(newButton);

                                            }

                                            function getSubmitData(e) {
                                                var month = e.getAttribute('data-month');
                                                var year = e.getAttribute('data-year');
                                                var table = document.getElementById('evaluationtable');
                                                var evaluateDetails = document.getElementById('evaluationDetails');

                                                createSubmitBTN();
                                                document.getElementById('monthInputHidden').value = month;
                                                document.getElementById('yearInputHidden').value = year;

                                                $.ajax({
                                                    type: "Post",
                                                    url: "{{ route('getAttendanceData') }}",
                                                    data: {
                                                        month: month,
                                                        year: year,
                                                        _token: '{{ csrf_token() }}'
                                                    },
                                                    dataType: "json",
                                                    success: function(response) {
                                                        // console.log(response);
                                                        var NoOfDay = response[0];
                                                        var result = response[1];
                                                        var strMonth = response[2];



                                                        table.innerHTML = '';
                                                        var headerRow = table.insertRow(0);
                                                        headerRow.classList.add("border-bottom");

                                                        var dayCell = headerRow.insertCell(0);
                                                        dayCell.innerHTML = "<b>Employee Details (" + strMonth + "-" + year + ")</b>";
                                                        // Add cells for days
                                                        for (let index = 1; index <= NoOfDay; index++) {
                                                            var dayCell = headerRow.insertCell(index);
                                                            dayCell.innerHTML = '<b>' + index + '</b>';
                                                        }

                                                        // Add fixed cells
                                                        var fixedHeaders = ['<b>Present</b>', '<b>Absent</b>', '<b>Halfday</b>', '<b>Leave</b>',
                                                            '<b>Mispunch</b>', '<b>Overtime</b>', '<b>Total</b>'
                                                        ];
                                                        fixedHeaders.forEach((headerText, index) => {
                                                            var cell = headerRow.insertCell(index + NoOfDay + 1);
                                                            
                                                            cell.innerHTML = headerText;
                                                        });

                                                        result.forEach((element) => {
                                                            var valueRow = table.insertRow(1);
                                                            valueRow.classList.add("border");
                                                            var nameCell = valueRow.insertCell(0);


                                                            nameCell.innerHTML = `<div class="d-flex">
                                                                    <span class="avatar avatar-md brround me-3 rounded-circle" style="background-image: url('/employee_profile/` + element.imgURL + `')"></span>
                                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                                        <h6 class="mb-1 fs-14">` + element.name + '(' + element.empId + ')' + ` </h6>
                                                                            <p class="text-muted mb-0 fs-12">` + element.designation + `</p>
                                                                            </div>
                                                                            </div>`;

                                                            for (let index = 1; index <= NoOfDay; index++) {
                                                                var statusCell = valueRow.insertCell(index);
                                                                statusCell.innerHTML = element.status[index];

                                                                var statusValue = element.status[index];


                                                                var dropdownHTML = '<select id="statusDropdown'+ index +'" name="'+element.empId +index +'"  style="border:solid 1px ' + ((statusValue == 2 || statusValue == 3 || statusValue == 4 || statusValue == 12) ? 'red;' : '#1877f2; color:#1877f2') + '" data-empid="' + element.empId + '" data-day="' + index + '" data-month="' + month + '" data-year="' + year + '" onchange="evaluateNow(this)" ' + ((statusValue == 2 || statusValue == 3 || statusValue == 4 || statusValue == 12) ? '' : 'disabled') + '>';

                                                                dropdownHTML += '<option value="1" ' + (statusValue == 1 || statusValue ==
                                                                        3 || statusValue == 9 || statusValue == 12 ? 'selected' : '') +
                                                                    '>P</option>';
                                                                dropdownHTML += '<option value="2" ' + (statusValue == 2 ? 'selected' :
                                                                    'hidden') + '>A</option>';
                                                                dropdownHTML += '<option value="8" ' + (statusValue == 8 ? 'selected' :
                                                                    '') + '>HD</option>';
                                                                dropdownHTML += '<option value="7" ' + (statusValue == 7 ? 'selected' :
                                                                    'hidden') + '>WO</option>';
                                                                dropdownHTML += '<option value="6" ' + (statusValue == 6 ? 'selected' :
                                                                    'hidden') + '>HO</option>';
                                                                dropdownHTML += '<option value="11" ' + (statusValue == 11 || statusValue ==
                                                                    10 ? 'selected' : 'hidden') + '>L</option>';
                                                                dropdownHTML += '<option value="4" ' + (statusValue == 4 ? 'selected' :
                                                                    'hidden') + '>MSP</option>';
                                                                dropdownHTML += '</select>';
                                                                statusCell.innerHTML = dropdownHTML;

                                                            }


                                                            // console.log(element.count['present']);
                                                            var countCell1 = valueRow.insertCell(NoOfDay + 1);
                                                            countCell1.setAttribute('id',element.empId+'P');
                                                            countCell1.innerHTML = element.count['present'];

                                                            var countCell2 = valueRow.insertCell(NoOfDay + 2);
                                                            countCell2.setAttribute('id',element.empId+'A');
                                                            countCell2.innerHTML = element.count['absent'];

                                                            var countCell3 = valueRow.insertCell(NoOfDay + 3);
                                                            countCell3.setAttribute('id',element.empId+'HD');
                                                            countCell3.innerHTML = element.count['halfday'];

                                                            var countCell4 = valueRow.insertCell(NoOfDay + 4);
                                                            countCell4.setAttribute('id',element.empId+'L');
                                                            countCell4.innerHTML = element.count['leave'];

                                                            var countCell5 = valueRow.insertCell(NoOfDay + 5);
                                                            countCell5.setAttribute('id',element.empId+'MSP');
                                                            countCell5.innerHTML = element.count['mispunch'];

                                                            var countCell6 = valueRow.insertCell(NoOfDay + 6);
                                                            countCell6.setAttribute('id',element.empId+'OT');
                                                            countCell6.innerHTML = element.count['overtime'];

                                                            var countCell7 = valueRow.insertCell(NoOfDay + 7);
                                                            countCell7.setAttribute('id',element.empId+'T');
                                                            countCell7.innerHTML = element.count['total'];
                                                        });
                                                    }
                                                });
                                            }

                                            function evaluateNow(e) {

                                                var EmpID = $(e).data('empid');
                                                var day = $(e).data('day');
                                                var month = $(e).data('month');
                                                var year = $(e).data('year');
                                                var value = e.value;
                                                // finallySubmitAttendance
                                                $.ajax({
                                                    type: "Post",
                                                    url: "{{ route('onStatusChangeCalculate') }}",
                                                    data: {
                                                        day: day,
                                                        month: month,
                                                        year: year,
                                                        emp: EmpID,
                                                        value: value,
                                                        _token: '{{ csrf_token() }}'
                                                    },
                                                    dataType: "json",
                                                    success: function(response) {
                                                        updateTableCount(response)
                                                    }
                                                });

                                            }

                                            function updateTableCount(e){
                                                console.log(e);
                                                $('#'+e.emp_id+'P').html(e.present);
                                                $('#'+e.emp_id+'A').html(e.absent);
                                                $('#'+e.emp_id+'HD').html(e.half_day);
                                                $('#'+e.emp_id+'L').html(e.leave);
                                                $('#'+e.emp_id+'MSP').html(e.mispunch);
                                                $('#'+e.emp_id+'OT').html(e.overtime);
                                                $('#'+e.emp_id+'T').html(parseInt(e.present)+parseInt(e.half_day)/2);
                                            } 
                                        </script>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

    <div class="modal fade" id="finalSubmitAttendance" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Final Submit Attendance</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('finallySubmitAttendance') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h6>Are you sure want to Submit Attendance Permanently</h6>
                    </div>
                    <input type="text" id="yearInputHidden" name="year" hidden>
                    <input type="text" id="monthInputHidden" name="month" hidden>
                    {{-- <input type="text" id="businessInputHidden" name="businessId" hidden> --}}
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="selectdate" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Select Monthly Attendance</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('createSubmitAttendance') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h6>Choose the month which you want to evaluate and submit attendance</h6>
                        <div class="row text-start">
                            {{-- <div class="col-md-12">
                            <div class="form-group">
                                <p class="form-label">Branch</p>
                                <select name='branch_id' id="country-dd" class="form-control"
                                    data-nodays='{{ date('t') }}' data-modays='{{ date('d') }}'
                                    data-currentMonth='{{ date('m') }}' data-currentYear='{{ date('Y') }}'>
                                    <option value="">All Branches</option>
                                    @foreach ($Branch as $data)
                                        <option value="{{ $data->branch_id }}">
                                            {{ $data->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <p class="form-label">Year</p>
                                    <div class="form-group mb-3">
                                        <select name="year" id="yearFilter" class="form-control " required>
                                            <option value="">Select Year</option>
                                            @for ($year = date('Y'); $year >= date('Y') - 20; $year--)
                                                <option value="{{ $year }}"
                                                    {{ $year == date('Y') ? 'Selected' : '' }}>
                                                    {{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <p class="form-label">Month</p>
                                    <div class="form-group mb-3">
                                        <select name="month" id="monthFilter" class="form-control " required>
                                            <option value="">Select Month</option>
                                            @for ($month = 1; $month <= 12; $month++)
                                                <option value="{{ $month }}"
                                                    {{ $month == date('m') ? 'Selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="presentModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Details</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card-header border-bottom-0">
                                <h4 class="">Timesheet<span
                                        class="fs-14 mx-3 text-muted">{{ date('d-M-y h:i a') }}</span></h4>
                            </div>

                            <div class="col-sm-12 my-auto" style="height: 260px">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="pt-5 text-center">
                                            <h6 class="mb-1 fs-16 font-weight-semibold" id="modalPunchIn">12:00</h6>
                                            <small class="text-muted fs-14">Punch In</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="chart-circle chart-circle-md" data-value="100" data-thickness="8"
                                            data-color="#0dcd94">
                                            <div class="chart-circle-value text-muted" id="modalWorkingHr">09:05 hrs
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="pt-5 text-center">
                                            <h6 class="mb-1 fs-16 font-weight-semibold" id="modalPunchOut">12:00</h6>
                                            <small class="text-muted fs-14">Punch Out</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-5">
                                    <div class="row">
                                        <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                            <small class="text-muted fs-13">Break Time</small>
                                            <p class="mb-1 fs-14 font-weight-semibold" id="modalBreakTime">09:30 AM
                                            </p>
                                        </div>
                                        <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                            <small class="text-muted fs-13">Overtime</small>
                                            <p class="mb-1 fs-14 font-weight-semibold" id="modalOverTime">09:30 AM</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-6">

                            <div class="col-sm-12">
                                <div class="">
                                    <h4 class="my-5">Timeline</h4>
                                </div>
                                <div class="col-sm-12 mt-5">
                                    <div class="tl-content tl-content-active">

                                        <div class="tl-header d-none" id="timeline1">
                                            <span class="tl-marker"></span>
                                            <div class="row">
                                                <div class="col-10">
                                                    <p class="tl-title">Punch In at <span id="puchInAt"></span> |
                                                        <span class="shiftName"></span><br><span
                                                            class="text-muted fs-12"><i
                                                                class="fa fa-map-marker mx-1"></i><span
                                                                id="inLocation"></span></span>
                                                    <p>
                                                </div>
                                                <div class="col-2">
                                                    <a id="showInSelfie" onclick="showSelfie(this)" data-imgin=''
                                                        class="my-auto">
                                                        <span id="showInSelfieBg" class="avatar avatar-sm brround"
                                                            style="background-image: url(assets/images/users/1.jpg)"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tl-header d-none" id="timeline2">
                                            <span class="tl-marker"></span>
                                            <div class="row">
                                                <div class="col-10">
                                                    <p class="tl-title">Punch Out at <span id="punchOutAt"></span>
                                                        |<span class="shiftName"></span> <br><span
                                                            class="text-muted fs-12"><i
                                                                class="fa fa-map-marker mx-1"></i><span
                                                                id="punchOutLocation"></span></span>
                                                    <p>
                                                </div>
                                                <div class="col-2">
                                                    <a id="showOutSelfie" onclick="showSelfie(this)" data-imgout=''
                                                        class="my-auto">
                                                        <span id="showOutSelfieBg" class="avatar avatar-sm brround"
                                                            style="background-image: url(assets/images/users/1.jpg)"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-outline-primary" data-bs-dismiss="modal">close</a>
                    {{-- <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editmodal" data-bs-dismiss="modal">Edit</a> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="PunchIn">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header">
                    <h5 class="modal-title">PunchIn Selfie</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="inselfieID" src="" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="PunchOut">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header">
                    <h5 class="modal-title">PunchOut Selfie</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="outselfieID" src="" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function showPresentModal(context) {
            $('#presentModal').modal('show');
            var inTime = $(context).data('in');
            var outTime = $(context).data('out');
            var twh = $(context).data('twh');
            var inLoc = $(context).data('inloc');
            var outLoc = $(context).data('outloc');
            var breakMin = $(context).data('breakmin');
            var shiftName = $(context).data('shiftname');
            var overTime = $(context).data('overtime');
            var inSelfie = $(context).data('inselfie');
            var outSelfie = $(context).data('outselfie');



            if (inTime != '00:00') {
                $('#timeline1').removeClass('d-none');
            }
            if (outTime != '00:00') {
                $('#timeline2').removeClass('d-none');
            }

            $('#modalPunchIn').html(inTime);
            $('#puchInAt').html(inTime);
            $('#modalPunchOut').html(outTime);
            $('#punchOutAt').html(outTime);
            $('#modalWorkingHr').html(twh);
            $('#inLocation').html(inLoc);
            $('#punchOutLocation').html(outLoc);
            $('#modalBreakTime').html(breakMin);
            $('#modalOverTime').html(overTime);
            $('.shiftName').html(shiftName);
            $("#showInSelfie").attr("data-imgin", inSelfie);
            $("#showOutSelfie").attr("data-imgout", outSelfie);
            $("#showInSelfieBg").css("background-image", "url('/upload_image/" + inSelfie + "')");
            $("#showOutSelfieBg").css("background-image", "url('/upload_image/" + outSelfie + "')");

        }

        function showSelfie(context) {
            if (context.id === 'showInSelfie') {
                var inSelfie = context.getAttribute('data-imgin');
                var inSelfieURL = "{{ asset('/upload_image/') }}" + "/" + inSelfie;
                console.log(inSelfieURL);
                $('#PunchIn').modal('show');
                $("#inselfieID").attr("src", inSelfieURL);
            }

            if (context.id === 'showOutSelfie') {
                var outSelfie = context.getAttribute('data-imgout');
                var outSelfieURL = "{{ asset('/upload_image/') }}" + "/" + outSelfie;
                $('#PunchOut').modal('show');
                $("#outselfieID").attr("src", outSelfieURL);
            }

        }
    </script>
@endsection
