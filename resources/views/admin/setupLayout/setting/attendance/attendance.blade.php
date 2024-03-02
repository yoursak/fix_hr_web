    @extends('admin.setupLayout.master')
@section('title')
    Attendance | Create Shift
@endsection
<style>
    .nav-link.icon {
        line-height: 0;
    }

    .modal-header,
    .modal-footer {
        /* background-color: #f8f8ff; */
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
@section('content')
<?php
   use App\Helpers\MasterRulesManagement\RulesManagement;
   $use = new RulesManagement();
   $attendaceMode = $use->AttendanceActiveModesCheck();
   $attendanceShift = $use->AttendanceCounters();
   ?>
   @if ( in_array('Attendance Setting.View', $permissions)  ||  in_array('Shift Settings.View', $permissions) ||  in_array('Attendance Mode.View', $permissions) ||  in_array('Automation-Rules.View', $permissions) ||  in_array('Camera Permission.View', $permissions))
   <div class="iniitial-header my-5">
    <h2 class="m-0"><b>Welcome to FixHR</b></h2>

    <p class="fs-16 text-muted">Kindly complete step by step process to register your business with us, do not skip setup process other wise it will not function</p>

    <span class="fs-16">
        <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Account Settings<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Business Settings<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
                <span class=""><i class="fa fa-circle mx-2 text-primary"></i>Attendance Settings<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class="text-muted"><i class="fa fa-circle mx-2"></i>Setup Activation<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class="text-muted"><i class="fa fa-circle mx-2"></i>Subscription<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class="text-muted"><i class="fa fa-circle mx-2"></i>Add Employee<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class="text-muted"><i class="fa fa-circle mx-2"></i>Finish<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
    </span>
</div>


<div class="row ">
    @if (in_array('Shift Settings.View', $permissions))
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
                        <div class="my-auto"><a href="{{ url('/setup/attendance-settings/create_shift') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (in_array('Attendance Mode.View', $permissions))
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="mdi mdi-account-convert nav-icon"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">

                        <div class="my-auto">
                            <a href="#">
                                <h5 class="my-auto text-dark">Attendance Mode</h5>
                            </a>
                            {{-- /Face Id, QR Code and Location. --}}
                            <p class="my-auto">
                                <?php
                                // dd($attendaceMode[0]->wfh_selfie);
                                            // $attendaceMode = AttendanceActiveModesCheck(); // Assuming this function returns an array
                                            if ($attendaceMode[0] ?? false) {
                                                if ($attendaceMode[0]->office_auto != 0 || $attendaceMode[0]->office_auto != null || ($attendaceMode[0]->office_qr != null || $attendaceMode[0]->office_face_id != null || $attendaceMode[0]->office_selfie != null)) {
                                                    if ($attendaceMode[0]->office_auto != 0) {
                                                        echo '<b>( Office </b><b><small>Auto</small>)</b>';
                                                        // echo 'Employee with Auto Attendance';
                                                        // echo $attendaceMode[0]->office_auto != 0 ? 'Mark Present By Default' : '';
                                                    }

                                                    if (($attendaceMode[0]->office_qr != 0 || $attendaceMode[0]->office_face_id != 0 || $attendaceMode[0]->office_selfie != 0) && $attendaceMode[0]->office_manual == 1) {
                                                        echo '<b>( Office </b><b><small>Manual</small>)</b>';
                                                        // echo $attendaceMode[0]->office_qr != 0 ? 'Manual' : '';//  QR & Geo Location
                                                        // echo $attendaceMode[0]->office_face_id != 0 ? '<br>Manual' : '';//  Face Id & Geo Location
                                                        // echo $attendaceMode[0]->office_selfie != 0 ? '<br>Manual' : '';//  Selfie & Geo Location
                                                    }
                                                }

                                                if ($attendaceMode[0]->outdoor_auto != 0 || $attendaceMode[0]->outdoor_selfie != null) {
                                                    // echo '<b>(  Out Door </b>';

                                                    if ($attendaceMode[0]->outdoor_auto != 0) {
                                                        echo '<b>(  Out Door </b><b><small>Auto </small>)</b>';

                                                        // echo 'Employee with Auto Attendance';
                                                        // echo $attendaceMode[0]->outdoor_auto != 0 ? 'Mark Present By Default' : '';
                                                    }

                                                    if (($attendaceMode[0]->outdoor_selfie != null) && ($attendaceMode[0]->outdoor_manual == 1) ) {
                                                        echo $attendaceMode[0]->outdoor_selfie != 0 ? '<b>(  Out Door </b><b><small>Manual</small>)</b>' : ''; // Selfie & Geo Location
                                                    }
                                                }

                                                if ($attendaceMode[0]->wfh_auto != null || $attendaceMode[0]->wfh_selfie != null) {
                                                    // echo '<b>( Remote </b>';

                                                    if ($attendaceMode[0]->wfh_auto == 1) {
                                                        echo '<b>( WFH </b><b><small>Auto </small>)</b>';

                                                        // echo 'Employee with Auto Attendance';
                                                        // echo $attendaceMode[0]->wfh_auto == 1 ? 'Mark Present By Default' : '';
                                                    }

                                                    if (($attendaceMode[0]->wfh_selfie == 1 ) && ( $attendaceMode[0]->wfh_manual	== 1 )) {
                                                        echo $attendaceMode[0]->wfh_selfie == 1 ? '<b>( WFH </b><b><small>Manual</small>)</b>' : ''; //Selfie & Geo Location
                                                    }
                                                }
                                            } else {
                                                echo 'Off Attendance Mode.';
                                            }
                                            ?>


                            </p>
                        </div>
                        <div class="my-auto"><a href="#" onclick="globalCondition()" data-bs-target="#attMode"
                                data-bs-toggle="modal"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- @if (in_array('Automation-Rules.View', $permissions) || in_array('Automation-Rules.All', $permissions))
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
                                <h5 class="my-auto text-dark">Automation Rules (Optional)</h5>
                            </a>
                            <p class="my-auto">Track Late Entry, Early Out, Overtime, and Breaks.</p>
                        </div>
                        <div class="my-auto"><a href="{{ url('/setup/attendance-settings/automation') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif --}}

    {{-- @if (in_array('Attendance TrackIn-OutTime.View', $permissions)) --}}
    <!-- <div class="col-xl-6">
        <div class="card custom-card" id="myCard">
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
                                            // $message = '';
                                            // if ($Track ?? false) {
                                            //     $track_in_out = $Track->track_in_out; // Replace with the actual value
                                            //     $no_attendance_without_punch = $Track->no_attendace_without_punch; // Replace with the actual value
                                            //     if ($track_in_out == 1) {
                                            //         $message = 'Record both In & Out time for all employees';
                                            //     }
                                            //     if ($no_attendance_without_punch == 1) {
                                            //         $message = 'Punch out is required to mark attendance';
                                            //     }
                                            //     if ($track_in_out == 1 && $no_attendance_without_punch == 1) {
                                            //         $message = "Record both In & Out time for all employees \n Punch out is required to mark attendance";
                                            //     }
                                            //     if ($track_in_out == 0 && $no_attendance_without_punch == 0) {
                                            //         $message = 'Off';
                                            //     }
                                            // }
                                            // echo $message;
                                            ?>
                            </p>
                        </div>
                        {{-- href="#" data-bs-target="#ioModal" data-bs-toggle="modal" --}}
                        <div class="my-auto"><a><i class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                    </div>
                </div>
            </div>
        </div>
    </div> -->
    {{-- @endif --}}
    {{-- @if (in_array('Attendance Access-List.View', $permissions)) --}}
    {{-- <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="mdi mdi-account-check nav-icon"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">

                        <?php
                                    $attendanceData = json_decode($AttendanceData, true); // Convert JSON to associative array

                                    $formattedData = [];

                                    foreach ($attendanceData as $method => $count) {
                                        $formattedData[] = "$method: $count";
                                    }

                                    $displayString = implode(' | ', $formattedData);
                                    ?>
                        <div class="my-auto">
                            <a href="#">
                                <h5 class="my-auto text-dark">Attendance Employee Access</h5>
                            </a>
                            <?= $displayString ?>
                            <!-- Display the formatted string -->
                        </div>
                        <div class="my-auto"><a href="{{ url('/admin/settings/attendance/attendance-access') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- @endif --}}
    @if (in_array('Camera Permission.View', $permissions))
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                class="nav-icon las la-cog"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Camera Permission (Optional)</h5>
                            </a>
                            <p class="my-auto">Assign Permission to Device Active</p>
                        </div>
                        <div class="my-auto"><a href="{{ url('/setup/attendance-settings/camera-access') }}"><i
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


    {{-- <div class="col-xl-6">
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

                                <?php //if($FinalEndGameRule??false){?>
                                @foreach ($FinalEndGameRule as $item)
                                <?= //$item->method_switch != 0 ? 'ON' : 'OFF' ?>
                                @endforeach
                                <?php //}?>
                            </p>
                        </div>

                        <div class="my-auto"><a class="btn" href="{{ route('attendance.activeMode') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a></div>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- @endif --}}
    {{-- @if (in_array('Attendance Holiday.View', $permissions)) --}}
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
    {{-- @endif --}}
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

</div>
<div class="d-flex justify-content-between">
    <div>
        <a href="{{ url('/setup/business-settings') }}" class="btn btn-primary">Previous</a>
    </div>

    <div class="d-flex">
        <a href="{{ url('/setup/set-all-mode') }}" id="saveButton" class="btn btn-primary">Save & Continue</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
                var shiftsettingscv = '<?= $shiftSettingsCountValue ?>';
                var attendanceModecountvalue = '<?= $attendanceMode ?>';

            document.getElementById('saveButton').addEventListener('click', function(event) {
                // Your condition to check
                if (shiftsettingscv == 0 || attendanceModecountvalue==0){
                    // Condition is false, show a SweetAlert alert
                    event.preventDefault(); // Prevent the default action (following the link)

                    Swal.fire({
                        icon: 'error',
                        // title: 'Oops...',
                        text: 'Your fields can not be empty!',
                    });
                }
            });
        </script>
{{-- @endif --}}
<script>
    var card = document.getElementById("myCard");

        // Add a click event listener to the card
        card.addEventListener("click", function() {
            // Trigger the modal manually
            var modal = new bootstrap.Modal(document.getElementById("ioModal"));
            modal.show();
        });
</script>

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
                            <p class="m-3">Create Attendance Category to Generate Mode of Attendance </p>

                            <?php //if ($Modes != null){?>
                            <div class="card-header border-0">
                                <h6 class="card-title" style="font-size: 1rem"><b>Office</b></h6>
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" name="premisesActive" onchange="globalCondition()"
                                        id="isOffice" class="custom-switch-input" <?php echo (($Modes->office_auto ?? 0) != 0
                                    || ($Modes->office_manual ?? 0) != 0) ? 'checked' : ''; ?>>
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                            <div class="form-group mx-5">
                                <div class="row">
                                    <div id="officeContent">
                                        <div class="d-flex mt-2">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input"
                                                    onchange="globalCondition()" name="premisesIsAuto" id="officeAuto"
                                                    value="1" <?php echo (($Modes->office_auto ?? 0) != 0) ? 'checked' : '';
                                                ?>>
                                                <span class="custom-control-label">Auto</span>
                                            </label>
                                            &nbsp;&nbsp;
                                            <label class="custom-control custom-radio mx-1">
                                                <input type="radio" class="custom-control-input"
                                                    onchange="globalCondition()" name="premisesIsAuto" id="officeManual"
                                                    value="0" <?php echo (($Modes->office_manual  ?? 0)!= 0) ? 'checked' : '';
                                                ?>>
                                                <span class="custom-control-label">Manual</span>
                                            </label>
                                        </div>

                                        <div class="" id="officeContentMain">
                                            <div class="d-flex">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="premisesQR" id="premisesQR" value="1" <?php echo
                                                        (($Modes->office_qr ?? 0) != 0) ? 'checked' : ''; ?>>
                                                    <span class="custom-control-label"></span>
                                                </label>
                                                <label class="form-label mx-1">Employee Attendance with QR &
                                                    Geo
                                                    Location
                                                    <br> <span class="fs-12 fw-light  text-muted">Employee
                                                        can
                                                        mark
                                                        their
                                                        own attendance with QR, Geo Location Captured
                                                        Automatically</span></label>
                                            </div>

                                            <div class="d-flex">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="premisesFaceId" id="premisesFaceId" value="1" <?php echo
                                                        (($Modes->office_face_id ?? 0) != 0) ? 'checked' : ''; ?>>
                                                    <span class="custom-control-label"></span>
                                                </label>
                                                <label class="form-label mx-1">Employee Attendance with Face
                                                    Id
                                                    &
                                                    Geo
                                                    Location <br> <span class="fs-12 fw-light  text-muted">Employee
                                                        can
                                                        mark
                                                        their own attendance with Scan Face, Geo Location
                                                        Captured
                                                        Automatically</span></label>
                                            </div>
                                            <div class="d-flex">

                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="premisesSelfie" id="premisesSelfie" value="1" <?php echo
                                                        (($Modes->office_selfie ?? 0) != 0) ? 'checked' : ''; ?>>
                                                    <span class="custom-control-label"></span>
                                                </label>
                                                <label class="form-label mx-1">Employee Attendance with
                                                    Selfie
                                                    &
                                                    Geo
                                                    Location <br> <span class="fs-12 fw-light  text-muted">Employee
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
                            </div>
                            {{-- outdoor --}}
                            <div class="card-header border-0">
                                <h6 class="card-title" style="font-size: 1rem"><b>Outdoor</b></h6>
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" name="outDoorActive" onchange="globalCondition()"
                                        id="isOutDoor" class="custom-switch-input" <?php echo (($Modes->outdoor_auto ?? 0) != 0
                                    || ($Modes->outdoor_manual ?? 0) != 0) ? 'checked' : ''; ?>>
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                            <div class="form-group mx-5" id="outdoorcontents">
                                <div class="row">

                                    <div class="" id="">
                                        <div class="d-flex mt-2">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input"
                                                    onchange="globalCondition()" name="outIsAuto" id="outAuto" value="1"
                                                    <?php echo (($Modes->outdoor_auto ?? 0) != 0) ? 'checked' : ''; ?>>
                                                <span class="custom-control-label">Auto</span>
                                            </label>
                                            &nbsp;&nbsp;

                                            <label class="custom-control custom-radio mx-1">
                                                <input type="radio" class="custom-control-input"
                                                    onchange="globalCondition()" name="outIsAuto" id="outManual"
                                                    value="0" <?php echo (($Modes->outdoor_manual ?? 0) != 0) ? 'checked' : '';
                                                ?>>
                                                <span class="custom-control-label">Manual</span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="" id="outdoorcontentmain">
                                        <div class="d-flex">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="outSelfie"
                                                    id="outSelfie" value="1" <?php echo (($Modes->outdoor_selfie ?? 0) != 0) ?
                                                'checked' : '';?>>
                                                <span class="custom-control-label"></span>
                                            </label>
                                            <label class="form-label mx-1">Employee
                                                Attendance
                                                with Selfie & Geo
                                                Location <br> <span class="fs-12 fw-light  text-muted">Employee
                                                    can
                                                    mark
                                                    their own attendance with take a Selfie,
                                                    Geo
                                                    Location
                                                    Captured
                                                    Automatically</span></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- wfh --}}
                            <div class="card-header border-0">
                                <h6 class="card-title" style="font-size: 1rem"><b>WFH</b>
                                </h6>
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" name="wfhActive" onchange="globalCondition()"
                                        class="custom-switch-input" id="isWFH" <?php echo (($Modes->wfh_auto ?? 0) != 0 ||
                                    ($Modes->wfh_manual ?? 0) != 0) ? 'checked' : ''; ?>>
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                            <div class="form-group mx-5" id="isWFHContent">
                                <div class="row">
                                    <div class="d-flex mt-2">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                onchange="globalCondition()" name="wfhIsAuto" id="wfhAuto" value="1"
                                                <?php echo (($Modes->wfh_auto ?? 0) != 0) ? 'checked' : '';?>>
                                            <span class="custom-control-label">Auto</span>
                                        </label>
                                        &nbsp;&nbsp;

                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                onchange="globalCondition()" name="wfhIsAuto" id="wfhManual" value="0"
                                                <?php echo (($Modes->wfh_manual ?? 0) != 0) ? 'checked' : '';?>>
                                            <span class="custom-control-label">Manual</span>
                                        </label>
                                    </div>
                                    <div class="" id="wfhManualContent">
                                        <div class="d-flex">
                                            <label class="custom-control custom-checkbox ">
                                                <input type="checkbox" class="custom-control-input" name="wfhSelfie"
                                                    id="wfhSelfie" value="1" <?php echo (($Modes->wfh_selfie ?? 0) != 0) ?
                                                'checked' : '';?>>
                                                <span class="custom-control-label"></span>
                                            </label>
                                            <label class="form-label mx-1">
                                                Employee
                                                Attendance
                                                with Selfie & Geo
                                                Location <br> <span class="fs-12 fw-light  text-muted">Employee
                                                    can
                                                    mark
                                                    their own attendance with
                                                    take a
                                                    Selfie, Geo
                                                    Location
                                                    Captured
                                                    Automatically</span></label>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php //}?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Close</button>
                    @if (in_array('Attendance Mode.Create', $permissions) || (in_array('Attendance Mode.Update', $permissions)))
                        <button class="btn btn-primary" type="submit" id="savechanges">Save</button>
                    @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

    @if (!in_array('Attendance Mode.Create', $permissions) || (!in_array('Attendance Mode.Update', $permissions)))
        <script>
            var officeCondition = document.getElementById('isOffice');
            var officeContent = document.getElementById('officeContent');
            var officeAuto=document.getElementById('officeAuto');
            var officeManual = document.getElementById('officeManual');
            var officeContentMain=document.getElementById('officeContentMain');
            var premisesQR=document.getElementById('premisesQR');
            var premisesFaceId=document.getElementById('premisesFaceId');
            var premisesSelfie=document.getElementById('premisesSelfie');
            var isOutDoor=document.getElementById('isOutDoor');
            var outAuto=document.getElementById('outAuto');
            var wfhSelfie=document.getElementById('wfhSelfie');
            var outAuto=document.getElementById('outAuto');
            var outManual=document.getElementById('outManual');
            var outSelfie=document.getElementById('outSelfie');
            var isWFH=document.getElementById('isWFH');
            var wfhAuto=document.getElementById('wfhAuto');
            var wfhManual=document.getElementById('wfhManual');

            officeCondition.disabled = true;
            officeContent.disabled = true;
            officeAuto.disabled = true;
            officeManual.disabled = true;
            officeContentMain.disabled = true;
            premisesQR.disabled = true;
            premisesFaceId.disabled = true;
            premisesSelfie.disabled = true;
            wfhSelfie.disabled = true;
            isOutDoor.disabled = true;
            outAuto.disabled = true;
            outManual.disabled = true;
            outSelfie.disabled = true;
            isWFH.disabled = true;
            wfhAuto.disabled = true;
            wfhManual.disabled = true;

        </script>

    @endif
<script>
    function  globalCondition(){
    console.log("active");
    var officeCondition = document.getElementById('isOffice');
    var officeContent = document.getElementById('officeContent');
    var officeAuto=document.getElementById('officeAuto');
    var officeManual = document.getElementById('officeManual');
    var officeContentMain=document.getElementById('officeContentMain');

    // outdoor
    var isOutDoor=document.getElementById('isOutDoor');
    var outDoorContent=document.getElementById('outdoorcontents');
    var outAuto=document.getElementById('outAuto');
    var outManual=document.getElementById('outManual');
    var outdoorcontentmain=document.getElementById('outdoorcontentmain');

    // WFH
    var isWFHContent=document.getElementById('isWFHContent');
    var isWFH=document.getElementById('isWFH');
    var wfhManualContent=document.getElementById('wfhManualContent');
    var wfhAuto=document.getElementById('wfhAuto');
    var wfhManual=document.getElementById('wfhManual');
    if (officeCondition.checked!=false) {
        officeContent.classList.remove("d-none");
        if(officeAuto.checked!=false || officeManual.checked!=false){
            console.log("any check main ");
        officeContentMain.classList.remove("d-none");
        }
    }else{
        officeAuto.checked=false;
        officeManual.checked=false;
        officeContent.classList.add("d-none");
        officeContentMain.classList.add("d-none");
    }

    if(isOutDoor.checked!=false)
    {
        outDoorContent.classList.remove("d-none");
        console.log("Outdoor is here");
        if(outAuto.checked!=false || outManual.checked!=false){
            console.log("any check main ");
            outdoorcontentmain.classList.remove("d-none");
        }
    }
    else {
        outAuto.checked=false;
        outManual.checked=false;
        // setoutdoor
        outdoorcontentmain.classList.add("d-none");
        outDoorContent.classList.add("d-none");
    }

    if(isWFH.checked!=false)
    {
        isWFHContent.classList.remove("d-none");
        console.log("Outdoor is here");
        if(wfhAuto.checked!=false || wfhManual.checked!=false){
            console.log("any check main ");
            wfhManualContent.classList.remove("d-none");
        }
    }
    else {
        isWFH.checked=false;
        wfhAuto.checked=false;
        wfhManual.checked=false;
        // outManual.checked=false;
        // setoutdoor
        wfhManualContent.classList.add("d-none");
        isWFHContent.classList.add("d-none");
    }
  }
</script>

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
<!-- <div class="modal fade" id="ioModal">
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
                                                value="1" <?php echo $Track->track_in_out ?? false ? 'checked' : '';
                                            ?>>
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
                                                class="custom-switch-input" value="1" <?php echo
                                                $Track->no_attendace_without_punch ?? false ? 'checked' : ''; ?>>
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
</div> -->

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
@endif
@endsection
