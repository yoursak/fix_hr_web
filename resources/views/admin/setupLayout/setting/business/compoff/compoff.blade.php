@extends('admin.setupLayout.master')
@section('title', 'Comp-Off & WLOP')
@section('css')

@endsection
@if (in_array('Comp-Off & LWP Policy.View', $permissions))

    @section('content')

        <!-- PAGE HEADER -->

        <!--END PAGE HEADER -->

        <!-- ROW -->
        <div class="row mt-3">
            <div class="col-md-12">
                <form action="{{ route('createCompOff') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header border-0">
                            <h6 class="card-title" style="font-size: 1rem"><b>Comp-Off Leave</b></h6>
                            <label class="custom-switch ms-auto">
                                <input type="checkbox" name="CompOffSwitch" onchange="switchActivationFunc()"
                                    id="CompOffSwitch" class="custom-switch-input"
                                    {{ ($getPolicy->switch ?? 0) == 1 ? 'checked' : '' }}>

                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="form-group mx-5 my-5">
                            <div class="row">
                                <div id="officeContent">
                                    <div class="">
                                        <div class="d-flex mb-3">
                                            <label class="custom-control custom-checkbox">
                                                @php
                                                    // dd($getPolicy);
                                                @endphp
                                                <input type="checkbox" class="custom-control-input" name="HolidaySwitch"
                                                    id="HolidaySwitchBtn" value="1" onchange="switchActivationFunc()"
                                                    {{ ($getPolicy->switch ?? 0) == 1 ? ($getPolicy->holiday_weekly_checked == 1 ? 'checked' : '') : 'disabled' }}>
                                                <span class="custom-control-label"></span>
                                            </label>
                                            <label class="form-label mx-1">Compenstory Off (Comp-Off)<br>
                                                {{-- Holiday or Week-Off  --}}
                                                <span class="fs-12 fw-light  text-muted">As compensation for working on
                                                    holidays
                                                    or weekends, employees will be entitled to take leave on a working
                                                    day.</span>
                                            </label>
                                        </div>

                                        <div class="">
                                            <div class="d-flex">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="LWPLeaveSwitch" id="LWPLeaveSwitchBtn" value="1"
                                                        onchange="switchActivationFunc()"
                                                        {{ ($getPolicy->switch ?? 0) == 1 ? ($getPolicy->lwop_leave_checked == 1 ? 'checked' : '') : 'disabled' }}>
                                                    <span class="custom-control-label"></span>
                                                </label>
                                                <label class="form-label mx-1">Leave Without Pay (LWP)<br>
                                                    <span class="fs-12 fw-light  text-muted">When paid leave is
                                                        insufficient,
                                                        employee attendance will be flagged as LWP. If no leave is
                                                        available,
                                                        direct
                                                        can apply for LWP.</span>
                                                </label>
                                            </div>
                                        </div>
                                        {{-- </div>

                                        </div>
                                    </div> --}}

                                        <div class="d-flex mt-3">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    onchange="switchActivationFunc()" name="OvertimeSwitch"
                                                    id="OvertimeSwitchBtn" value="1"
                                                    {{ ($getPolicy->switch ?? 0) == 1 ? ($getPolicy->overtime_checked == 1 ? 'checked' : '') : 'disabled' }}>
                                                <span class="custom-control-label"></span>
                                            </label>
                                            <label class="form-label mx-1">Ovetime Comp-Off<br>
                                                <span class="fs-12 fw-light  text-muted">An employee will be entitled to
                                                    take
                                                    leave on a working day as compensation for working overtime for <input
                                                        class="mx-1" value="{{ $getPolicy->overtime_hr ?? 0 }}"
                                                        id="compOffOvertime" type="number" placeholder="hr"
                                                        name="overtime_hr" style="width: 3rem; text-align:center;"
                                                        min="0"
                                                        {{ ($getPolicy->overtime_checked ?? 0) == 1 && $getPolicy->overtime_checked == 1 ? '' : 'disabled' }}>
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
                                    $('#HolidaySwitchBtn').prop('checked', true);
                                    $('#LWPLeaveSwitchBtn').prop('checked', true);

                                    $('#HolidaySwitchBtn').prop('disabled', false);
                                    $('#OvertimeSwitchBtn').prop('disabled', false);
                                    $('#LWPLeaveSwitchBtn').prop('disabled', false);
                                    $('#compOffOvertime').prop('disabled', false);
                                }
                                if (CompOffSwitchBtn.checked == false) {
                                    $('#HolidaySwitchBtn').prop('checked', false);
                                    $('#LWPLeaveSwitchBtn').prop('checked', false);

                                    $('#HolidaySwitchBtn').prop('disabled', true);
                                    $('#OvertimeSwitchBtn').prop('disabled', true);
                                    $('#compOffOvertime').prop('disabled', true);
                                    $('#LWPLeaveSwitchBtn').prop('disabled', true);
                                }

                                // if (OvertimeSwitchBtn.checked == true && CompOffSwitchBtn.checked == true) {
                                //     $('#compOffOvertime').prop('disabled', false);
                                // }
                                // if (OvertimeSwitchBtn.checked == false) {
                                //     $('#compOffOvertime').prop('disabled', true);
                                // }
                            }
                        </script>

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
                        <div class="btn-col ms-auto p-2 my-5">
                            <div class="d-flex ms-auto">
                                @if (in_array('Comp-Off & LWP Policy.Create', $permissions) || in_array('Comp-Off & LWP Policy.Create', $permissions))
                                    <button class="btn btn-primary mx-3" type="submit">Save</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ url('/setup/business-settings') }}" class="btn btn-primary">Back</a>
            </div>

            <div class="d-flex">
                {{-- <a href="{{ url('setup/attendance-settings') }}" id="saveButton"  class="btn btn-primary">Save & Continue</a> --}}
            </div>
        </div>

        <!-- END ROW -->
    @endsection

    @section('js')
        {{-- permission cheackinig --}}
        @if (!in_array('Comp-Off & LWP Policy.Create', $permissions) || !in_array('Comp-Off & LWP Policy.Update', $permissions))
            <script>
                var CompOffSwitchBtn = document.getElementById('CompOffSwitch');
                var HolidaySwitchBtn = document.getElementById('HolidaySwitchBtn');
                var OvertimeSwitchBtn = document.getElementById('OvertimeSwitchBtn');
                var OvertimeSwitchInput = document.getElementById('compOffOvertime');
                var LWPLeaveSwitchBtn = document.getElementById('LWPLeaveSwitchBtn');
                CompOffSwitchBtn.disabled = true;
                HolidaySwitchBtn.disabled = true;
                OvertimeSwitchBtn.disabled = true;
                OvertimeSwitchInput.disabled = true;
                LWPLeaveSwitchBtn.disabled = true;
            </script>
        @endif
    @endsection
@endif
