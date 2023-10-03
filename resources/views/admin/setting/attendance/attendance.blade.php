{{-- @extends('admin.setting.setting')
@section('subtitle')
Attendance
@endsection
@section('css') --}}
{{-- @extends('admin.setting.setting')
--}}
@extends('admin.pagelayout.master')
@section('title')
    Attendance | Create Shift
@endsection

@section('content')
    <style>
        .nav-link.icon {
            line-height: 0;
        }

        .modal-header,
        .modal-footer {
            background-color: #f8f8ff;
            /* color: #fff; */
        }

        .modal-open {
            overflow: hidden
        }

        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: auto
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: none;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: .5rem;
            pointer-events: none
        }

        .modal.fade .modal-dialog {
            transition: -webkit-transform .3s ease-out;
            transition: transform .3s ease-out;
            transition: transform .3s ease-out, -webkit-transform .3s ease-out;
            -webkit-transform: translate(0, -50px);
            transform: translate(0, -50px)
        }

        @media (prefers-reduced-motion:reduce) {
            .modal.fade .modal-dialog {
                transition: none
            }
        }

        .modal.show .modal-dialog {
            -webkit-transform: none;
            transform: none
        }

        .modal.modal-static .modal-dialog {
            -webkit-transform: scale(1.02);
            transform: scale(1.02)
        }

        .modal-dialog-scrollable {
            display: -ms-flexbox;
            display: flex;
            max-height: calc(100% - 1rem)
        }

        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 1rem);
            overflow: hidden
        }

        .modal-dialog-scrollable .modal-footer,
        .modal-dialog-scrollable .modal-header {
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto
        }

        .modal-dialog-centered {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            min-height: calc(100% - 1rem)
        }

        .modal-dialog-centered::before {
            display: block;
            height: calc(100vh - 1rem);
            height: -webkit-min-content;
            height: -moz-min-content;
            height: min-content;
            content: ""
        }

        .modal-dialog-centered.modal-dialog-scrollable {
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            height: 100%
        }

        .modal-dialog-centered.modal-dialog-scrollable .modal-content {
            max-height: none
        }

        .modal-dialog-centered.modal-dialog-scrollable::before {
            content: none
        }

        .modal-content {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: .3rem;
            outline: 0
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            width: 100vw;
            height: 100vh;
            background-color: #000
        }

        .modal-backdrop.fade {
            opacity: 0
        }

        .modal-backdrop.show {
            opacity: .5
        }

        .modal-header {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: start;
            align-items: flex-start;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1rem 1rem;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: calc(.3rem - 1px);
            border-top-right-radius: calc(.3rem - 1px)
        }

        .modal-header .close {
            padding: 1rem 1rem;
            margin: -1rem -1rem -1rem auto
        }

        .modal-title {
            margin-bottom: 0;
            line-height: 1.5
        }

        .modal-body {
            position: relative;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1rem
        }

        .modal-footer {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: end;
            justify-content: flex-end;
            padding: .75rem;
            border-top: 1px solid #dee2e6;
            border-bottom-right-radius: calc(.3rem - 1px);
            border-bottom-left-radius: calc(.3rem - 1px)
        }

        .modal-footer>* {
            margin: .25rem
        }

        .modal-scrollbar-measure {
            position: absolute;
            top: -9999px;
            width: 50px;
            height: 50px;
            overflow: scroll
        }

        @media (min-width:576px) {
            .modal-dialog {
                max-width: 500px;
                margin: 1.75rem auto
            }

            .modal-dialog-scrollable {
                max-height: calc(100% - 3.5rem)
            }

            .modal-dialog-scrollable .modal-content {
                max-height: calc(100vh - 3.5rem)
            }

            .modal-dialog-centered {
                min-height: calc(100% - 3.5rem)
            }

            .modal-dialog-centered::before {
                height: calc(100vh - 3.5rem);
                height: -webkit-min-content;
                height: -moz-min-content;
                height: min-content
            }

            .modal-sm {
                max-width: 300px
            }
        }

        @media (min-width:992px) {

            .modal-lg,
            .modal-xl {
                max-width: 800px
            }
        }

        @media (min-width:1200px) {
            .modal-xl {
                max-width: 1140px
            }
        }
    </style>
    <div class="row row-sm">
        <?php
        
        use App\Helpers\MasterRulesManagement\RulesManagement;
        $use = new RulesManagement();
        $attendaceMode = $use->AttendanceActiveModesCheck();
        $attendanceShift = $use->AttendanceCounters(); //0
        // $trackInOUTStatus = $use->TrackInOutStatus();
        // dd($use->AttendanceActiveModesCheck());6
        ?>

        @if (in_array('Attendance Attedance-Mode.View', $permissions))
            @if (in_array('Attendance Shift.View', $permissions))
                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2 my-auto">
                                    <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                            class="mdi mdi-alarm-plus nav-icon"></i></span>
                                </div>
                                <div class="col-10 d-flex justify-content-between">
                                    <div class="my-auto"><a href="#">
                                            <h5 class="my-auto text-dark">Shift Settings</h5>
                                        </a>
                                        <p class="my-auto">
                                            <?= $attendanceShift[0] ?> Shift Created
                                        </p>
                                    </div>
                                    <div class="my-auto"><a href="{{ url('admin/settings/attendance/create_shift') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (in_array('Attendance Attedance-Mode.View', $permissions))
                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2 my-auto">
                                    <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                            class="mdi mdi-account-convert nav-icon"></i></span>
                                </div>
                                <div class="col-10 d-flex justify-content-between">

                                    <div class="my-auto"><a href="#">
                                            <h5 class="my-auto text-dark">Attendance Mode</h5>
                                        </a>
                                        {{-- /Face Id, QR Code and Location. --}}
                                        <p class="my-auto">
                                            <?php
                                            // $attendaceMode = AttendanceActiveModesCheck(); // Assuming this function returns an array
                                            if ($attendaceMode[0] ?? false) {
                                                if ($attendaceMode[0]->in_premises_auto != 0 || $attendaceMode[0]->in_premises_auto != null || ($attendaceMode[0]->in_premises_qr != null || $attendaceMode[0]->in_premises_face_id != null || $attendaceMode[0]->in_premises_selfie != null)) {
                                                    echo '<b>Office </b>';
                                            
                                                    if ($attendaceMode[0]->in_premises_auto != 0) {
                                                        echo 'Employee with Auto Attendance';
                                                        echo $attendaceMode[0]->in_premises_auto != 0 ? 'Mark Present By Default' : '';
                                                    }
                                            
                                                    if ($attendaceMode[0]->in_premises_qr != null || $attendaceMode[0]->in_premises_face_id != null || $attendaceMode[0]->in_premises_selfie != null) {
                                                        echo $attendaceMode[0]->in_premises_qr != 0 ? 'Manual Attendance QR & Geo Location' : '';
                                                        echo $attendaceMode[0]->in_premises_face_id != 0 ? '<br>Manual Attendance Face Id & Geo Location' : '';
                                                        echo $attendaceMode[0]->in_premises_selfie != 0 ? '<br>Manual Attendance Selfie & Geo Location' : '';
                                                    }
                                                }
                                                if ($attendaceMode[0]->outdoor_auto != 0 || $attendaceMode[0]->outdoor_selfie != null) {
                                                    echo '<br><b>Out Door </b>';
                                            
                                                    if ($attendaceMode[0]->outdoor_auto != 0) {
                                                        echo 'Employee with Auto Attendance';
                                                        echo $attendaceMode[0]->outdoor_auto != 0 ? 'Mark Present By Default' : '';
                                                    }
                                            
                                                    if ($attendaceMode[0]->outdoor_selfie != null) {
                                                        echo $attendaceMode[0]->outdoor_selfie != 0 ? 'Manual Selfie & Geo Location' : '';
                                                    }
                                                }
                                                if ($attendaceMode[0]->wfh_auto != null && $attendaceMode[0]->wfh_selfie != null) {
                                                    echo '<br><b>Remote </b>';
                                            
                                                    if ($attendaceMode[0]->wfh_auto == 1) {
                                                        echo 'Employee with Auto Attendance';
                                                        echo $attendaceMode[0]->wfh_auto == 1 ? 'Mark Present By Default' : '';
                                                    }
                                            
                                                    if ($attendaceMode[0]->wfh_selfie == 1) {
                                                        echo $attendaceMode[0]->wfh_selfie == 1 ? 'Manual  Selfie & Geo Location' : '';
                                                    }
                                                } else {
                                                    echo 'Off Attendance Mode.';
                                                }
                                            }
                                            ?>


                                        </p>
                                    </div>
                                    <div class="my-auto"><a href="#" data-bs-target="#attMode"
                                            data-bs-toggle="modal"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('Attendance Automation-Rules.View', $permissions))
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 my-auto">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="fa fa-gears nav-icon"></i></span>
                            </div>
                            <div class="col-10 d-flex justify-content-between">
                                <div class="my-auto"><a href="#">
                                        <h5 class="my-auto text-dark">Automation Rules</h5>
                                    </a>
                                    <p class="my-auto">Track Late Entry, Early Out, Overtime, and Breaks.</p>
                                </div>
                                <div class="my-auto"><a href="{{ url('admin/settings/attendance/automation') }}"><i
                                            class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

            {{-- @if (in_array('Attendance TrackIn-OutTime.View', $permissions)) --}}
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 my-auto">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="fa mdi mdi-alarm nav-icon"></i></span>
                            </div>
                            <div class="col-10 d-flex justify-content-between">
                                <div class="my-auto"><a href="#">
                                        <h5 class="my-auto text-dark">Track In & Out Time</h5>
                                    </a>
                                    <p class="my-auto">

                                        <?php
                                        $message = '';
                                        if ($Track ?? false) {
                                            $track_in_out = $Track->track_in_out; // Replace with the actual value
                                            $no_attendance_without_punch = $Track->no_attendace_without_punch; // Replace with the actual value
                                            if ($track_in_out == 1) {
                                                $message = 'Record both In & Out time for all employees';
                                            }
                                            if ($no_attendance_without_punch == 1) {
                                                $message = 'Punch out is required to mark attendance';
                                            }
                                            if ($track_in_out == 1 && $no_attendance_without_punch == 1) {
                                                $message = "Record both In & Out time for all employees \n Punch out is required to mark attendance";
                                            }
                                            if ($track_in_out == 0 && $no_attendance_without_punch == 0) {
                                                $message = 'Off';
                                            }
                                        }
                                        echo $message;
                                        ?>
                                    </p>
                                </div>
                                <div class="my-auto"><a href="#" data-bs-target="#ioModal" data-bs-toggle="modal"><i
                                            class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
           
            @if (in_array('Attendance Access-List.View', $permissions))
                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2 my-auto">
                                    <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                            class="mdi mdi-account-check nav-icon"></i></span>
                                </div>
                                <div class="col-10 d-flex justify-content-between">

                                    <div class="my-auto"><a href="#">
                                            <h5 class="my-auto text-dark">Attendance Employee Access</h5>
                                        </a>
                                        <p class="my-auto">20 Employees</p>
                                    </div>
                                    <div class="my-auto"><a
                                            href="{{ url('/admin/settings/attendance/attendance-access') }}"><i
                                                class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
           
            {{-- Temprarly Commented By Aman Sahu (Do not remove) --}}
            {{-- <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon las la-cog"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Daily Work Entry</h5>
                            </a>
                            <p class="my-auto">Assign to Employee</p>
                        </div>
                        <div class="my-auto"><a href="#" data-bs-target="#workAccess" data-bs-toggle="modal"><i
                                    class="ion-chevron-right fs-10 my-auto"></i>
                                <i class="ion-chevron-right fs-10 my-auto"></i>
                                <i class="ion-chevron-right fs-10 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}
             {{-- @if (in_array('Attendance TrackIn-OutTime.View', $permissions)) --}}
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 my-auto">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="fa mdi mdi-alarm nav-icon"></i></span>
                            </div>
                            <div class="col-10 d-flex justify-content-between">
                                <div class="my-auto"><a href="#">
                                        <h5 class="my-auto text-dark">Final Rule Activation</h5>
                                    </a>
                                    <p class="my-auto">
                                    </p>
                                </div>
                                {{-- <a class="modal-effect btn btn-primary btn-block mx-3" data-effect="effect-scale"
                            data-bs-toggle="modal" href="{{route('attendance.activeMode')}}" id="btnOpen">Start Mode</a> --}}

                                <div class="my-auto"><a class="btn" href="{{ route('attendance.activeMode') }}"><i
                                            class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
            @if (in_array('Attendance Holiday.View', $permissions))
                {{-- <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="mdi mdi-beach nav-icon"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">

                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Attendance On Holiday</h5>
                            </a>
                            <p class="my-auto">Attendance on Holidays, Comoff.</p>
                        </div>
                        <div class="my-auto"><a href="#" data-bs-target="#ioModal" data-bs-toggle="modal"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
            @endif
            {{-- <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="fa fa-calendar-check-o nav-icon"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Mark Absent on Previous Day</h5>
                            </a>
                            <p class="my-auto">Not Activated.</p>
                        </div>
                        <div class="my-auto"><a href="#"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}
        @endif
    </div>

    {{-- attendance mode modal --}}
    <div class="container">
        <div class="modal fade" id="attMode">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Attendance Mode</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('attendanceMode') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="card">
                                <p>Create attendance category to generate mode of attendance </p>
                                <div class="card-header border-0">
                                    <h6 class="card-title" style="font-size: 1rem"><b>Office</b></h6>
                                    <label class="custom-switch ms-auto">
                                        <?php if (($Modes!=null) && ($Modes->in_premises_auto == 1 || $Modes->in_premises_qr == 1 || $Modes->in_premises_face_id == 1 || $Modes->in_premises_selfie == 1)){ ?>
                                        <input type="checkbox" name="premisesActive" onchange="inPremises()"
                                            id="isPremises" class="custom-switch-input" checked>
                                        <?php }else{ ?>
                                        <input type="checkbox" name="premisesActive" onchange="inPremises()"
                                            id="isPremises" class="custom-switch-input">
                                        <?php } ?>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                                <?php if (($Modes!=null) && ($Modes->in_premises_auto == 1 || $Modes->in_premises_qr == 1 || $Modes->in_premises_face_id == 1 || $Modes->in_premises_selfie == 1)) { ?>
                                <div class="form-group mx-5" id="inPremisesContent">
                                    <?php }else{ ?>
                                    <div class="form-group mx-5 d-none" id="inPremisesContent">
                                        <?php } ?>
                                        <div class="row">
                                            <div class="d-flex mt-2">
                                                <label class="custom-control custom-radio">
                                                    <?php if (($Modes!=null) && ($Modes->in_premises_auto == 1 )) { ?>
                                                    <input type="radio" class="custom-control-input"
                                                        onchange="inPremises()" name="premisesIsAuto" id="premisesAuto"
                                                        value="1" checked>
                                                    <?php }else{ ?>
                                                    <input type="radio" class="custom-control-input"
                                                        onchange="inPremises()" name="premisesIsAuto" id="premisesAuto"
                                                        value="1">
                                                    <?php } ?>
                                                    <span class="custom-control-label">Auto</span>
                                                </label>
                                                &nbsp;&nbsp;
                                                <label class="custom-control custom-radio mx-1">
                                                    <?php if (($Modes!=null) && ($Modes->in_premises_qr == 1 || $Modes->in_premises_face_id == 1 || $Modes->in_premises_selfie == 1 )) { ?>
                                                    <input type="radio" class="custom-control-input"
                                                        onchange="inPremises()" name="premisesIsAuto" id="premisesManual"
                                                        value="0" checked>
                                                    <?php }else{ ?>
                                                    <input type="radio" class="custom-control-input"
                                                        onchange="inPremises()" name="premisesIsAuto" id="premisesManual"
                                                        value="0">
                                                    <?php } ?>
                                                    <span class="custom-control-label">Manual</span>
                                                </label>
                                            </div>

                                            <?php if (($Modes!=null) && ($Modes->in_premises_auto == 1 )) { ?>
                                            <div class="" id="premisesAutoContent">
                                                <?php }else{ ?>
                                                <div class="d-none" id="premisesAutoContent">
                                                    <?php } ?>
                                                    <div class="d-flex">
                                                        <label class="custom-control custom-checkbox">
                                                            <?php if (($Modes!=null) && ($Modes->in_premises_auto == 1 )) { ?>
                                                            <input type="checkbox" class="custom-control-input"
                                                                name="premisesDefault" id="premisesDefault"
                                                                value="1" checked>
                                                            <?php }else{ ?>
                                                            <input type="checkbox" class="custom-control-input"
                                                                name="premisesDefault" id="premisesDefault"
                                                                value="1">
                                                            <?php } ?>
                                                            <span class="custom-control-label"></span>
                                                        </label>
                                                        <label class="form-label mx-1">Mark Present By Default <br> <span
                                                                class="fs-12 fw-light text-muted">Default Auto Present can
                                                                be
                                                                changed
                                                                Manually</span></label>
                                                    </div>
                                                </div>
                                                <?php if (($Modes!=null) && ($Modes->in_premises_qr == 1 || $Modes->in_premises_face_id == 1 || $Modes->in_premises_selfie == 1 )) { ?>
                                                <div class="" id="premisesManualContent">
                                                    <?php }else{ ?>
                                                    <div class="d-none" id="premisesManualContent">
                                                        <?php } ?>
                                                        <div class="d-flex">

                                                            <label class="custom-control custom-checkbox">
                                                                <?php if (($Modes!=null) && $Modes->in_premises_qr == 1 ) { ?>
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="premisesQR" id="premisesQR" value="1"
                                                                    checked>
                                                                <?php }else{ ?>
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="premisesQR" id="premisesQR" value="1">
                                                                <?php } ?>
                                                                <span class="custom-control-label"></span>
                                                            </label>
                                                            <label class="form-label mx-1">Employee Attendance with QR &
                                                                Geo
                                                                Location
                                                                <br> <span class="fs-12 fw-light  text-muted">Employee can
                                                                    mark
                                                                    their
                                                                    own attendance with QR, Geo Location Captured
                                                                    Automatically</span></label>
                                                        </div>

                                                        <div class="d-flex">
                                                            <label class="custom-control custom-checkbox">
                                                                <?php if (($Modes!=null) && $Modes->in_premises_face_id == 1  ) { ?>
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="premisesFaceId" id="premisesFaceId"
                                                                    value="1" checked>
                                                                <?php }else{ ?>
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="premisesFaceId" id="premisesFaceId"
                                                                    value="1">
                                                                <?php } ?>
                                                                <span class="custom-control-label"></span>
                                                            </label>
                                                            <label class="form-label mx-1">Employee Attendance with Face Id
                                                                &
                                                                Geo
                                                                Location <br> <span
                                                                    class="fs-12 fw-light  text-muted">Employee
                                                                    can
                                                                    mark
                                                                    their own attendance with Scan Face, Geo Location
                                                                    Captured
                                                                    Automatically</span></label>
                                                        </div>
                                                        <div class="d-flex">
                                                            <label class="custom-control custom-checkbox">
                                                                <?php if (($Modes!=null) &&  $Modes->in_premises_selfie == 1 ) { ?>
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="premisesSelfie" id="premisesSelfie"
                                                                    value="1" checked>
                                                                <?php }else{ ?>
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="premisesSelfie" id="premisesSelfie"
                                                                    value="1">
                                                                <?php } ?>
                                                                <span class="custom-control-label"></span>
                                                            </label>
                                                            <label class="form-label mx-1">Employee Attendance with Selfie
                                                                &
                                                                Geo
                                                                Location <br> <span
                                                                    class="fs-12 fw-light  text-muted">Employee
                                                                    can
                                                                    mark
                                                                    their own attendance with take a Selfie, Geo Location
                                                                    Captured
                                                                    Automatically</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                function inPremises() {
                                                    var inPremises = document.getElementById('isPremises');
                                                    var inPremisesContent = document.getElementById('inPremisesContent');
                                                    var inPremisesContentcheckboxes = inPremisesContent.querySelectorAll('[checked]');
                                                    var premisesAuto = document.getElementById('premisesAuto');
                                                    var premisesManual = document.getElementById('premisesManual');

                                                    var premisesAutoContent = document.getElementById('premisesAutoContent');
                                                    var premisesManualContent = document.getElementById('premisesManualContent');
                                                    if (inPremises.checked == true) {
                                                        inPremisesContent.classList.remove("d-none");
                                                    } else {
                                                        inPremisesContent.classList.add("d-none");
                                                        inPremisesContentcheckboxes.forEach(element2 => {
                                                            element2.checked = false;
                                                        });
                                                    }

                                                    if (premisesAuto.checked == true) {
                                                        // console.log(inPremises.checked);
                                                        premisesAutoContent.classList.remove("d-none");
                                                        premisesManualContent.classList.add("d-none");
                                                    }
                                                    if (premisesManual.checked == true) {
                                                        premisesManualContent.classList.remove("d-none");
                                                        premisesAutoContent.classList.add("d-none");
                                                    }
                                                }
                                            </script>

                                            <div class="card-header border-0">
                                                <h6 class="card-title" style="font-size: 1rem"><b>Out Door</b></h6>
                                                <label class="custom-switch ms-auto">
                                                    <?php if (($Modes!=null) && ($Modes->outdoor_auto == 1 ||  $Modes->outdoor_selfie == 1 )) { ?>
                                                    <input type="checkbox" name="outDoorActive" onchange="OutDoor()"
                                                        id="isOutDoor" class="custom-switch-input" checked>
                                                    <?php }else{ ?>
                                                    <input type="checkbox" name="outDoorActive" onchange="OutDoor()"
                                                        id="isOutDoor" class="custom-switch-input">
                                                    <?php } ?>
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </div>
                                            <?php if (($Modes!=null) && ($Modes->outdoor_auto == 1 ||  $Modes->outdoor_selfie == 1 )) { ?>
                                            <div class="form-group mx-5" id="inOutdoorContent">
                                                <?php }else{ ?>
                                                <div class="form-group mx-5 d-none" id="inOutdoorContent">
                                                    <?php } ?>
                                                    <div class="row">
                                                        <div class="d-flex mt-2">
                                                            <label class="custom-control custom-radio">
                                                                <?php if (($Modes!=null) && $Modes->outdoor_auto == 1) { ?>
                                                                <input type="radio" class="custom-control-input"
                                                                    onchange="OutDoor()" name="outIsAuto" id="outAuto"
                                                                    value="1" checked>
                                                                <?php }else{ ?>
                                                                <input type="radio" class="custom-control-input"
                                                                    onchange="OutDoor()" name="outIsAuto" id="outAuto"
                                                                    value="1">
                                                                <?php } ?>
                                                                <span class="custom-control-label">Auto</span>
                                                            </label>
                                                            &nbsp;&nbsp;

                                                            <label class="custom-control custom-radio mx-1">
                                                                <?php if (($Modes!=null) && $Modes->outdoor_selfie == 1 ) { ?>
                                                                <input type="radio" class="custom-control-input"
                                                                    onchange="OutDoor()" name="outIsAuto" id="outManual"
                                                                    value="0" checked>
                                                                <?php }else{ ?>
                                                                <input type="radio" class="custom-control-input"
                                                                    onchange="OutDoor()" name="outIsAuto" id="outManual"
                                                                    value="0">
                                                                <?php } ?>
                                                                <span class="custom-control-label">Manual</span>
                                                            </label>
                                                        </div>

                                                        <?php if (($Modes!=null) && $Modes->outdoor_auto == 1) { ?>
                                                        <div class="" id="outAutoContent">
                                                            <?php }else{ ?>
                                                            <div class="d-none" id="outAutoContent">
                                                                <?php } ?>
                                                                <div class="d-flex">
                                                                    {{-- /my-auto --}}
                                                                    <label class="custom-control custom-checkbox ">
                                                                        <?php if (($Modes!=null) && $Modes->outdoor_auto == 1) { ?>
                                                                        <input type="checkbox"
                                                                            class="custom-control-input" name="outDefault"
                                                                            id="outDefault" value="1" checked>
                                                                        <?php }else{ ?>
                                                                        <input type="checkbox"
                                                                            class="custom-control-input" name="outDefault"
                                                                            id="outDefault" value="1">
                                                                        <?php } ?>
                                                                        <span class="custom-control-label"></span>
                                                                    </label>
                                                                    <label class="form-label mx-1">Mark Present By Default
                                                                        <br> <span
                                                                            class="fs-12 fw-light text-muted">Default
                                                                            Auto Present can
                                                                            be
                                                                            changed
                                                                            Manually</span></label>
                                                                </div>
                                                            </div>
                                                            <?php if (($Modes!=null) && $Modes->outdoor_selfie == 1 ) { ?>
                                                            <div class="" id="outManualContent">
                                                                <?php }else{ ?>
                                                                <div class="d-none" id="outManualContent">
                                                                    <?php } ?>
                                                                    {{-- my-auto --}}
                                                                    <div class="d-flex">
                                                                        <label class="custom-control custom-checkbox">
                                                                            <?php if (($Modes!=null) && $Modes->outdoor_selfie == 1 ) { ?>
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                name="outSelfie" id="outSelfie"
                                                                                value="1" checked>
                                                                            <?php }else{ ?>
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                name="outSelfie" id="outSelfie"
                                                                                value="1">
                                                                            <?php } ?>
                                                                            <span class="custom-control-label"></span>
                                                                        </label>
                                                                        <label class="form-label mx-1">Employee Attendance
                                                                            with Selfie & Geo
                                                                            Location <br> <span
                                                                                class="fs-12 fw-light  text-muted">Employee
                                                                                can
                                                                                mark
                                                                                their own attendance with take a Selfie, Geo
                                                                                Location
                                                                                Captured
                                                                                Automatically</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            function OutDoor() {
                                                                var isOutDoor = document.getElementById('isOutDoor');
                                                                var inOutdoorContent = document.getElementById('inOutdoorContent');
                                                                var inOutdoorContentcheckboxes = inOutdoorContent.querySelectorAll('[checked]');
                                                                if (isOutDoor.checked == true) {
                                                                    inOutdoorContent.classList.remove("d-none");
                                                                } else {
                                                                    inOutdoorContent.classList.add("d-none");
                                                                    inOutdoorContentcheckboxes.forEach(element => {
                                                                        element.checked = false;
                                                                    });
                                                                }

                                                                var outAuto = document.getElementById('outAuto');
                                                                var outManual = document.getElementById('outManual');

                                                                var outAutoContent = document.getElementById('outAutoContent');
                                                                var outManualContent = document.getElementById('outManualContent');

                                                                if (outAuto.checked == true) {
                                                                    outAutoContent.classList.remove("d-none");
                                                                    outManualContent.classList.add("d-none");
                                                                }

                                                                if (outManual.checked == true) {
                                                                    outAutoContent.classList.add("d-none");
                                                                    outManualContent.classList.remove("d-none");
                                                                }
                                                            }
                                                        </script>

                                                        <div class="card-header border-0">
                                                            <h6 class="card-title" style="font-size: 1rem"><b>Remote</b>
                                                            </h6>
                                                            <label class="custom-switch ms-auto">
                                                                <?php if (($Modes!=null) && ($Modes->wfh_auto == 1 || $Modes->wfh_selfie == 1) ) { ?>
                                                                <input type="checkbox" name="wfhActive" onchange="wfh()"
                                                                    class="custom-switch-input" id="isWFH" checked>
                                                                <?php }else{ ?>
                                                                <input type="checkbox" name="wfhActive" onchange="wfh()"
                                                                    class="custom-switch-input" id="isWFH">
                                                                <?php } ?>
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </div>
                                                        <?php if (($Modes!=null) && ($Modes->wfh_auto == 1 || $Modes->wfh_selfie == 1) ) { ?>
                                                        <div class="form-group mx-5" id="isWFHContent">
                                                            <?php }else{ ?>
                                                            <div class="form-group mx-5 d-none" id="isWFHContent">
                                                                <?php } ?>
                                                                <div class="row">

                                                                    <div class="d-flex mt-2">
                                                                        <label class="custom-control custom-radio">
                                                                            <?php if (($Modes!=null) && $Modes->wfh_auto == 1 ) { ?>
                                                                            <input type="radio"
                                                                                class="custom-control-input"
                                                                                onchange="wfh()" name="wfhIsAuto"
                                                                                id="wfhAuto" value="1" checked>
                                                                            <?php }else{ ?>
                                                                            <input type="radio"
                                                                                class="custom-control-input"
                                                                                onchange="wfh()" name="wfhIsAuto"
                                                                                id="wfhAuto" value="1">
                                                                            <?php } ?>
                                                                            <span class="custom-control-label">Auto</span>
                                                                        </label>
                                                                        &nbsp;&nbsp;

                                                                        <label class="custom-control custom-radio">
                                                                            <?php if ( ($Modes!=null) && $Modes->wfh_selfie == 1 ) { ?>
                                                                            <input type="radio"
                                                                                class="custom-control-input"
                                                                                onchange="wfh()" name="wfhIsAuto"
                                                                                id="wfhManual" value="0" checked>
                                                                            <?php }else{ ?>
                                                                            <input type="radio"
                                                                                class="custom-control-input"
                                                                                onchange="wfh()" name="wfhIsAuto"
                                                                                id="wfhManual" value="0">
                                                                            <?php } ?>
                                                                            <span
                                                                                class="custom-control-label">Manual</span>
                                                                        </label>
                                                                    </div>

                                                                    <?php if (($Modes!=null) && $Modes->wfh_auto == 1 ) { ?>
                                                                    <div class="" id="wfhAutoContent">
                                                                        <?php }else{ ?>
                                                                        <div class="d-none" id="wfhAutoContent">
                                                                            <?php } ?>
                                                                            {{-- my-auto --}}
                                                                            <div class="d-flex">
                                                                                <label
                                                                                    class="custom-control custom-checkbox">
                                                                                    <?php if (($Modes!=null) && $Modes->wfh_auto == 1 ) { ?>
                                                                                    <input type="checkbox"
                                                                                        class="custom-control-input"
                                                                                        name="wfhDefault" id="wfhDefault"
                                                                                        value="1" checked>
                                                                                    <?php }else{ ?>
                                                                                    <input type="checkbox"
                                                                                        class="custom-control-input"
                                                                                        name="wfhDefault" id="wfhDefault"
                                                                                        value="1">
                                                                                    <?php } ?>
                                                                                    <span
                                                                                        class="custom-control-label"></span>
                                                                                </label>
                                                                                <label class="form-label mx-1">Mark Present
                                                                                    By
                                                                                    Default <br> <span
                                                                                        class="fs-12 fw-light text-muted">Default
                                                                                        Auto Present can
                                                                                        be
                                                                                        changed
                                                                                        Manually</span></label>
                                                                            </div>
                                                                        </div>

                                                                        <?php if (($Modes!=null) && $Modes->wfh_selfie == 1 ) { ?>
                                                                        <div class="d-none" id="wfhManualContent" checked>
                                                                            <?php }else{ ?>
                                                                            <div class="d-none" id="wfhManualContent">
                                                                                <?php } ?>
                                                                                {{-- my-auto --}}
                                                                                <div class="d-flex">
                                                                                    <label
                                                                                        class="custom-control custom-checkbox ">
                                                                                        <?php if (($Modes!=null) &&  $Modes->wfh_selfie == 1 ) { ?>
                                                                                        <input type="checkbox"
                                                                                            class="custom-control-input"
                                                                                            name="wfhSelfie"
                                                                                            id="wfhSelfie" value="1"
                                                                                            checked>
                                                                                        <?php }else{ ?>
                                                                                        <input type="checkbox"
                                                                                            class="custom-control-input"
                                                                                            name="wfhSelfie"
                                                                                            id="wfhSelfie" value="1">
                                                                                        <?php } ?>


                                                                                        <span
                                                                                            class="custom-control-label"></span>
                                                                                    </label>
                                                                                    <label class="form-label mx-1">
                                                                                        Employee
                                                                                        Attendance
                                                                                        with Selfie & Geo
                                                                                        Location <br> <span
                                                                                            class="fs-12 fw-light  text-muted">Employee
                                                                                            can
                                                                                            mark
                                                                                            their own attendance with take a
                                                                                            Selfie, Geo
                                                                                            Location
                                                                                            Captured
                                                                                            Automatically</span></label>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <script>
                                                                        function wfh() {
                                                                            var isWFH = document.getElementById('isWFH');
                                                                            var isWFHContent = document.getElementById('isWFHContent');
                                                                            var isWFHContentcheckboxes = isWFHContent.querySelectorAll('[checked]');
                                                                            if (isWFH.checked == true) {
                                                                                isWFHContent.classList.remove("d-none");
                                                                            } else {
                                                                                isWFHContent.classList.add("d-none");
                                                                                isWFHContentcheckboxes.forEach(element1 => {
                                                                                    element1.checked = false;
                                                                                });
                                                                            }

                                                                            var wfhAuto = document.getElementById('wfhAuto');
                                                                            var wfhManual = document.getElementById('wfhManual');

                                                                            var wfhAutoContent = document.getElementById('wfhAutoContent');
                                                                            var wfhManualContent = document.getElementById('wfhManualContent');

                                                                            if (wfhAuto.checked == true) {
                                                                                wfhAutoContent.classList.remove("d-none");
                                                                                wfhManualContent.classList.add("d-none");
                                                                            }

                                                                            if (wfhManual.checked == true) {
                                                                                wfhAutoContent.classList.add("d-none");
                                                                                wfhManualContent.classList.remove("d-none");
                                                                            }
                                                                        }
                                                                    </script>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-light" type="reset"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button class="btn btn-primary" type="submit"
                                                                    id="savechanges">Save & Apply</button>
                                                            </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    {{-- daily work entry modal --}}
    {{-- <div class="modal fade" id="workAccess">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Daily Work Entry Access</h6>
                        </div>
                        <div class="card-body border-0">
                            <div class="row">
                                <div class="col-md-12 col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label">Department:</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Select Employee">
                                            <option label="Select Employee"></option>
                                            <option value="1">Faith Harris</option>
                                            <option value="2">Austin Bell</option>
                                            <option value="3">Maria Bower</option>
                                            <option value="4">Peter Hill</option>
                                            <option value="5">Victoria Lyman</option>
                                            <option value="6">Adam Quinn</option>
                                            <option value="7">Melanie Coleman</option>
                                            <option value="8">Max Wilson</option>
                                            <option value="9">Amelia Russell</option>
                                            <option value="10">Justin Metcalfe</option>
                                            <option value="11">Ryan Young</option>
                                            <option value="12">Jennifer Hardacre</option>
                                            <option value="13">Justin Parr</option>
                                            <option value="14">Julia Hodges</option>
                                            <option value="15">Michael Sutherland</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label">Designation:</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Select Employee">
                                            <option label="Select Employee"></option>
                                            <option value="1">Faith Harris</option>
                                            <option value="2">Austin Bell</option>
                                            <option value="3">Maria Bower</option>
                                            <option value="4">Peter Hill</option>
                                            <option value="5">Victoria Lyman</option>
                                            <option value="6">Adam Quinn</option>
                                            <option value="7">Melanie Coleman</option>
                                            <option value="8">Max Wilson</option>
                                            <option value="9">Amelia Russell</option>
                                            <option value="10">Justin Metcalfe</option>
                                            <option value="11">Ryan Young</option>
                                            <option value="12">Jennifer Hardacre</option>
                                            <option value="13">Justin Parr</option>
                                            <option value="14">Julia Hodges</option>
                                            <option value="15">Michael Sutherland</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table  table-vcenter text-nowrap" id="hr-table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h6 class="mb-1 fs-14">Faith Harris</h6>
                                                <p class="text-muted mb-0 fs-12">faith@gmail.com</p>
                                            </td>
                                            <td>+91 8319511718</td>
                                            <td><label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox"
                                                        class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                </label></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h6 class="mb-1 fs-14">Faith Harris</h6>
                                                <p class="text-muted mb-0 fs-12">faith@gmail.com</p>
                                            </td>
                                            <td>+91 8319511718</td>
                                            <td><label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox"
                                                        class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                </label></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- attendance mode modal --}}
    <div class="modal fade" id="ioModal">
        <div class="modal-dialog" role="document">

            <form action="{{ route('attendance.trackInOut') }}" method="post">
                @csrf

                <div class="modal-content modal-content-demo">

                    <div class="modal-header border-0">
                        <h4 class="modal-title">Track In & Out Time Mode</h4><a aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></a>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header  border-0">
                                <h6 class="card-title">Auto Attendance</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-11">
                                            <label class="form-label">Track In & Out Time</label>
                                            <span class="d-block fs-12 text-muted">Record both In & Out time for all
                                                employee</span>
                                        </div>
                                        <div class="col-xl-1 pe-0">
                                            <label class="custom-switch">
                                                <input type="checkbox" name="tranck_in_out" class="custom-switch-input"
                                                    value="1" <?php echo $Track->track_in_out ?? false ? 'checked' : ''; ?>>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-11">
                                            <label class="form-label">No Attendance without punch</label>
                                            <span class="d-block fs-12 text-muted">Punch out is required to mark
                                                attendance</span>
                                        </div>
                                        <div class="col-xl-1 pe-0">
                                            <label class="custom-switch">
                                                <input type="checkbox" name="no_attendace_with_punch"
                                                    class="custom-switch-input" value="1" <?php echo $Track->no_attendace_without_punch ?? false ? 'checked' : ''; ?>>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" data-bs-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-primary">Save & Apply</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- route('attendance.endgameSubmit') --}}

    {{-- add new shift --}}
    {{-- create modal --}}
    <div class="modal fade" id="finalRuleActivationModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Started Activation Rule
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                    </button>
                </div>
                <form action="{{ route('attendance.endgameSubmit') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        {{-- <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Start Active Method</h3>
                        </div>

                        <div class="card-body">

                        </div>
                    </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" id="savechanges">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Mark Absent on Previous Day modal --}}
@endsection
