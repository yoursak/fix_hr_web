@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Automation Rule
@endsection
@section('css')
    <style>
        input {
            text-align: center;
        }
    </style>
@endsection
@section('settings')
    <div class=" p-0 pt-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('admin/settings/attendance')}}">Settings</a></li> --}}
            <li><a href="{{ url('admin/settings/attendance') }}">Attendace Setting</a></li>
            <li class="active"><span><b>Automation Rules</b></span></li>
        </ol>
    </div>

    @php
        $lateEntryData;
        $earlyExitData;
        $overtimeData;
        $breakData;
        $missPunchData;
        $gatePassData;

        // dd($missPunchData);

    @endphp
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Automation Rules</div>

            <p class="text-muted">Create rules to automate attemndance</p>

        </div>
        {{-- <div class="page-rightheader ms-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block">
                <div class="btn-list">
                    <a type="button" class="modal-effect btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createAccess">Create Access</a>
                </div>
            </div>
        </div>
    </div> --}}
    </div>
    <form action="{{ route('setAutomationRule') }}" method="post">
        @csrf

        <div class="row row-sm" id="AllContent">

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">
                                    <a class="font-weight-semibold fs-18 ms-3">Late Entry Rule</a>
                                </div>
                                <div class="d-flex">
                                    <label class="custom-switch ms-auto">
                                        <input type="checkbox" name="lateEntry" onchange="showLateEntryContent()"
                                            id="lateEntryBtn" class="custom-switch-input"
                                            {{ $lateEntryData != null && $lateEntryData->switch_is != 0 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the box
                            </p>
                            <div class="my-3" id="lateEntryContent" disabled>
                                <div class="d-flex my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <?php if($lateEntryData != null && ($lateEntryData->grace_time_hr != 0 || $lateEntryData->grace_time_min != 0)){ ?>
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="lateEntryGraceTimefunc()" name="lateEntryGrace"
                                                id="lateEntryGraceBtn" value="1" checked>
                                            <?php }else{ ?>
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="lateEntryGraceTimefunc()" name="lateEntryGrace"
                                                id="lateEntryGraceBtn" value="1">
                                            <?php } ?>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Grace time for late coming</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none"
                                            value="{{ $lateEntryData ? $lateEntryData->grace_time_hr : '' }}:{{ $lateEntryData ? $lateEntryData->grace_time_min : '' }}"
                                            id="lateEntryGraceTime" name="lateEntryGraceTime" type="text"
                                            placeholder="HH:MM" class="text-center"" maxlength="5"
                                            oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                    </div>
                                </div>
                                <script>
                                    function lateEntryGraceTimefunc() {
                                        var lateEntryGraceBtn = document.getElementById('lateEntryGraceBtn');
                                        var lateEntryGraceTime = document.getElementById('lateEntryGraceTime');

                                        if (lateEntryGraceBtn.checked == true) {
                                            lateEntryGraceTime.classList.remove('d-none');
                                        } else {
                                            lateEntryGraceTime.classList.add('d-none');
                                            lateEntryGraceTime.value = '';
                                        }
                                    }
                                </script>

                                <div class="my-1">
                                    <div class="col-12">
                                        <label class="custom-control custom-checkbox">
                                            <?php if(($lateEntryData != null) && $lateEntryData->occurance_is != 0){ ?>
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="lateEntryOccurenceContent()" name="lateEntryOccurence"
                                                id="lateEntryOccurenceBtn" value="1" checked>
                                            <?php }else{ ?>
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="lateEntryOccurenceContent()" name="lateEntryOccurence"
                                                id="lateEntryOccurenceBtn" value="1">
                                            <?php } ?>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurence</label>
                                        </label>
                                    </div>
                                    <div class="d-none col-12" id="lateEntryOccurenceContent">
                                        {{-- <div class="d-flex justify-content-end"> --}}
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-7 text-end">
                                                <select style="width: 5rem; height:1.5rem" id="lateEntrySelectOccurance"
                                                    onchange="countHour()" name="lateEntrySelectOccurance">
                                                    <option value="0"
                                                        {{ $lateEntryData != null && $lateEntryData->occurance_is == '0' ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $lateEntryData != null && $lateEntryData->occurance_is == '1' ? 'selected' : '' }}>
                                                        Count</option>
                                                    <option value="2"
                                                        {{ $lateEntryData != null && $lateEntryData->occurance_is == '2' ? 'selected' : '' }}>
                                                        Hour</option>
                                                </select>
                                            </div>
                                            <div class="col-5 d-flex">
                                                <?php if($lateEntryData != null && $lateEntryData->occurance_count != 0 || null){ ?>
                                                <input class="mb-4 ms-auto"
                                                    value="{{ $lateEntryData ? $lateEntryData->occurance_count : '' }}"
                                                    name="lateEntryOccurenceCount" id="lateEntryOccurenceCount"
                                                    type="text" placeholder="Times" style="width: 5rem; height: 1.5rem">
                                                <?php }else{ ?>
                                                <input class="mb-4 ms-auto d-none"
                                                    value="{{ $lateEntryData != null ? $lateEntryData->occurance_count : '' }}"
                                                    name="lateEntryOccurenceCount" id="lateEntryOccurenceCount"
                                                    type="text" placeholder="Times"
                                                    style="width: 5rem; height: 1.5rem">
                                                <?php } ?>

                                                <?php if($lateEntryData!= null && ($lateEntryData->occurance_hr != 0 || $lateEntryData->occurance_min != 0)){ ?>
                                                <input class="mb-4 ms-auto"
                                                    value="{{ $lateEntryData != null ? $lateEntryData->occurance_hr : '' }}:{{ $lateEntryData != null ? $lateEntryData->occurance_min : '' }}"
                                                    name="lateEntryOccurenceHour" id="lateEntryOccurenceHour"
                                                    type="text" placeholder="HH:MM" class="text-center""
                                                    maxlength="5" oninput="formatTime(this)"
                                                    style="width: 5rem; height: 1.5rem"><?php }else{ ?>
                                                <input class="mb-4 ms-auto d-none"
                                                    value="{{ $lateEntryData != null ? $lateEntryData->occurance_hr : '' }}:{{ $lateEntryData != null ? $lateEntryData->occurance_min : '' }}"
                                                    name="lateEntryOccurenceHour" id="lateEntryOccurenceHour"
                                                    type="text" placeholder="HH:MM" class="text-center"" class
                                                    maxlength="5" oninput="formatTime(this)"
                                                    style="width: 5rem; height: 1.5rem"><?php } ?>
                                            </div>
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>

                                <div class="d-flex my-1">
                                    <div class="col-6">
                                        <label class="custom-control custom-checkbox">
                                            {{-- <input type="checkbox" class="custom-control-input"
                                                onchange="lateEntryDeductionPeriodContent()" name="lateEntryDeduction"
                                                id="lateEntryDeductionBtn" value="1"
                                                {{ $lateEntryData != null && $lateEntryData->absent_is != 0 ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span> --}}
                                            <label class="form-label mx-1">Mark Absent</label>
                                        </label>
                                    </div>
                                    <div class="col-6 d-none" id="lateEntryDeductionPeriodContent">
                                        <div class="row">
                                            <div class="text-end">
                                                <select style="width: 5rem; height:1.5rem" id="lateEntrySelectAbsent"
                                                    name="lateEntrySelectAbsent">
                                                    <option value="0"
                                                        {{ $lateEntryData != null && $lateEntryData->absent_is == '0' ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $lateEntryData != null && $lateEntryData->absent_is == '1' ? 'selected' : '' }}>
                                                        Half Day</option>
                                                    <option value="2"
                                                        {{ $lateEntryData != null && $lateEntryData->absent_is == '2' ? 'selected' : '' }}>
                                                        Full Day</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function lateEntryOccurenceContent() {
                                        var lateEntryOccurenceBtn = document.getElementById('lateEntryOccurenceBtn');
                                        var lateEntryOccurenceContent = document.getElementById('lateEntryOccurenceContent');
                                        var lateEntryOccurenceCount = document.getElementById('lateEntryOccurenceCount');
                                        var lateEntryDeductionBtn = document.getElementById('lateEntryDeductionBtn');
                                        var lateEntryDeductionPeriodContent = document.getElementById('lateEntryDeductionPeriodContent');

                                        if (lateEntryOccurenceBtn.checked == true) {
                                            lateEntryOccurenceContent.classList.remove('d-none');
                                            lateEntryDeductionPeriodContent.classList.remove('d-none');
                                        } else {
                                            lateEntryOccurenceContent.classList.add('d-none');
                                            lateEntryDeductionPeriodContent.classList.add('d-none');
                                            lateEntryOccurenceCount.value = '';
                                        }
                                    }

                                    function countHour() {
                                        var lateEntrySelectOccurance = document.getElementById('lateEntrySelectOccurance');
                                        var lateEntryOccurenceHour = document.getElementById('lateEntryOccurenceHour');
                                        var lateEntryOccurenceCount = document.getElementById('lateEntryOccurenceCount');

                                        // console.log(lateEntryOccurenceCount);

                                        if (lateEntrySelectOccurance.value == 1) {
                                            lateEntryOccurenceCount.classList.remove('d-none');
                                            lateEntryOccurenceHour.classList.add('d-none');
                                            lateEntryOccurenceHour.value = '';
                                        } else if (lateEntrySelectOccurance.value == 2) {
                                            lateEntryOccurenceHour.classList.remove('d-none');
                                            lateEntryOccurenceCount.classList.add('d-none');
                                            lateEntryOccurenceCount.value = '';
                                        } else {
                                            lateEntryOccurenceHour.classList.add('d-none');
                                            lateEntryOccurenceCount.classList.add('d-none');
                                            lateEntryOccurenceHour.value = '';
                                            lateEntryOccurenceCount.value = '';
                                        }
                                    }
                                </script>

                                <script>
                                    function lateEntryDeductionPeriodContent() {
                                        var lateEntryOccurenceBtn = document.getElementById('lateEntryOccurenceBtn');
                                        var lateEntryDeductionPeriodContent = document.getElementById('lateEntryDeductionPeriodContent');

                                        if (lateEntryOccurenceBtn.checked == true) {
                                            lateEntryDeductionPeriodContent.classList.remove('d-none');
                                        } else {
                                            lateEntryDeductionPeriodContent.classList.add('d-none');
                                        }
                                    }
                                </script>

                                <div class="d-flex my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <?php if($lateEntryData != null && ($lateEntryData->mark_half_day_hr != 0 || $lateEntryData->mark_half_day_min != 0)){ ?>
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="lateEntryMarkHalfDayMinutesfunc()" name="lateEntryMarkHalfDay"
                                                id="lateEntryMarkHalfDayBtn" value="1" checked><?php }else{ ?>
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="lateEntryMarkHalfDayMinutesfunc()" name="lateEntryMarkHalfDay"
                                                id="lateEntryMarkHalfDayBtn" value="1"><?php } ?>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Mark Half if late by</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none" name="lateEntryMarkHalfDayMinutes"
                                            id="lateEntryMarkHalfDayMinutes"
                                            value="{{ $lateEntryData ? $lateEntryData->mark_half_day_hr : '' }}:{{ $lateEntryData ? $lateEntryData->mark_half_day_min : '' }}"
                                            type="text" placeholder="HH:MM" class="text-center"" maxlength="5"
                                            oninput="formatTime(this)" min="0"
                                            style="width: 5rem; height: 1.5rem">
                                    </div>
                                </div>

                                <script>
                                    function lateEntryMarkHalfDayMinutesfunc() {
                                        var lateEntryMarkHalfDayBtn = document.getElementById('lateEntryMarkHalfDayBtn');
                                        var lateEntryMarkHalfDayMinutes = document.getElementById('lateEntryMarkHalfDayMinutes');

                                        if (lateEntryMarkHalfDayBtn.checked == true) {
                                            lateEntryMarkHalfDayMinutes.classList.remove('d-none');
                                        } else {
                                            lateEntryMarkHalfDayMinutes.classList.add('d-none');
                                            lateEntryMarkHalfDayMinutes.value = '';
                                        }
                                    }
                                </script>
                            </div>

                            <script>
                                function showLateEntryContent() {
                                    var lateEntryBtn = document.getElementById('lateEntryBtn');
                                    var lateEntryContent = document.getElementById('lateEntryContent');
                                    var lateEntrycheckboxes = lateEntryContent.querySelectorAll('[type="checkbox"]');
                                    var lateEntrySelect = lateEntryContent.querySelectorAll('select');
                                    var lateEntryinputs = lateEntryContent.querySelectorAll('[type="number"]');

                                    // console.log(lateEntrySelect);

                                    if (lateEntryBtn.checked == true) {
                                        lateEntryenableFields(lateEntrycheckboxes);
                                        lateEntryenableFields(lateEntrySelect);
                                        lateEntryenableFields(lateEntryinputs);
                                    } else {
                                        lateEntrydisableFields(lateEntrycheckboxes);
                                        lateEntryUnSelect(lateEntrySelect);
                                        lateEntrydisableFields(lateEntrySelect);
                                        lateEntrydisableFields(lateEntryinputs);
                                        lateEntrydEmpty(lateEntrycheckboxes);
                                    }

                                    lateEntryMarkHalfDayMinutesfunc();
                                    lateEntryDeductionPeriodContent();
                                    lateEntryOccurenceContent();
                                    lateEntryGraceTimefunc();

                                    var switchBtn = lateEntryBtn.checked;
                                    $.ajax({
                                        url: "{{ url('admin/settings/attendance/automation/set') }}",
                                        type: "POST",
                                        data: {
                                            dataLateEntry: switchBtn,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        dataType: 'json',
                                        success: function(result) {
                                            console.log(result);

                                        }
                                    });

                                }

                                function lateEntryUnSelect(elements) {
                                    for (var i = 0; i < elements.length; i++) {
                                        elements[i].selectedIndex = 0;
                                    }
                                }

                                function lateEntryenableFields(elements) {
                                    elements.forEach(element => {
                                        element.disabled = false;
                                    });
                                }

                                function lateEntrydisableFields(elements) {
                                    elements.forEach(element => {
                                        element.disabled = true;
                                    });
                                }

                                function lateEntrydEmpty(element) {
                                    element.forEach(element => {
                                        element.checked = false;
                                    });
                                }

                                showLateEntryContent();
                            </script>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    {{-- Early exit rule  --}}
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">
                                    <a class="font-weight-semibold fs-18 ms-3">Early Exit Rule</a>
                                </div>
                                <div class="d-flex">
                                    <label class="custom-switch ms-auto">
                                        <?php if($earlyExitData != null && $earlyExitData->switch_is !=0){ ?>
                                        <input type="checkbox" onchange="earlyExitContent()" name="earlyExitBtn"
                                            onchange="" id="earlyExitBtn" class="custom-switch-input"
                                            checked><?php }else{ ?>
                                        <input type="checkbox" onchange="earlyExitContent()" name="earlyExitBtn"
                                            onchange="" id="earlyExitBtn"
                                            class="custom-switch-input"><?php } ?>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the box
                            </p>

                            <div class="my-3" id="earlyExitContent">
                                <div class="d-flex my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="graceTimefunc()"
                                                class="custom-control-input" name="graceTimeBtn" id="graceTimeBtn"
                                                value="1"
                                                {{ $earlyExitData != null && ($earlyExitData->grace_time_hr != 0 || $earlyExitData->grace_time_min != 0) ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Grace time for early exit</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none"
                                            value="{{ $earlyExitData ? $earlyExitData->grace_time_hr : '' }}:{{ $earlyExitData ? $earlyExitData->grace_time_min : '' }}"
                                            name="graceTime" id="graceTime" type="text" placeholder="HH:MM"
                                            class="text-center" maxlength="5" oninput="formatTime(this)"
                                            style="width: 5rem; height: 1.5rem">
                                    </div>
                                </div>

                                <script>
                                    function graceTimefunc() {
                                        var graceTimeBtn = document.getElementById('graceTimeBtn');
                                        var graceTime = document.getElementById('graceTime');

                                        // alert('hello');
                                        if (graceTimeBtn.checked == true) {
                                            graceTime.classList.remove('d-none');
                                        } else {
                                            graceTime.classList.add('d-none');
                                            graceTime.value = '';
                                        }
                                    }
                                </script>

                                <div class="my-1">
                                    <div class="col-12">
                                        <label class="custom-control custom-checkbox">
                                            <?php if(($earlyExitData != null) && $earlyExitData->occurance_is != 0){ ?>
                                            <input type="checkbox" onchange="earlyExitOccurenceContent()"
                                                class="custom-control-input" name="earlyExitOccurence"
                                                id="earlyExitOccurenceBtn" value="1" checked><?php }else{ ?>
                                            <input type="checkbox" onchange="earlyExitOccurenceContent()"
                                                class="custom-control-input" name="earlyExitOccurence"
                                                id="earlyExitOccurenceBtn" value="1"><?php } ?>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurence</label>
                                        </label>
                                    </div>
                                    <div class="col-12 d-none" id="earlyExitOccurenceContent">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-7 text-end">
                                                <select onchange="earlyExitcountHour()" style="width: 5rem; height:1.5rem"
                                                    id="earlyExitSelectOccurence" name="earlyExitSelectOccurence">
                                                    <option value="0"
                                                        {{ $earlyExitData != null && $earlyExitData->occurance_is == '0' ? 'selected' : 0 }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $earlyExitData != null && $earlyExitData->occurance_is == '1' ? 'selected' : 0 }}>
                                                        Count</option>
                                                    <option value="2"
                                                        {{ $earlyExitData != null && $earlyExitData->occurance_is == '2' ? 'selected' : 0 }}>
                                                        Hour</option>
                                                </select>
                                            </div>
                                            <div class="col-5 d-flex">
                                                <?php if(($earlyExitData != null) && $earlyExitData->occurance_is == 1){ ?>
                                                <input class="mb-4 ms-auto"
                                                    value="{{ $earlyExitData ? $earlyExitData->occurance_count : '' }}"
                                                    name="earlyExitOccurenceCount" id="earlyExitOccurenceCount"
                                                    placeholder="Times" type="number" min="0"
                                                    style="width: 5rem; height: 1.5rem"><?php }else{ ?>
                                                <input class="mb-4 ms-auto d-none"
                                                    value="{{ $earlyExitData ? $earlyExitData->occurance_count : '' }}"
                                                    name="earlyExitOccurenceCount" id="earlyExitOccurenceCount"
                                                    placeholder="Times" type="number" min="0"
                                                    style="width: 5rem; height: 1.5rem"><?php } ?>

                                                <?php if(($earlyExitData != null) && $earlyExitData->occurance_is == 2){ ?>
                                                <input class="mb-4 ms-auto "
                                                    value="{{ $earlyExitData->occurance_hr }}:{{ $earlyExitData->occurance_min }}"
                                                    name="earlyExitOccurenceHour" id="earlyExitOccurenceHour"
                                                    type="text" placeholder="HH:MM" class="text-center""
                                                    maxlength="5" oninput="formatTime(this)"
                                                    style="width: 5rem; height: 1.5rem"><?php }else{ ?>
                                                <input class="mb-4 ms-auto d-none"
                                                    value="{{ $earlyExitData ? $earlyExitData->occurance_hr : '' }}:{{ $earlyExitData ? $earlyExitData->occurance_min : '' }}"
                                                    name="earlyExitOccurenceHour" id="earlyExitOccurenceHour"
                                                    type="text" placeholder="HH:MM" class="text-center""
                                                    maxlength="5" oninput="formatTime(this)"
                                                    style="width: 5rem; height: 1.5rem"><?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex my-1">
                                    <div class="col-6">
                                        <label class="custom-control custom-checkbox">
                                            {{-- <input type="checkbox" onchange="earlyExitDeductionPeriodContent()"
                                                class="custom-control-input" name="earlyExitDeduction"
                                                id="earlyExitDeductionBtn" value="1" {{($earlyExitData != null) && $earlyExitData->absent_is != 0 ? 'checked' : ''}} >
                                            <span class="custom-control-label"></span> --}}
                                            <label class="form-label mx-1">Mark Absent</label>
                                        </label>
                                    </div>
                                    <div class="col-6 d-none" id="earlyExitDeductionPeriodContentId">
                                        <div class="row">
                                            <div class="text-end">
                                                <select style="width: 5rem; height:1.5rem" id="earlyExitSelectAbsent"
                                                    name="earlyExitSelectAbsent">
                                                    <option value="0"
                                                        {{ $earlyExitData != null && $earlyExitData->absent_is == '0' ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $earlyExitData != null && $earlyExitData->absent_is == '1' ? 'selected' : '' }}>
                                                        Half Day</option>
                                                    <option value="2"
                                                        {{ $earlyExitData != null && $earlyExitData->absent_is == '2' ? 'selected' : '' }}>
                                                        Full Day</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function earlyExitOccurenceContent() {
                                        var earlyExitOccurenceBtn = document.getElementById('earlyExitOccurenceBtn');
                                        var earlyExitOccurenceContent = document.getElementById('earlyExitOccurenceContent');
                                        var earlyExitOccurenceCount = document.getElementById('earlyExitOccurenceCount');
                                        var earlyExitDeductionPeriodContentid = document.getElementById('earlyExitDeductionPeriodContentId');

                                        // alert('hello');
                                        if (earlyExitOccurenceBtn.checked == true) {
                                            earlyExitOccurenceContent.classList.remove('d-none');
                                            earlyExitDeductionPeriodContentid.classList.remove('d-none');
                                        } else {
                                            earlyExitOccurenceContent.classList.add('d-none');
                                            earlyExitDeductionPeriodContentid.classList.add('d-none');
                                            earlyExitOccurenceCount.value = '';
                                        }
                                    }

                                    function earlyExitcountHour() {
                                        // <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour" id="lateEntryOccurenceHour" type="text" placeholder="HH:MM" class="text-center"" maxlength="5" oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                        var earlyExitSelectOccurence = document.getElementById('earlyExitSelectOccurence');
                                        var earlyExitOccurenceHour = document.getElementById('earlyExitOccurenceHour');
                                        var earlyExitOccurenceCount = document.getElementById('earlyExitOccurenceCount');
                                        // console.log(earlyExitOccurenceCount);

                                        if (earlyExitSelectOccurence.value == 1) {
                                            earlyExitOccurenceCount.classList.remove('d-none');
                                            earlyExitOccurenceHour.classList.add('d-none');
                                            earlyExitOccurenceHour.value = '';
                                        } else if (earlyExitSelectOccurence.value == 2) {
                                            earlyExitOccurenceHour.classList.remove('d-none');
                                            earlyExitOccurenceCount.classList.add('d-none');
                                            earlyExitOccurenceCount.value = '';
                                        } else {
                                            earlyExitOccurenceHour.classList.add('d-none');
                                            earlyExitOccurenceCount.classList.add('d-none');
                                            earlyExitOccurenceHour.value = '';
                                            earlyExitOccurenceCount.value = '';
                                        }
                                    }
                                </script>

                                <script>
                                    function earlyExitDeductionPeriodContent() {
                                        var earlyExitOccurenceBtn = document.getElementById('earlyExitOccurenceBtn');
                                        // var earlyExitDeductionBtn = document.getElementById('earlyExitDeductionBtn');
                                        var earlyExitDeductionPeriodContentid = document.getElementById('earlyExitDeductionPeriodContentId');

                                        if (earlyExitOccurenceBtn.checked == true) {
                                            // alert('hello');
                                            earlyExitDeductionPeriodContentid.classList.remove('d-none');
                                        } else {
                                            earlyExitDeductionPeriodContentid.classList.add('d-none');
                                        }
                                    }
                                </script>

                                <div class="d-flex my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <?php if(($earlyExitData != null) && ($earlyExitData->mark_half_day_hr != 0 || $earlyExitData->mark_half_day_min != 0)){ ?>
                                            <input type="checkbox" onchange="earlyExitByBtnfunc()"
                                                class="custom-control-input" name="exitMarkHalfDay"
                                                id="exitMarkHalfDayBtn" value="1" checked><?php }else{ ?>
                                            <input type="checkbox" onchange="earlyExitByBtnfunc()"
                                                class="custom-control-input" name="exitMarkHalfDay"
                                                id="exitMarkHalfDayBtn" value="1"><?php } ?>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Mark Half if early going:</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <?php //dd($earlyExitData->mark_half_day_hr);
                                        ?>

                                        <input class="mb-4 d-none"
                                            value="<?= $earlyExitData != null && ($earlyExitData->mark_half_day_hr != 0 || $earlyExitData->mark_half_day_min != 0) ? "$earlyExitData->mark_half_day_hr:$earlyExitData->mark_half_day_min"
                                        : '' ?>"
                                        name="earlyExitBy" id="earlyExitByBtn" type="text" placeholder="HH:MM"
                                        class="text-center" maxlength="5" oninput="formatTime(this)"
                                        style="width: 5rem; height: 1.5rem">
                                    </div>
                                </div>

                                <script>
                                    function earlyExitByBtnfunc() {
                                        var exitMarkHalfDayBtn = document.getElementById('exitMarkHalfDayBtn');
                                        var earlyExitByBtn = document.getElementById('earlyExitByBtn');

                                        // alert('hello');
                                        if (exitMarkHalfDayBtn.checked == true) {
                                            earlyExitByBtn.classList.remove('d-none');
                                        } else {
                                            earlyExitByBtn.classList.add('d-none');
                                            earlyExitByBtn.value = '';
                                        }
                                    }
                                </script>

                            </div>
                        </div>
                    </div>

                    <script>
                        function earlyExitContent() {
                            var earlyExitBtn = document.getElementById('earlyExitBtn');
                            var earlyExitContent = document.getElementById('earlyExitContent');
                            var earlyExitContentCheckbox = earlyExitContent.querySelectorAll('[type="checkbox"]');
                            var earlyExitContentSelect = earlyExitContent.querySelectorAll('select');
                            var earlyExitContentInput = earlyExitContent.querySelectorAll('[type="number"]');

                            // console.log(breakContentcheckboxes);
                            if (earlyExitBtn.checked == true) {
                                earlyExitenableFields(earlyExitContentCheckbox);
                                earlyExitenableFields(earlyExitContentSelect);
                                earlyExitenableFields(earlyExitContentInput);
                            } else {
                                earlyExitEmpty(earlyExitContentCheckbox);
                                earlyExitdisableFields(earlyExitContentCheckbox);
                                earlyExitUnSelect(earlyExitContentSelect);
                                earlyExitdisableFields(earlyExitContentSelect);
                                earlyExitdisableFields(earlyExitContentInput);
                            }

                            earlyExitByBtnfunc();
                            earlyExitDeductionPeriodContent();
                            earlyExitOccurenceContent();
                            graceTimefunc();

                            var switchBtn = earlyExitBtn.checked;
                            $.ajax({
                                url: "{{ url('admin/settings/attendance/automation/set') }}",
                                type: "POST",
                                data: {
                                    earlyExitSwitch: switchBtn,
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: 'json',
                                success: function(result) {
                                    console.log(result);

                                }
                            });
                        }

                        function earlyExitUnSelect(elements) {
                            for (var i = 0; i < elements.length; i++) {
                                elements[i].selectedIndex = 0;
                            }
                        }

                        function earlyExitenableFields(elements) {
                            elements.forEach(element => {
                                element.disabled = false;
                            });
                        }

                        function earlyExitdisableFields(elements) {
                            elements.forEach(element => {
                                element.disabled = true;
                            });
                        }

                        function earlyExitEmpty(element) {
                            element.forEach(element => {
                                element.checked = false;
                            });
                        }

                        earlyExitContent()
                    </script>
                </div>
            </div>

            {{-- <div class="col-xl-4">
                <div class="card">
                    
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">
                                    <a class="font-weight-semibold fs-18 ms-3">Break Rule</a>
                                </div>
                                <div class="d-flex my-auto">
                                    <label class="custom-switch ms-auto">
                                        <input type="checkbox" name="breakBtn" onchange="breakContent()" id="breakBtn"
                                            class="custom-switch-input" {{ $breakData != null && $breakData->switch_is !=0 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the box
                            </p>

                            <div class="my-3" id="breakContent">
                                

                                <div class="d-flex my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                onChange="extraTimeForBreakBtnfunc()" id="extraBreakTimeBtn"
                                                value="1"
                                                {{ $breakData != null && ($breakData->break_extra_hr != 0 || $breakData->break_extra_min != 0) ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Extra time for break </label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <?php //dd($breakData->break_extra_hr);
                                        ?>
                                        <input class="mb-4 d-none"
                                            value="<?= $breakData != null ? $breakData->break_extra_hr . ' : ' . $breakData->break_extra_min : '' ?>"
                                            id="extraTimeForBreakBtn" name="extraBreakTime" type="text"
                                            placeholder="HH:MM" class="text-center" maxlength="5"
                                            oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                    </div>

                                    <script>
                                        function extraTimeForBreakBtnfunc() {
                                            var extraBreakTimeBtn = document.getElementById('extraBreakTimeBtn');
                                            var extraTimeForBreakBtn = document.getElementById('extraTimeForBreakBtn');

                                            if (extraBreakTimeBtn.checked == true) {
                                                console.log(extraTimeForBreakBtn);
                                                extraTimeForBreakBtn.classList.remove('d-none');
                                            } else {
                                                extraTimeForBreakBtn.classList.add('d-none');
                                                extraTimeForBreakBtn.value = '';
                                            }
                                        }
                                    </script>
                                </div>

                                <div class="my-1">
                                    <div class="col-12">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="breakOccurenceContent()"
                                                class="custom-control-input" name="breakOccurence" id="breakOccurenceBtn"
                                                value="1"
                                                {{ $breakData != null && $breakData->occurance_is != 0 ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurence </label>
                                        </label>
                                    </div>
                                    <div class="col-12 d-none" id="breakOccurenceContent">
                                        <div class="row d-flex- justify-content-around">
                                            <div class="col-7 text-end">
                                                <select onchange="breakCountHour()" style="width: 5rem; height:1.5rem"
                                                    id="breakSelectOccurence" name="breakSelectOccurence">
                                                    <option value="0"
                                                        {{ $breakData != null && $breakData->occurance_is == 0 ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $breakData != null && $breakData->occurance_is == 1 ? 'selected' : '' }}>
                                                        Count</option>
                                                    <option value="2"
                                                        {{ $breakData != null && $breakData->occurance_is == 2 ? 'selected' : '' }}>
                                                        Hour</option>
                                                </select>
                                            </div>
                                            <div class="col-5 d-flex">
                                                <input
                                                    class="mb-4 ms-auto {{ $breakData != null && $breakData->occurance_is == 1 ? '' : 'd-none' }}"
                                                    value="{{ $breakData ? $breakData->occurance_count : '' }}"
                                                    name="breakOccurenceCount" id="breakOccurenceCount"
                                                    placeholder="Times" type="number" min="0"
                                                    style="width: 5rem; height: 1.5rem">
                                                <input
                                                    class="mb-4 ms-auto {{ $breakData != null && $breakData->occurance_is == 2 ? '' : 'd-none' }}"
                                                    value="{{ $breakData ? $breakData->occurance_hr : '' }}:{{ $breakData ? $breakData->occurance_min : '' }}"
                                                    name="breakOccurenceHour" id="breakOccurenceHour" type="text"
                                                    placeholder="HH:MM" class="text-center"" maxlength="5"
                                                    oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function breakCountHour() {
                                            // <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour" id="lateEntryOccurenceHour" type="text" placeholder="HH:MM" class="text-center"" maxlength="5" oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                            var breakSelectOccurence = document.getElementById('breakSelectOccurence');
                                            var breakOccurenceHour = document.getElementById('breakOccurenceHour');
                                            var breakOccurenceCount = document.getElementById('breakOccurenceCount');
                                            // console.log(breakOccurenceCount);

                                            if (breakSelectOccurence.value == 1) {
                                                breakOccurenceCount.classList.remove('d-none');
                                                breakOccurenceHour.classList.add('d-none');
                                                breakOccurenceHour.value = '';
                                            } else if (breakSelectOccurence.value == 2) {
                                                breakOccurenceHour.classList.remove('d-none');
                                                breakOccurenceCount.classList.add('d-none');
                                                breakOccurenceCount.value = '';
                                            } else {
                                                breakOccurenceHour.classList.add('d-none');
                                                breakOccurenceCount.classList.add('d-none');
                                                breakOccurenceHour.value = '';
                                                breakOccurenceCount.value = '';
                                            }
                                        }


                                        function breakOccurenceContent() {
                                            var breakOccurenceBtn = document.getElementById('breakOccurenceBtn');
                                            var breakOccurenceContent = document.getElementById('breakOccurenceContent');
                                            var breakOccurenceCount = document.getElementById('breakOccurenceCount');

                                            if (breakOccurenceBtn.checked == true) {
                                                breakOccurenceContent.classList.remove('d-none');
                                            } else {
                                                breakOccurenceContent.classList.add('d-none');
                                                breakOccurenceCount.value = '';
                                            }
                                        }
                                    </script>
                                </div>
                                <div class="d-flex my-1">
                                    <div class="col-6">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="breakDeductionPeriodContent()"
                                                class="custom-control-input" name="breakDeductSalary"
                                                id="breakDeductSalaryBtn" value="1"
                                                {{ $breakData != null && $breakData->absent_is != 0 ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Mark Absent</label>
                                        </label>
                                    </div>
                                    <div class="col-6 d-none" id="breakDeductionPeriodContent">
                                        <div class="row">
                                            <div class="text-end">
                                                <select style="width: 5rem; height:1.5rem" id="breakSelectAbsent"
                                                    name="breakSelectAbsent">
                                                    <option value="0"
                                                        {{ $breakData != null && $breakData->absent_is == 0 ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $breakData != null && $breakData->absent_is == 1 ? 'selected' : '' }}>
                                                        Half Day</option>
                                                    <option value="2"
                                                        {{ $breakData != null && $breakData->absent_is == 2 ? 'selected' : '' }}>
                                                        Full Day</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function breakDeductionPeriodContent() {
                                            var breakDeductSalaryBtn = document.getElementById('breakDeductSalaryBtn');
                                            var breakDeductionPeriodContent = document.getElementById('breakDeductionPeriodContent');

                                            if (breakDeductSalaryBtn.checked == true) {
                                                breakDeductionPeriodContent.classList.remove('d-none');
                                            } else {
                                                breakDeductionPeriodContent.classList.add('d-none');
                                            }
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function breakContent() {
                            var breakBtn = document.getElementById('breakBtn');
                            var breakContent = document.getElementById('breakContent');
                            var breakContentCheckboxes = breakContent.querySelectorAll('[type="checkbox"]');
                            var breakContentSelect = breakContent.querySelectorAll('select');
                            var breakContentInput = breakContent.querySelectorAll('[type="number"]');

                            // console.log(breakContentcheckboxes);
                            if (breakBtn.checked == true) {
                                breakenableFields(breakContentCheckboxes);
                                breakenableFields(breakContentSelect);
                                breakenableFields(breakContentInput);
                            } else {
                                breakdisableFields(breakContentCheckboxes);
                                breakUnSelect(breakContentSelect);
                                breakdisableFields(breakContentSelect);
                                breakdisableFields(breakContentInput);
                                breakEmpty(breakContentCheckboxes);
                            }

                            breakDeductionPeriodContent();
                            breakOccurenceContent();
                            extraTimeForBreakBtnfunc();

                            var switchBtn = breakBtn.checked;
                            $.ajax({
                                url: "{{ url('admin/settings/attendance/automation/set') }}",
                                type: "POST",
                                data: {
                                    breakSwitch: switchBtn,
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: 'json',
                                success: function(result) {
                                    console.log(result);

                                }
                            });
                        }

                        function breakUnSelect(elements) {
                            for (var i = 0; i < elements.length; i++) {
                                elements[i].selectedIndex = 0;
                            }
                        }

                        function breakenableFields(elements) {
                            elements.forEach(element => {
                                element.disabled = false;
                            });
                        }

                        function breakdisableFields(elements) {
                            elements.forEach(element => {
                                element.disabled = true;
                            });
                        }

                        function breakEmpty(element) {
                            element.forEach(element => {
                                element.checked = false;
                            });
                        }
                        breakContent();
                    </script>
                </div>
            </div> --}}

            <div class="col-xl-4">
                <div class="card">
                    {{-- Overtime Rule  --}}
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">
                                    <a class="font-weight-semibold fs-18 ms-3">Overtime Rule</a>
                                </div>
                                <div class="d-flex my-auto">
                                    <label class="custom-switch ms-auto">
                                        <input type="checkbox" onchange="overtimeContent()" name="overtime"
                                            id="overtimeBtn" class="custom-switch-input"
                                            {{ $overtimeData != null && $overtimeData->switch_is != 0 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the box
                            </p>

                            <div class="my-3" id="overtimeContent">

                                <div class="d-flex my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="earlyOverTimefunc()" name="allowEarlyOverTime"
                                                id="allowEarlyOverTimeBtn" value="1"
                                                {{ $overtimeData != null && ($overtimeData->early_ot_hr != 0 || $overtimeData->early_ot_min != 0) ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Allow Overtime for early comming</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none"
                                            value="{{ $overtimeData ? $overtimeData->early_ot_hr : '' }}:{{ $overtimeData ? $overtimeData->early_ot_min : '' }}"
                                            name="earlyOverTime" id="earlyOverTimeBtn" type="text"
                                            placeholder="HH:MM" class="text-center"" maxlength="5"
                                            oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                    </div>
                                </div>

                                <script>
                                    function earlyOverTimefunc() {
                                        var allowEarlyOverTimeBtn = document.getElementById('allowEarlyOverTimeBtn');
                                        var earlyOverTimeBtn = document.getElementById('earlyOverTimeBtn');

                                        // alert('hello');
                                        if (allowEarlyOverTimeBtn.checked == true) {
                                            earlyOverTimeBtn.classList.remove('d-none');
                                        } else {
                                            earlyOverTimeBtn.classList.add('d-none');
                                            earlyOverTimeBtn.value = '';
                                        }
                                    }
                                </script>

                                <div class="d-flex my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="lateOverTimefunc()"
                                                class="custom-control-input" name="allowLateOverTime"
                                                id="allowLateOverTimeBtn" value="1"
                                                {{ $overtimeData != null && ($overtimeData->late_ot_hr != 0 || $overtimeData->late_ot_min != 0) ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Allow Overtime for late going</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none"
                                            value="{{ $overtimeData ? $overtimeData->late_ot_hr : '' }}:{{ $overtimeData ? $overtimeData->late_ot_min : '' }}"
                                            name="lateOverTime" id="lateOverTimeBtn" type="text" placeholder="HH:MM"
                                            class="text-center"" maxlength="5" oninput="formatTime(this)"
                                            style="width: 5rem; height: 1.5rem">
                                    </div>
                                </div>

                                <script>
                                    function lateOverTimefunc() {
                                        var allowLateOverTimeBtn = document.getElementById('allowLateOverTimeBtn');
                                        var lateOverTimeBtn = document.getElementById('lateOverTimeBtn');

                                        // alert('hello');
                                        if (allowLateOverTimeBtn.checked == true) {
                                            lateOverTimeBtn.classList.remove('d-none');
                                        } else {
                                            lateOverTimeBtn.classList.add('d-none');
                                            lateOverTimeBtn.value = '';
                                        }
                                    }
                                </script>

                                <div class="my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="minMaxOverTimeBtnContent()"
                                                class="custom-control-input" name="minMaxOverTime" id="minMaxOverTimeBtn"
                                                value="1"
                                                {{ $overtimeData != null && ($overtimeData->min_ot_hr != 0 || $overtimeData->min_ot_min != 0 || $overtimeData->max_ot_hr != 0 || $overtimeData->max_ot_min != 0) ? 'checked' : '' }}>

                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Allow Overtime</label>
                                        </label>
                                    </div>
                                    <div class="d-none" id="minMaxOverTimeBtnContent">
                                        <div class="d-flex justify-content-center my-1">
                                            <div class="mx-2">
                                                <label class="form-label mx-1" hidden>Min</label>
                                                <input class="mb-4"
                                                    value="{{ $overtimeData ? $overtimeData->min_ot_hr : '' }}: {{ $overtimeData ? $overtimeData->min_ot_min : '' }}"
                                                    name="minOverTime" id="minOverTimeBtn" type="text"
                                                    placeholder="HH:MM" class="text-center"" maxlength="5"
                                                    oninput="formatTime(this)" style="width: 5rem; height: 1.5rem" hidden>
                                            </div>
                                            <div class="mx-2">
                                                <label class="form-label mx-1">Max</label>
                                                <input class="mb-4"
                                                    value="{{ $overtimeData ? $overtimeData->max_ot_hr : '' }}:{{ $overtimeData ? $overtimeData->max_ot_min : '' }}"
                                                    name="maxOverTime" id="maxOverTimeBtn" type="text"
                                                    placeholder="HH:MM" class="text-center"" maxlength="5"
                                                    oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function minMaxOverTimeBtnContent() {
                                        var minMaxOverTimeBtn = document.getElementById('minMaxOverTimeBtn');
                                        var minMaxOverTimeBtnContent = document.getElementById('minMaxOverTimeBtnContent');
                                        var minOverTimeBtn = document.getElementById('minOverTimeBtn');
                                        var maxOverTimeBtn = document.getElementById('maxOverTimeBtn');

                                        // alert('hello');
                                        if (minMaxOverTimeBtn.checked == true) {
                                            minMaxOverTimeBtnContent.classList.remove('d-none');
                                        } else {
                                            minMaxOverTimeBtnContent.classList.add('d-none');
                                            minOverTimeBtn.value = '';
                                            maxOverTimeBtn.value = '';
                                        }
                                    }
                                </script>
                            </div>

                        </div>
                    </div>

                    <script>
                        function overtimeContent() {
                            var overtimeBtn = document.getElementById('overtimeBtn');
                            var overtimeContent = document.getElementById('overtimeContent');
                            var overtimeContentCheckbox = overtimeContent.querySelectorAll('[type="checkbox"]');
                            var overtimeContentSelect = overtimeContent.querySelectorAll('select');
                            var overtimeContentInput = overtimeContent.querySelectorAll('[type="number"]');

                            // console.log(breakContentcheckboxes);
                            if (overtimeBtn.checked == true) {
                                overtimeenableFields(overtimeContentCheckbox);
                                overtimeenableFields(overtimeContentSelect);
                                overtimeenableFields(overtimeContentInput);
                            } else {
                                overtimeEmpty(overtimeContentCheckbox);
                                overtimedisableFields(overtimeContentCheckbox);
                                overtimedisableFields(overtimeContentSelect);
                                overtimeUnSelect(overtimeContentSelect);
                                overtimedisableFields(overtimeContentInput);
                            }

                            minMaxOverTimeBtnContent();
                            lateOverTimefunc();
                            earlyOverTimefunc();

                            var switchBtn = overtimeBtn.checked;
                            $.ajax({
                                url: "{{ url('admin/settings/attendance/automation/set') }}",
                                type: "POST",
                                data: {
                                    overtimeSwitch: switchBtn,
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: 'json',
                                success: function(result) {
                                    console.log(result);

                                }
                            });
                        }

                        function overtimeUnSelect(elements) {
                            for (var i = 0; i < elements.length; i++) {
                                elements[i].selectedIndex = 0;
                            }
                        }

                        function overtimeenableFields(elements) {
                            elements.forEach(element => {
                                element.disabled = false;
                            });
                        }

                        function overtimedisableFields(elements) {
                            elements.forEach(element => {
                                element.disabled = true;
                            });
                        }

                        function overtimeEmpty(element) {
                            element.forEach(element => {
                                element.checked = false;
                            });
                        }

                        overtimeContent();
                    </script>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    {{-- Miss Punch Rule  --}}
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">
                                    <a class="font-weight-semibold fs-18 ms-3">Miss Punch Rule</a>
                                </div>
                                <div class="d-flex my-auto">
                                    <label class="custom-switch ms-auto">
                                        <input type="checkbox" onchange="missPunchContent()" name="missPunch"
                                            onchange="" id="missPunchBtn" class="custom-switch-input"
                                            {{ $missPunchData != null && $missPunchData->switch_is != 0 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of
                                the
                                box
                            </p>

                            <div class="my-3" id="missPunchContent">
                                <div class="my-1 d-flex">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="missPunchOccurenceContent()"
                                                class="custom-control-input" name="missPunchOccurence"
                                                id="missPunchOccurenceBtn" value="1"
                                                {{ $missPunchData->occurance_count != null ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurence</label>
                                        </label>
                                    </div>
                                    <div class="col-4 text-end d-none" id="missPunchOccurenceContent">
                                        {{-- <div class="row d-flex justify-content-around"> --}}
                                        {{-- <div class="col-7 text-end"> --}}
                                        {{-- <select onchange="missPunchCountHour()" style="width: 5rem; height:1.5rem"
                                                    id="missPunchSelectOccurence" name="missPunchSelectOccurence">
                                                    <option value="0"
                                                        {{ $missPunchData != null && $missPunchData->occurance_is == 0 ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $missPunchData != null && $missPunchData->occurance_is == 1 ? 'selected' : '' }}>
                                                        Count</option>
                                                    <option value="2"
                                                        {{ $missPunchData != null && $missPunchData->occurance_is == 2 ? 'selected' : '' }}>
                                                        Hour</option>
                                                </select> --}}
                                        {{-- </div> --}}
                                        {{-- <div class="col-5 d-flex"> --}}
                                        <input class="mb-4 mr-auto"
                                            value="{{ $missPunchData ? $missPunchData->occurance_count : '' }}"
                                            name="missPunchOccurenceCount" id="missPunchOccurenceCount"
                                            placeholder="Times" type="number" min="0"
                                            style="width: 5rem; height: 1.5rem">
                                        {{-- <input
                                                    class="mb-4 ms-auto {{ $missPunchData != null && $missPunchData->occurance_is == 2 ? '' : 'd-none' }}"
                                                    value="{{ $missPunchData ? $missPunchData->occurance_hr : '' }}:{{ $missPunchData ? $missPunchData->occurance_min : '' }}"
                                                    name="missPunchOccurenceHour" id="missPunchOccurenceHour"
                                                    type="text" placeholder="HH:MM" class="text-center""
                                                    maxlength="5" oninput="formatTime(this)"
                                                    style="width: 5rem; height: 1.5rem"> --}}
                                        {{-- </div> --}}
                                        {{-- </div> --}}
                                    </div>

                                </div>
                                <div class="d-flex my-1">
                                    <div class="col-6">
                                        <label class="custom-control custom-checkbox">
                                            {{-- <input type="checkbox" onchange="missPunchDeductionPeriodContent()"
                                                class="custom-control-input" name="missPunchDeduction"
                                                id="missPunchDeductionBtn" value="1"
                                                {{ $missPunchData != null && $missPunchData->absent_is != 0 ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span> --}}
                                            <label class="form-label mx-1">Mark Absent</label>
                                        </label>
                                    </div>
                                    <div class="col-6 d-none" id="missPunchDeductionPeriodContent">
                                        <div class="row">
                                            <div class="text-end">
                                                <select style="width: 5rem; height:1.5rem" id="missPunchSelectAbsent"
                                                    name="missPunchSelectAbsent">
                                                    <option value="0"
                                                        {{ $missPunchData != null && $missPunchData->absent_is == 0 ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $missPunchData != null && $missPunchData->absent_is == 1 ? 'selected' : '' }}>
                                                        Half Day</option>
                                                    <option value="2"
                                                        {{ $missPunchData != null && $missPunchData->absent_is == 2 ? 'selected' : '' }}>
                                                        Full Day</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function missPunchCountHour() {
                                        // <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour" id="lateEntryOccurenceHour" type="text" placeholder="HH:MM" class="text-center"" maxlength="5" oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                        var missPunchSelectOccurence = document.getElementById('missPunchSelectOccurence');
                                        var missPunchOccurenceHour = document.getElementById('missPunchOccurenceHour');
                                        var missPunchOccurenceCount = document.getElementById('missPunchOccurenceCount');
                                        // console.log(missPunchOccurenceCount);

                                        if (missPunchSelectOccurence.value == 1) {
                                            missPunchOccurenceCount.classList.remove('d-none');
                                            missPunchOccurenceHour.classList.add('d-none');
                                            missPunchOccurenceHour.value = '';
                                        } else if (missPunchSelectOccurence.value == 2) {
                                            missPunchOccurenceHour.classList.remove('d-none');
                                            missPunchOccurenceCount.classList.add('d-none');
                                            missPunchOccurenceCount.value = '';
                                        } else {
                                            missPunchOccurenceHour.classList.add('d-none');
                                            missPunchOccurenceCount.classList.add('d-none');
                                            missPunchOccurenceHour.value = '';
                                            missPunchOccurenceCount.value = '';
                                        }
                                    }

                                    function missPunchOccurenceContent() {
                                        var missPunchOccurenceBtn = document.getElementById('missPunchOccurenceBtn');
                                        var missPunchOccurenceContent = document.getElementById('missPunchOccurenceContent');
                                        var missPunchOccurenceCount = document.getElementById('missPunchOccurenceCount');
                                        var missPunchDeductionPeriodContent = document.getElementById('missPunchDeductionPeriodContent');

                                        // alert('hello');
                                        if (missPunchOccurenceBtn.checked == true) {
                                            missPunchOccurenceContent.classList.remove('d-none');
                                            missPunchDeductionPeriodContent.classList.remove('d-none');
                                        } else {
                                            missPunchOccurenceContent.classList.add('d-none');
                                            missPunchDeductionPeriodContent.classList.add('d-none');
                                            missPunchOccurenceCount.value = '';
                                        }
                                    }
                                </script>
                                <script>
                                    function missPunchDeductionPeriodContent() {
                                        var missPunchOccurenceBtn = document.getElementById('missPunchOccurenceBtn');
                                        // var missPunchDeductionBtn = document.getElementById('missPunchDeductionBtn');
                                        var missPunchDeductionPeriodContent = document.getElementById('missPunchDeductionPeriodContent');

                                        // alert('hello');
                                        if (missPunchOccurenceBtn.checked == true) {
                                            missPunchDeductionPeriodContent.classList.remove('d-none');
                                        } else {
                                            missPunchDeductionPeriodContent.classList.add('d-none');
                                        }
                                    }
                                </script>

                                <div class="my-1 d-flex">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="missPunchRequestFunc()"
                                                class="custom-control-input" name="missPunchRequest"
                                                id="missPunchRequestBtn" value="1"
                                                {{ $missPunchData != null && ($missPunchData->request_day ?? 0) != 0 ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Can mispunch request</label>
                                        </label>
                                    </div>
                                    <div class="col-4 text-end d-none" id="missPunchRequestId">
                                        <input class="mb-4 mr-auto" value="{{ $missPunchData->request_day ?? 0 }}"
                                            name="missPunchRequestDay" id="missPunchRequestDay" placeholder="Days"
                                            type="number" min="0" style="width: 5rem; height: 1.5rem">
                                    </div>

                                </div>
                                <div class="d-flex my-1">
                                    <div class="col-6">
                                        <label class="custom-control custom-checkbox">
                                            {{-- <input type="checkbox" onchange="missPunchDeductionPeriodContent()"
                                                class="custom-control-input" name="missPunchDeduction"
                                                id="missPunchDeductionBtn" value="1"
                                                {{ $missPunchData != null && $missPunchData->absent_is != 0 ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span> --}}
                                            <label class="form-label mx-1">Mark Absent</label>
                                        </label>
                                    </div>
                                    <div class="col-6 d-none" id="missPunchDayDeduction">
                                        <div class="row">
                                            <div class="text-end">
                                                <select style="width: 5rem; height:1.5rem" id="missPunchDaySelectAbsent"
                                                    name="missPunchDaySelectAbsent">
                                                    <option value="0"
                                                        {{ $missPunchData != null && $missPunchData->request_day_absent_is == 0 ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $missPunchData != null && $missPunchData->request_day_absent_is == 1 ? 'selected' : '' }}>
                                                        Half Day</option>
                                                    <option value="2"
                                                        {{ $missPunchData != null && $missPunchData->request_day_absent_is == 2 ? 'selected' : '' }}>
                                                        Full Day</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    missPunchRequestFunc()

                                    function missPunchRequestFunc() {
                                        var missPunchRequestBtn = document.getElementById('missPunchRequestBtn');
                                        var missPunchRequestId = document.getElementById('missPunchRequestId');
                                        var missPunchRequestD = document.getElementById('missPunchRequestDay');
                                        var missPunchDaySelectAbsent = document.getElementById('missPunchDayDeduction');
                                        // alert('Hello');
                                        if (missPunchRequestBtn.checked == true) {
                                            missPunchRequestId.classList.remove('d-none');
                                            missPunchDaySelectAbsent.classList.remove('d-none');
                                        } else {
                                            missPunchRequestId.classList.add('d-none');
                                            missPunchDaySelectAbsent.classList.add('d-none');
                                            missPunchRequestD.value = '';
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>

                    <script>
                        function missPunchContent() {
                            var missPunchBtn = document.getElementById('missPunchBtn');
                            var missPunchContent = document.getElementById('missPunchContent');
                            var missPunchContentCheckboxes = missPunchContent.querySelectorAll('[type="checkbox"]');
                            var missPunchContentSelect = missPunchContent.querySelectorAll('select');
                            var missPunchContentInputs = missPunchContent.querySelectorAll('input[type="number"]');

                            if (missPunchBtn.checked) {
                                missPunchenableFields(missPunchContentCheckboxes);
                                missPunchenableFields(missPunchContentSelect);
                                missPunchenableFields(missPunchContentInputs);
                            } else {
                                missPunchdisableFields(missPunchContentCheckboxes);
                                missPunchUnSelect(missPunchContentSelect);
                                missPunchdisableFields(missPunchContentSelect);
                                missPunchdisableFields(missPunchContentInputs);
                                missPunchdEmpty(missPunchContentCheckboxes);
                            }
                            missPunchOccurenceContent();
                            missPunchDeductionPeriodContent();

                            var switchBtn = missPunchBtn.checked;
                            $.ajax({
                                url: "{{ url('admin/settings/attendance/automation/set') }}",
                                type: "POST",
                                data: {
                                    missPunchSwitch: switchBtn,
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: 'json',
                                success: function(result) {
                                    console.log(result);

                                }
                            });
                        }

                        function missPunchUnSelect(elements) {
                            for (var i = 0; i < elements.length; i++) {
                                elements[i].selectedIndex = 0;
                            }
                        }

                        function missPunchenableFields(elements) {
                            elements.forEach(element => {
                                element.disabled = false;
                            });
                        }

                        function missPunchdisableFields(elements) {
                            elements.forEach(element => {
                                element.disabled = true;
                            });
                        }

                        function missPunchdEmpty(element) {
                            element.forEach(element => {
                                element.checked = false;
                            });
                        }

                        // Initially call the function to set the initial state
                        missPunchContent()
                    </script>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    {{-- Gate PAss Rule  --}}
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">
                                    <a class="font-weight-semibold fs-18 ms-3">Gate Pass Rule</a>

                                </div>
                                <div class="d-flex my-auto">
                                    <label class="custom-switch ms-auto">
                                        <input type="checkbox" onchange="gatePassContent()" name="gatePass"
                                            onchange="" id="gatePassBtn" class="custom-switch-input"
                                            {{ $gatePassData != null && $gatePassData->switch_is != 0 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of
                                the
                                box
                            </p>

                            <div class="my-3" id="gatePassContent">

                                <div class="my-1 d-flex">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="gatePassOccurenceContent()"
                                                class="custom-control-input" name="gatePassOccurence"
                                                id="gatePassOccurenceBtn" value="1"
                                                {{ $gatePassData->occurance_count != null ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurence</label>
                                        </label>
                                    </div>
                                    <div class="col-4 text-end d-none" id="gatePassOccurenceContent">
                                        {{-- <div class="row d-flex justify-content-around">
                                            <div class="col-7 text-end"> --}}
                                        {{-- <select onchange="gatePassCountHour()" style="width: 5rem; height:1.5rem"
                                                    id="gatePassSelectOccurence" name="gatePassSelectOccurence">
                                                    <option value="0"
                                                        {{ $gatePassData != null && $gatePassData->occurance_is == 0 ? 'selected' : '' }}>
                                                        Select</option>
                                                    <option value="1"
                                                        {{ $gatePassData != null && $gatePassData->occurance_is == 1 ? 'selected' : '' }}>
                                                        Count</option>
                                                    <option value="2"
                                                        {{ $gatePassData != null && $gatePassData->occurance_is == 2 ? 'selected' : '' }}>
                                                        Hour</option>
                                                </select> --}}
                                        {{-- </div>
                                            <div class="col-5 d-flex"> --}}
                                        <input class="mb-4 " value="{{ $gatePassData->occurance_count }}"
                                            name="gatePassOccurenceCount" id="gatePassOccurenceCount" placeholder="Times"
                                            type="number" min="0" style="width: 5rem; height: 1.5rem" ">
                                                                                            {{-- <input class="mb-4 ms-auto {{ $gatePassData != null && $gatePassData->occurance_is == 2 ? '' : 'd-none' }}" value="{{ $gatePassData ? $gatePassData->occurance_hr : '' }}:{{ $gatePassData ? $gatePassData->occurance_min : '' }}" name="gatePassOccurenceHour"
                                                                                id="gatePassOccurenceHour" type="text" placeholder="HH:MM" class="text-center""
                                                    maxlength="5" oninput="formatTime(this)"
                                                    style="width: 5rem; height: 1.5rem"> --}}
                                                            {{-- </div>
                                        </div> --}}
                                                    </div>
                                                    <script>
                                                        function gatePassCountHour() {
                                                            // <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour" id="lateEntryOccurenceHour" type="text" placeholder="HH:MM" class="text-center"" maxlength="5" oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                                            var gatePassSelectOccurence = document.getElementById('gatePassSelectOccurence');
                                                            var gatePassOccurenceHour = document.getElementById('gatePassOccurenceHour');
                                                            var gatePassOccurenceCount = document.getElementById('gatePassOccurenceCount');
                                                            // console.log(gatePassOccurenceCount);

                                                            if (gatePassSelectOccurence.value == 1) {
                                                                gatePassOccurenceCount.classList.remove('d-none');
                                                                gatePassOccurenceHour.classList.add('d-none');
                                                                gatePassOccurenceHour.value = '';
                                                            } else if (gatePassSelectOccurence.value == 2) {
                                                                gatePassOccurenceHour.classList.remove('d-none');
                                                                gatePassOccurenceCount.classList.add('d-none');
                                                                gatePassOccurenceCount.value = '';
                                                            } else {
                                                                gatePassOccurenceHour.classList.add('d-none');
                                                                gatePassOccurenceCount.classList.add('d-none');
                                                                gatePassOccurenceHour.value = '';
                                                                gatePassOccurenceCount.value = '';
                                                            }
                                                        }


                                                        function gatePassOccurenceContent() {
                                                            var gatePassOccurenceBtn = document.getElementById('gatePassOccurenceBtn');
                                                            var gatePassOccurenceContent = document.getElementById('gatePassOccurenceContent');
                                                            var gatePassOccurenceCount = document.getElementById('gatePassOccurenceCount');

                                                            // alert('hello');
                                                            if (gatePassOccurenceBtn.checked == true) {
                                                                gatePassOccurenceContent.classList.remove('d-none');
                                                            } else {
                                                                gatePassOccurenceContent.classList.add('d-none');
                                                                gatePassOccurenceCount.value = '';
                                                            }
                                                        }
                                                    </script>
                                                </div>

                                                <div class="d-flex my-1">
                                                    <div class="col-6">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" onchange="gatePassDeductionPeriodContent()"
                                                                class="custom-control-input" name="gatePassDeduction"
                                                                id="gatePassDeductionBtn" value="1"
                                                                {{ $gatePassData != null && $gatePassData->absent_is != 0 ? 'checked' : '' }}>
                                                            <span class="custom-control-label"></span>
                                                            <label class="form-label mx-1">Mark Absent</label>
                                                        </label>
                                                    </div>
                                                    <div class="col-6 d-none" id="gatePassDeductionPeriodContent">
                                                        <div class="row">
                                                            <div class="text-end">
                                                                <select style="width: 5rem; height:1.5rem" id="gatePasSelectAbsent"
                                                                    name="gatePasSelectAbsent">
                                                                    <option value="0"
                                                                        {{ $gatePassData != null && $gatePassData->absent_is == 0 ? 'selected' : '' }}>
                                                                        Select</option>
                                                                    <option value="1"
                                                                        {{ $gatePassData != null && $gatePassData->absent_is == 1 ? 'selected' : '' }}>
                                                                        Half Day</option>
                                                                    <option value="2"
                                                                        {{ $gatePassData != null && $gatePassData->absent_is == 2 ? 'selected' : '' }}>
                                                                        Full Day</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    function gatePassDeductionPeriodContent() {
                                                        var gatePassDeductionBtn = document.getElementById('gatePassDeductionBtn');
                                                        var gatePassDeductionPeriodContent = document.getElementById('gatePassDeductionPeriodContent');

                                                        // alert('hello');
                                                        if (gatePassDeductionBtn.checked == true) {
                                                            gatePassDeductionPeriodContent.classList.remove('d-none');
                                                        } else {
                                                            gatePassDeductionPeriodContent.classList.add('d-none');
                                                        }
                                                    }
                                                </script>
                                            </div>

                                        </div>
                                    </div>

                                    <script>
                                        function gatePassContent() {
                                            var gatePassBtn = document.getElementById('gatePassBtn');
                                            var gatePassContent = document.getElementById('gatePassContent');
                                            var gatePassContentCheckbox = gatePassContent.querySelectorAll('[type="checkbox"]');
                                            var gatePassContentSelect = gatePassContent.querySelectorAll('select');
                                            var gatePassContentInput = gatePassContent.querySelectorAll('[type="number"]');

                                            // console.log(breakContentcheckboxes);
                                            if (gatePassBtn.checked == true) {
                                                gatePassenableFields(gatePassContentCheckbox);
                                                gatePassenableFields(gatePassContentSelect);
                                                gatePassenableFields(gatePassContentInput);
                                            } else {
                                                gatePassEmpty(gatePassContentCheckbox);
                                                gatePassdisableFields(gatePassContentCheckbox);
                                                gatePassUnSelect(gatePassContentSelect);
                                                gatePassdisableFields(gatePassContentSelect);
                                                gatePassdisableFields(gatePassContentInput);
                                            }

                                            gatePassOccurenceContent();
                                            gatePassDeductionPeriodContent();

                                            var switchBtn = gatePassBtn.checked;
                                            $.ajax({
                                                url: "{{ url('admin/settings/attendance/automation/set') }}",
                                                type: "POST",
                                                data: {
                                                    gatePassSwitch: switchBtn,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                dataType: 'json',
                                                success: function(result) {
                                                    console.log(result);

                                                }
                                            });
                                        }

                                        function gatePassUnSelect(elements) {
                                            for (var i = 0; i < elements.length; i++) {
                                                elements[i].selectedIndex = 0;
                                            }
                                        }

                                        function gatePassenableFields(elements) {
                                            elements.forEach(element => {
                                                element.disabled = false;
                                            });
                                        }

                                        function gatePassdisableFields(elements) {
                                            elements.forEach(element => {
                                                element.disabled = true;
                                            });
                                        }

                                        function gatePassEmpty(element) {
                                            element.forEach(element => {
                                                element.checked = false;
                                            });
                                        }
                                        gatePassContent();
                                    </script>

                                </div>
                            </div>

                            <script>
                                function formatTime(input) {
                                    const value = input.value.replace(/\D/g, ''); // Remove non-numeric characters
                                    if (value.length > 4) {
                                        input.value = value.substring(0, 4);
                                    }
                                    if (value.length === 3) {
                                        input.value = `${value.substring(0, 2)}:${value.substring(2)}`;
                                    } else if (value.length >= 2) {
                                        input.value = `${value.substring(0, 2)}:${value.substring(2, 4)}`;
                                    }
                                    console.log(input.value);
                                }
                            </script>

                            <div class="col-12">
                                <div class="d-flex">
                                    <a href="" class="btn btn-danger ms-auto">Cancel</a>
                                    <button type="submit" class="btn btn-md btn-primary mx-5">Save and Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    
            {{-- < --}}
        </form>
@endsection
