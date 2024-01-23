@extends('admin.pagelayout.master')
@section('title', 'Comp-Off & WLOP')
@section('css')

@endsection
@section('content')

    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('admin/settings/business')}}">Settings</a></li> --}}
            <li><a href="{{ url('admin/settings/business') }}">Business Settings</a></li>
            <li class="active"><span><b>Comp-Off & LWP</b></span></li>
        </ol>
    </div>
    <!-- PAGE HEADER -->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Comp-Off & LWP Policy</div>
        </div>
    </div>
    <!--END PAGE HEADER -->

    <!-- ROW -->
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('createCompOff') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header border-0">
                        <h6 class="card-title" style="font-size: 1rem"><b>Comp-Off Leave</b></h6>
                        <label class="custom-switch ms-auto">
                            <input type="checkbox" name="CompOffSwitch" onchange="switchActivationFunc()" id="CompOffSwitch"
                                class="custom-switch-input" {{($getPolicy->comp_off_switch ?? 0) == 1 ? 'checked' : ''}}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="form-group mx-5 my-5">
                        <div class="row">
                            <div id="officeContent">
                                <div class="">
                                    <div class="d-flex mb-3">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="HolidaySwitch"
                                                id="HolidaySwitchBtn" value="1"  {{($getPolicy->comp_off_switch ?? 0) == 1 ? ($getPolicy->holiday_switch == 1 ? 'checked' : '') : 'disabled'}}>
                                            <span class="custom-control-label"></span>
                                        </label>
                                        <label class="form-label mx-1">Holiday or Week-Off Comp-Off<br>
                                            <span class="fs-12 fw-light  text-muted">As compensation for working on holidays or weekends, employees will be entitled to take leave on a working day.</span>
                                        </label>
                                    </div>

                                    <div class="d-flex mt-3">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="switchActivationFunc()" name="OvertimeSwitch"
                                                id="OvertimeSwitchBtn" value="1" {{($getPolicy->comp_off_switch ?? 0) == 1 ? ($getPolicy->overtime_switch == 1 ? 'checked' : '') : 'disabled'}}>
                                            <span class="custom-control-label"></span>
                                        </label>
                                        <label class="form-label mx-1">Ovetime Comp-Off<br>
                                            <span class="fs-12 fw-light  text-muted">An employee will be entitled to take leave on a working day as compensation for working overtime for  <input class="mx-1" value="{{$getPolicy->overtime_hr ?? 0}}"
                                                    id="compOffOvertime" type="number" placeholder="hr" name="overtime_hr"
                                                    style="width: 3rem; text-align:center;" min="0" {{($getPolicy->comp_off_switch ?? 0) == 1 && $getPolicy->overtime_switch == 1 ? '' : 'disabled'}}>
                                                hrs.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        var CompOffSwitchBtn = document.getElementById('CompOffSwitch');
                        var HolidaySwitchBtn = document.getElementById('HolidaySwitchBtn');
                        var OvertimeSwitchBtn = document.getElementById('OvertimeSwitchBtn');
                        var OvertimeSwitchInput = document.getElementById('compOffOvertime');

                        function switchActivationFunc() {
                            if (CompOffSwitchBtn.checked == true) {
                                $('#HolidaySwitchBtn').prop('disabled', false);
                                $('#OvertimeSwitchBtn').prop('disabled', false);
                            }
                            if (CompOffSwitchBtn.checked == false) {
                                $('#HolidaySwitchBtn').prop('disabled', true);
                                $('#OvertimeSwitchBtn').prop('disabled', true);
                                $('#compOffOvertime').prop('disabled', true);
                            }
                            if (OvertimeSwitchBtn.checked == true && CompOffSwitchBtn.checked == true) {
                                $('#compOffOvertime').prop('disabled', false);
                            }
                            if (OvertimeSwitchBtn.checked == false) {
                                $('#compOffOvertime').prop('disabled', true);
                            }


                        }
                    </script>

                    <div class="card-header border-0">
                        <h6 class="card-title" style="font-size: 1rem"><b>LWP Leave</b></h6>
                        <label class="custom-switch ms-auto">
                            <input type="checkbox" name="LWPSwitch" onchange="switchActivationFunc1()" id="LWPSwitchBtn"
                                class="custom-switch-input" {{($getPolicy->LWP_switch ?? 0) == 1 ? 'checked' : ''}}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="form-group mx-5 my-5">
                        <div class="row">
                            <div id="officeContent">
                                <div class="">
                                    <div class="d-flex">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="LWPLeaveSwitch"
                                                id="LWPLeaveSwitchBtn" value="1"  {{($getPolicy->LWP_switch ?? 0) == 1 ? ($getPolicy->LWP_leave_switch	 == 1 ? 'checked' : '') : 'disabled'}}>
                                            <span class="custom-control-label"></span>
                                        </label>
                                        <label class="form-label mx-1">LWP Leave<br>
                                            <span class="fs-12 fw-light  text-muted">When paid leave is insufficient, employee attendance will be flagged as LWP. If no leave is available, direct can apply for LWP..</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <script>
                        var LWPSwitchButton = document.getElementById('LWPSwitchBtn');
                        var LWPLeaveSwitchButton = document.getElementById('LWPLeaveSwitchBtn');

                        function switchActivationFunc1() {
                            if (LWPSwitchButton.checked == true) {
                                $('#LWPLeaveSwitchBtn').prop('disabled', false);
                            }
                            if (LWPSwitchButton.checked == false) {
                                $('#LWPLeaveSwitchBtn').prop('disabled', true);

                            }


                        }
                    </script>
                    <div class="btn-col ms-auto my-5">
                        <div class="d-flex ms-auto">
                            <a href="#" class="btn btn-danger mx-3">Cancel</a>
                            <button class="btn btn-primary mx-3" type="submit">Save and Continue</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END ROW -->

@endsection

@section('js')

@endsection
