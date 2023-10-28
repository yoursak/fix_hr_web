@extends('admin.pagelayout.master')
@section('title', 'Dashboard')
@section('css')
    <style>
        .pignose-calendar .pignose-calendar-unit a {
            width: 1.5rem;
            height: 1.5rem;
            line-height: 1.5rem;
        }

        .pignose-calendar .pignose-calendar-unit {
            height: 2.3rem;
        }

        .pignose-calendar .pignose-calendar-top {
            padding: 1rem 0 1rem 0;
        }

        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-date {
            top: -6px;
        }

        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-month {
            font-size: 100%;
        }

        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-year {
            font-size: 100%;
        }

        .pignose-calendar .pignose-calendar-header .pignose-calendar-week {
            height: 2em;
            line-height: 2em;
        }
    </style>
@endsection
@section('content')

    <!-- ROW -->
    @php
        $root = new App\Helpers\Central_unit();
        $Count = $root->GetCount();
    @endphp
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employee Summary</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable" class="table text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">S.No</th>
                                    <th class="border-bottom-0">Employee</th>
                                    <th class="text-center border-bottom-0 ">Emp ID</th>
                                    <th class="text-center border-bottom-0 ">Present</th>
                                    <th class="text-center border-bottom-0 ">Absent</th>
                                    <th class="text-center border-bottom-0 ">Half Days</th>
                                    <th class="text-center border-bottom-0 ">Paid Leave</th>
                                    <th class="text-center border-bottom-0 ">Miss Punch</th>
                                    <th class="text-center border-bottom-0 ">Overtime</th>
                                    <th class="text-center border-bottom-0 ">Fine</th>
                                    <th class="text-center border-bottom-0 ">Total Attendance</th>
                                    <th class="text-center border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Emp as $key => $emp)
                                    @php
                                        $resCode = $root->attCall($emp->emp_id);
                                    @endphp

                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md brround me-3 rounded-circle"
                                                    style="background-image: url('/employee_profile/{{ $emp->profile_photo }}')"></span>
                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                    <h6 class="mb-1 fs-14">
                                                        <a href="{{ route('employeeProfile', [$emp->emp_id]) }}">
                                                            {{ $emp->emp_name }}&nbsp;{{ $emp->emp_mname }}&nbsp;{{ $emp->emp_lname }}
                                                        </a>
                                                    </h6>
                                                    <p class="text-muted mb-0 fs-12">
                                                        <?= $root->DesingationIdToName($emp->designation_id) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $emp->emp_id }}</td>
                                        <td class="text-center">
                                            {{ $resCode[1] + $resCode[3] + $resCode[9] + $resCode[8] / 2 }}</td>
                                        <td class="text-center">{{ $resCode[2] }}</td>
                                        <td class="text-center">{{ $resCode[8] }}</td>
                                        <td class="text-center">{{ '0' }}</td>
                                        <td class="text-center">{{ $resCode[9] }}</td>
                                        <td class="text-center">{{ $resCode[3] }}</td>
                                        <td class="text-center">{{ '0' }}</td>
                                        <td class="text-center">{{ $resCode[1] }}</td>
                                        <td class="text-center">
                                            <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                                data-bs-toggle="tooltip" data-original-title="View">
                                                <a href="{{ route('attendance.byemployee', [$emp->emp_id]) }}">
                                                    <i class="feather feather-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->


    
    @endsection

    @section('js')
        <script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js?v=0.1') }}"></script>
        <script src="{{ asset('assets/plugins/vertical-scroll/vertical-scroll.js?v=0.1') }}"></script>

        <!-- INTERNAL PG-CALENDAR-MASTER JS -->
        <script src="{{ asset('assets/plugins/pg-calendar-master/pignose.calendar.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/index2.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

        <script>
            $('#printBtn').on('click', function() {
                var divToPrint = document.getElementById("hr-attendance1");
                newWin = window.open("");
                newWin.document.write(divToPrint.outerHTML);
                newWin.print();
                newWin.close();
            })
        </script>

    @endsection
