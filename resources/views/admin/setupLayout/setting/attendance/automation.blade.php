@extends('admin.setupLayout.master')
@section('title')
    Attendance / Automation Rule
@endsection
@section('css')
    <style>
        input {
            text-align: center;
        }
    </style>
@endsection
@section('content')
    @php
        $lateEntryData;
        $earlyExitData;
        $overtimeData;
        $breakData;
        $missPunchData;
        $gatePassData;
    @endphp
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Automation Rules</div>

            <p class="text-muted">Create Rules to Automate Attendance</p>

        </div>
    </div>
    <form action="{{ route('setAutomationRule') }}" method="post">
        @csrf

        <div class="row row-sm mt-3" id="AllContent">

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="my-auto">
                                    <a class="font-weight-semibold fs-18 ms-3">Late Entry Rule</a>
                                </div>
                                <div class="d-flex">
                                    @php
                                        $checkPermissionAssignOrNot = 0;
                                    @endphp
                                    @if (in_array('Automation-Rules.Create', $permissions) || in_array('Automation-Rules.Update', $permissions))
                                        @php
                                            $checkPermissionAssignOrNot = 1;
                                        @endphp
                                    @endif
                                    <label class="custom-switch ms-auto"
                                        {{ $checkPermissionAssignOrNot == 1 ? '' : 'hidden' }}>
                                        <input type="checkbox" name="lateEntry" onchange="showLateEntryContent()"
                                            id="lateEntryBtn" class="custom-switch-input"
                                            {{ $lateEntryData != null && $lateEntryData->switch_is != 0 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>

                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You Can Define Rule for Late Coming</p>
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
                                            <label class="form-label mx-1">Grace Time for Late Coming</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none"
                                            value="{{ $lateEntryData ? $lateEntryData->grace_time_hr : 0 }}:{{ $lateEntryData ? $lateEntryData->grace_time_min : 0 }}"
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
                                                onchange="lateEntryOccurrenceContent()" name="lateEntryOccurrence"
                                                id="lateEntryOccurrenceBtn" value="1" checked>
                                            <?php }else{ ?>
                                            <input type="checkbox" class="custom-control-input"
                                                onchange="lateEntryOccurrenceContent()" name="lateEntryOccurrence"
                                                id="lateEntryOccurrenceBtn" value="1">
                                            <?php } ?>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurrence</label>
                                        </label>
                                    </div>
                                    <div class="d-none col-12" id="lateEntryOccurrenceContent">
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
                                                    name="lateEntryOccurrenceCount" id="lateEntryOccurrenceCount"
                                                    type="text" placeholder="Times" style="width: 5rem; height: 1.5rem">
                                                <?php }else{ ?>
                                                <input class="mb-4 ms-auto d-none"
                                                    value="{{ $lateEntryData != null ? $lateEntryData->occurance_count : '' }}"
                                                    name="lateEntryOccurrenceCount" id="lateEntryOccurrenceCount"
                                                    type="text" placeholder="Times" style="width: 5rem; height: 1.5rem">
                                                <?php } ?>

                                                <?php if($lateEntryData!= null && ($lateEntryData->occurance_hr != 0 || $lateEntryData->occurance_min != 0)){ ?>
                                                <input class="mb-4 ms-auto"
                                                    value="{{ $lateEntryData != null ? $lateEntryData->occurance_hr : 0 }}:{{ $lateEntryData != null ? $lateEntryData->occurance_min : 0 }}"
                                                    name="lateEntryOccurrenceHour" id="lateEntryOccurrenceHour"
                                                    type="text" placeholder="HH:MM" class="text-center""
                                                    maxlength="5" oninput="formatTime(this)"
                                                    style="width: 5rem; height: 1.5rem"><?php }else{ ?>
                                                <input class="mb-4 ms-auto d-none"
                                                    value="{{ $lateEntryData != null ? $lateEntryData->occurance_hr : 0 }}:{{ $lateEntryData != null ? $lateEntryData->occurance_min : 0 }}"
                                                    name="lateEntryOccurrenceHour" id="lateEntryOccurrenceHour"
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
                                    function lateEntryOccurrenceContent() {
                                        var lateEntryOccurrenceBtn = document.getElementById('lateEntryOccurrenceBtn');
                                        var lateEntryOccurrenceContent = document.getElementById('lateEntryOccurrenceContent');
                                        var lateEntryOccurrenceCount = document.getElementById('lateEntryOccurrenceCount');
                                        var lateEntryDeductionBtn = document.getElementById('lateEntryDeductionBtn');
                                        var lateEntryDeductionPeriodContent = document.getElementById('lateEntryDeductionPeriodContent');

                                        if (lateEntryOccurrenceBtn.checked == true) {
                                            lateEntryOccurrenceContent.classList.remove('d-none');
                                            lateEntryDeductionPeriodContent.classList.remove('d-none');
                                        } else {
                                            lateEntryOccurrenceContent.classList.add('d-none');
                                            lateEntryDeductionPeriodContent.classList.add('d-none');
                                            lateEntryOccurrenceCount.value = '';
                                        }
                                    }

                                    function countHour() {
                                        var lateEntrySelectOccurance = document.getElementById('lateEntrySelectOccurance');
                                        var lateEntryOccurrenceHour = document.getElementById('lateEntryOccurrenceHour');
                                        var lateEntryOccurrenceCount = document.getElementById('lateEntryOccurrenceCount');

                                        // console.log(lateEntryOccurrenceCount);

                                        if (lateEntrySelectOccurance.value == 1) {
                                            lateEntryOccurrenceCount.classList.remove('d-none');
                                            lateEntryOccurrenceHour.classList.add('d-none');
                                            lateEntryOccurrenceHour.value = '';
                                        } else if (lateEntrySelectOccurance.value == 2) {
                                            lateEntryOccurrenceHour.classList.remove('d-none');
                                            lateEntryOccurrenceCount.classList.add('d-none');
                                            lateEntryOccurrenceCount.value = '';
                                        } else {
                                            lateEntryOccurrenceHour.classList.add('d-none');
                                            lateEntryOccurrenceCount.classList.add('d-none');
                                            lateEntryOccurrenceHour.value = '';
                                            lateEntryOccurrenceCount.value = '';
                                        }
                                    }
                                </script>

                                <script>
                                    function lateEntryDeductionPeriodContent() {
                                        var lateEntryOccurrenceBtn = document.getElementById('lateEntryOccurrenceBtn');
                                        var lateEntryDeductionPeriodContent = document.getElementById('lateEntryDeductionPeriodContent');

                                        if (lateEntryOccurrenceBtn.checked == true) {
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
                                            value="{{ $lateEntryData ? $lateEntryData->mark_half_day_hr : 0 }}:{{ $lateEntryData ? $lateEntryData->mark_half_day_min : 0 }}"
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
                                    lateEntryOccurrenceContent();
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
                                    <label class="custom-switch ms-auto"
                                        {{ $checkPermissionAssignOrNot == 1 ? '' : 'hidden' }}>
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
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You Can Define Rule for Early Exit
                            </p>

                            <div class="my-3" id="earlyExitContent">
                                <div class="d-flex my-1">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="graceTimefunc()"
                                                class="custom-control-input" name="graceTimeBtn" id="graceTimeBtn"
                                                value="1"
                                                {{ $earlyExitData != null && ($earlyExitData->grace_time_hr != 0 || $earlyExitData->grace_time_min != 0) ? 'checked' : 0 }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Grace time for early exit</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none"
                                            value="{{ $earlyExitData ? $earlyExitData->grace_time_hr : 0 }}:{{ $earlyExitData ? $earlyExitData->grace_time_min : 0 }}"
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
                                            <input type="checkbox" onchange="earlyExitOccurrenceContent()"
                                                class="custom-control-input" name="earlyExitOccurrence"
                                                id="earlyExitOccurrenceBtn" value="1" checked><?php }else{ ?>
                                            <input type="checkbox" onchange="earlyExitOccurrenceContent()"
                                                class="custom-control-input" name="earlyExitOccurrence"
                                                id="earlyExitOccurrenceBtn" value="1"><?php } ?>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurrence</label>
                                        </label>
                                    </div>
                                    <div class="col-12 d-none" id="earlyExitOccurrenceContent">
                                        <div class="row d-flex justify-content-around">
                                            <div class="col-7 text-end">
                                                <select onchange="earlyExitcountHour()" style="width: 5rem; height:1.5rem"
                                                    id="earlyExitSelectOccurrence" name="earlyExitSelectOccurrence">
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
                                                    name="earlyExitOccurrenceCount" id="earlyExitOccurrenceCount"
                                                    placeholder="Times" type="number" min="0"
                                                    style="width: 5rem; height: 1.5rem"><?php }else{ ?>
                                                <input class="mb-4 ms-auto d-none"
                                                    value="{{ $earlyExitData ? $earlyExitData->occurance_count : '' }}"
                                                    name="earlyExitOccurrenceCount" id="earlyExitOccurrenceCount"
                                                    placeholder="Times" type="number" min="0"
                                                    style="width: 5rem; height: 1.5rem"><?php } ?>

                                                <?php if(($earlyExitData != null) && $earlyExitData->occurance_is == 2){ ?>
                                                <input class="mb-4 ms-auto "
                                                    value="{{ $earlyExitData->occurance_hr }}:{{ $earlyExitData->occurance_min }}"
                                                    name="earlyExitOccurrenceHour" id="earlyExitOccurrenceHour"
                                                    type="text" placeholder="HH:MM" class="text-center""
                                                    maxlength="5" oninput="formatTime(this)"
                                                    style="width: 5rem; height: 1.5rem"><?php }else{ ?>
                                                <input class="mb-4 ms-auto d-none"
                                                    value="{{ $earlyExitData ? $earlyExitData->occurance_hr : 0 }}:{{ $earlyExitData ? $earlyExitData->occurance_min : 0 }}"
                                                    name="earlyExitOccurrenceHour" id="earlyExitOccurrenceHour"
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
                                    function earlyExitOccurrenceContent() {
                                        var earlyExitOccurrenceBtn = document.getElementById('earlyExitOccurrenceBtn');
                                        var earlyExitOccurrenceContent = document.getElementById('earlyExitOccurrenceContent');
                                        var earlyExitOccurrenceCount = document.getElementById('earlyExitOccurrenceCount');
                                        var earlyExitDeductionPeriodContentid = document.getElementById('earlyExitDeductionPeriodContentId');

                                        // alert('hello');
                                        if (earlyExitOccurrenceBtn.checked == true) {
                                            earlyExitOccurrenceContent.classList.remove('d-none');
                                            earlyExitDeductionPeriodContentid.classList.remove('d-none');
                                        } else {
                                            earlyExitOccurrenceContent.classList.add('d-none');
                                            earlyExitDeductionPeriodContentid.classList.add('d-none');
                                            earlyExitOccurrenceCount.value = '';
                                        }
                                    }

                                    function earlyExitcountHour() {
                                        // <input class="mb-4 d-none" value="" name="lateEntryOccurrenceHour" id="lateEntryOccurrenceHour" type="text" placeholder="HH:MM" class="text-center"" maxlength="5" oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                        var earlyExitSelectOccurrence = document.getElementById('earlyExitSelectOccurrence');
                                        var earlyExitOccurrenceHour = document.getElementById('earlyExitOccurrenceHour');
                                        var earlyExitOccurrenceCount = document.getElementById('earlyExitOccurrenceCount');
                                        // console.log(earlyExitOccurrenceCount);

                                        if (earlyExitSelectOccurrence.value == 1) {
                                            earlyExitOccurrenceCount.classList.remove('d-none');
                                            earlyExitOccurrenceHour.classList.add('d-none');
                                            earlyExitOccurrenceHour.value = '';
                                        } else if (earlyExitSelectOccurrence.value == 2) {
                                            earlyExitOccurrenceHour.classList.remove('d-none');
                                            earlyExitOccurrenceCount.classList.add('d-none');
                                            earlyExitOccurrenceCount.value = '';
                                        } else {
                                            earlyExitOccurrenceHour.classList.add('d-none');
                                            earlyExitOccurrenceCount.classList.add('d-none');
                                            earlyExitOccurrenceHour.value = '';
                                            earlyExitOccurrenceCount.value = '';
                                        }
                                    }
                                </script>

                                <script>
                                    function earlyExitDeductionPeriodContent() {
                                        var earlyExitOccurrenceBtn = document.getElementById('earlyExitOccurrenceBtn');
                                        // var earlyExitDeductionBtn = document.getElementById('earlyExitDeductionBtn');
                                        var earlyExitDeductionPeriodContentid = document.getElementById('earlyExitDeductionPeriodContentId');

                                        if (earlyExitOccurrenceBtn.checked == true) {
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
                            earlyExitOccurrenceContent();
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
                                    <label class="custom-switch ms-auto"
                                        {{ $checkPermissionAssignOrNot == 1 ? '' : 'hidden' }}>
                                        <input type="checkbox" onchange="overtimeContent()" name="overtime"
                                            id="overtimeBtn" class="custom-switch-input"
                                            {{ $overtimeData != null && $overtimeData->switch_is != 0 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You Can Define Rule for Overtime Allowance.
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
                                            <label class="form-label mx-1">Allow Overtime for Early Coming</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none"
                                            value="{{ $overtimeData ? $overtimeData->early_ot_hr : 0 }}:{{ $overtimeData ? $overtimeData->early_ot_min : 0 }}"
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
                                            <label class="form-label mx-1">Allow Overtime for Late Going</label>
                                        </label>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <input class="mb-4 d-none"
                                            value="{{ $overtimeData ? $overtimeData->late_ot_hr : 0 }}:{{ $overtimeData ? $overtimeData->late_ot_min : 0 }}"
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
                                                <label class="form-label mx-1">Min</label>
                                                <input class="mb-4"
                                                    value="{{ $overtimeData ? $overtimeData->min_ot_hr : 0 }}: {{ $overtimeData ? $overtimeData->min_ot_min : 0 }}"
                                                    name="minOverTime" id="minOverTimeBtn" type="text"
                                                    placeholder="HH:MM" class="text-center"" maxlength="5"
                                                    oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                            </div>
                                            <div class="mx-2">
                                                <label class="form-label mx-1">Max</label>
                                                <input class="mb-4"
                                                    value="{{ $overtimeData ? $overtimeData->max_ot_hr : 0 }}:{{ $overtimeData ? $overtimeData->max_ot_min : 0 }}"
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
                                    <a class="font-weight-semibold fs-18 ms-3">Mis-Punch Rule</a>
                                </div>
                                <div class="d-flex my-auto">
                                    @if (in_array('Automation-Rules.Create', $permissions) || in_array('Automation-Rules.Update', $permissions))
                                        <label class="custom-switch ms-auto">
                                            <input type="checkbox" onchange="missPunchContent()" name="missPunch"
                                                onchange="" id="missPunchBtn" class="custom-switch-input"
                                                {{ $missPunchData != null && $missPunchData->switch_is != 0 ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You Can Define Rule for Mis-Punch Limitation.
                            </p>

                            <div class="my-3" id="missPunchContent">
                                <div class="my-1 d-flex">
                                    <div class="col-8">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="missPunchOccurrenceContent()"
                                                class="custom-control-input" name="missPunchOccurrence"
                                                id="missPunchOccurrenceBtn" value="1"
                                                {{ ($missPunchData->occurance_count ?? 0) != null ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurrence</label>
                                        </label>
                                    </div>
                                    <div class="col-4 text-end d-none" id="missPunchOccurrenceContent">
                                        {{-- <div class="row d-flex justify-content-around"> --}}
                                        {{-- <div class="col-7 text-end"> --}}
                                        {{-- <select onchange="missPunchCountHour()" style="width: 5rem; height:1.5rem"
                                                    id="missPunchSelectOccurrence" name="missPunchSelectOccurrence">
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
                                            name="missPunchOccurrenceCount" id="missPunchOccurrenceCount"
                                            placeholder="Times" type="number" min="0"
                                            style="width: 5rem; height: 1.5rem">
                                        {{-- <input
                                                    class="mb-4 ms-auto {{ $missPunchData != null && $missPunchData->occurance_is == 2 ? '' : 'd-none' }}"
                                                    value="{{ $missPunchData ? $missPunchData->occurance_hr : '' }}:{{ $missPunchData ? $missPunchData->occurance_min : '' }}"
                                                    name="missPunchOccurrenceHour" id="missPunchOccurrenceHour"
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
                                        // <input class="mb-4 d-none" value="" name="lateEntryOccurrenceHour" id="lateEntryOccurrenceHour" type="text" placeholder="HH:MM" class="text-center"" maxlength="5" oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                        var missPunchSelectOccurrence = document.getElementById('missPunchSelectOccurrence');
                                        var missPunchOccurrenceHour = document.getElementById('missPunchOccurrenceHour');
                                        var missPunchOccurrenceCount = document.getElementById('missPunchOccurrenceCount');
                                        // console.log(missPunchOccurrenceCount);

                                        if (missPunchSelectOccurrence.value == 1) {
                                            missPunchOccurrenceCount.classList.remove('d-none');
                                            missPunchOccurrenceHour.classList.add('d-none');
                                            missPunchOccurrenceHour.value = '';
                                        } else if (missPunchSelectOccurrence.value == 2) {
                                            missPunchOccurrenceHour.classList.remove('d-none');
                                            missPunchOccurrenceCount.classList.add('d-none');
                                            missPunchOccurrenceCount.value = '';
                                        } else {
                                            missPunchOccurrenceHour.classList.add('d-none');
                                            missPunchOccurrenceCount.classList.add('d-none');
                                            missPunchOccurrenceHour.value = '';
                                            missPunchOccurrenceCount.value = '';
                                        }
                                    }

                                    function missPunchOccurrenceContent() {
                                        var missPunchOccurrenceBtn = document.getElementById('missPunchOccurrenceBtn');
                                        var missPunchOccurrenceContent = document.getElementById('missPunchOccurrenceContent');
                                        var missPunchOccurrenceCount = document.getElementById('missPunchOccurrenceCount');
                                        var missPunchDeductionPeriodContent = document.getElementById('missPunchDeductionPeriodContent');

                                        // alert('hello');
                                        if (missPunchOccurrenceBtn.checked == true) {
                                            missPunchOccurrenceContent.classList.remove('d-none');
                                            missPunchDeductionPeriodContent.classList.remove('d-none');
                                        } else {
                                            missPunchOccurrenceContent.classList.add('d-none');
                                            missPunchDeductionPeriodContent.classList.add('d-none');
                                            missPunchOccurrenceCount.value = '';
                                        }
                                    }
                                </script>
                                <script>
                                    function missPunchDeductionPeriodContent() {
                                        var missPunchOccurrenceBtn = document.getElementById('missPunchOccurrenceBtn');
                                        // var missPunchDeductionBtn = document.getElementById('missPunchDeductionBtn');
                                        var missPunchDeductionPeriodContent = document.getElementById('missPunchDeductionPeriodContent');

                                        // alert('hello');
                                        if (missPunchOccurrenceBtn.checked == true) {
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
                                            <label class="form-label mx-1">Send Mispunch Request Before</label>
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
                                        var missPunchRequestD = document.getElementById('missPunchRequestDay');
                                        var missPunchRequestId = document.getElementById('missPunchRequestId');
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
                            var missPunchRequestId = document.getElementById('missPunchRequestId');
                            var missPunchDaySelectAbsent = document.getElementById('missPunchDayDeduction');

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
                                missPunchRequestId.classList.add('d-none');
                                missPunchDaySelectAbsent.classList.add('d-none');
                            }
                            missPunchOccurrenceContent();
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
                                    <label class="custom-switch ms-auto"
                                        {{ $checkPermissionAssignOrNot == 1 ? '' : 'hidden' }}>
                                        <input type="checkbox" onchange="gatePassContent()" name="gatePass"
                                            onchange="" id="gatePassBtn" class="custom-switch-input"
                                            {{ $gatePassData != null && $gatePassData->switch_is != 0 ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You Can Define Rule for Gate Pass Allowance.
                            </p>

                            <div class="my-3" id="gatePassContent">

                                <div class="my-1 d-flex">
                                    <div class="col-8">

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="gatePassOccurrenceContent()"
                                                class="custom-control-input" name="gatePassOccurrence"
                                                id="gatePassOccurrenceBtn" value="1"
                                                {{ ($gatePassData->occurance_count ?? 0) != null ? 'checked' : '' }}>
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">Set Occurrence</label>
                                        </label>
                                    </div>
                                    <div class="col-4 text-end d-none" id="gatePassOccurrenceContent">

                                        <input class="mb-4 " value="{{ $gatePassData->occurance_count ?? 0 }}"
                                            name="gatePassOccurrenceCount" id="gatePassOccurrenceCount"
                                            placeholder="Times" type="number" min="0"
                                            style="width: 5rem; height: 1.5rem" ">
                                                             </div>
                                                                                                            <script>
                                                                                                                function gatePassCountHour() {
                                                                                                                    // <input class="mb-4 d-none" value="" name="lateEntryOccurrenceHour" id="lateEntryOccurrenceHour" type="text" placeholder="HH:MM" class="text-center"" maxlength="5" oninput="formatTime(this)" style="width: 5rem; height: 1.5rem">
                                                                                                                    var gatePassSelectOccurrence = document.getElementById('gatePassSelectOccurrence');
                                                                                                                    var gatePassOccurrenceHour = document.getElementById('gatePassOccurrenceHour');
                                                                                                                    var gatePassOccurrenceCount = document.getElementById('gatePassOccurrenceCount');
                                                                                                                    // console.log(gatePassOccurrenceCount);

                                                                                                                    if (gatePassSelectOccurrence.value == 1) {
                                                                                                                        gatePassOccurrenceCount.classList.remove('d-none');
                                                                                                                        gatePassOccurrenceHour.classList.add('d-none');
                                                                                                                        gatePassOccurrenceHour.value = '';
                                                                                                                    } else if (gatePassSelectOccurrence.value == 2) {
                                                                                                                        gatePassOccurrenceHour.classList.remove('d-none');
                                                                                                                        gatePassOccurrenceCount.classList.add('d-none');
                                                                                                                        gatePassOccurrenceCount.value = '';
                                                                                                                    } else {
                                                                                                                        gatePassOccurrenceHour.classList.add('d-none');
                                                                                                                        gatePassOccurrenceCount.classList.add('d-none');
                                                                                                                        gatePassOccurrenceHour.value = '';
                                                                                                                        gatePassOccurrenceCount.value = '';
                                                                                                                    }
                                                                                                                }
                                                                                                            </script>
                                                                                                        </div>

                                                                                                        <div class="d-flex my-1">
                                                                                                            <div class="col-6">
                                                                                                                <label class="custom-control custom-checkbox">

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
                                                                                                            function gatePassOccurrenceContent() {
                                                                                                                var gatePassOccurrenceBtn = document.getElementById('gatePassOccurrenceBtn');
                                                                                                                var gatePassOccurrenceContent = document.getElementById('gatePassOccurrenceContent');
                                                                                                                var gatePassOccurrenceCount = document.getElementById('gatePassOccurrenceCount');
                                                                                                                var gatePassDeductionPeriodContent = document.getElementById('gatePassDeductionPeriodContent');

                                                                                                                // alert('hello');
                                                                                                                if (gatePassOccurrenceBtn.checked == true) {
                                                                                                                    gatePassOccurrenceContent.classList.remove('d-none');
                                                                                                                    gatePassDeductionPeriodContent.classList.remove('d-none');
                                                                                                                } else {
                                                                                                                    gatePassOccurrenceContent.classList.add('d-none');
                                                                                                                    gatePassDeductionPeriodContent.classList.add('d-none');
                                                                                                                    gatePassOccurrenceCount.value = '';
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

                                                                                                    gatePassOccurrenceContent();
                                                                                                    // gatePassDeductionPeriodContent();

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

                                                                                    <div class="col-12 ">
                                                                                   @if (in_array('Automation-Rules.Create', $permissions) || in_array('Automation-Rules.Update', $permissions))
                                        <div class="d-flex justify-content-between ">
                                            <div>
                                                <a href="{{ url('/setup/attendance-settings') }}"
                                                    class="btn btn-primary">Back</a>
                                            </div>

                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-md btn-primary ">Save &
                                                    Apply</button>

                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- < --}}

                    @if (in_array('Automation-Rules.Create', $permissions) || in_array('Automation-Rules.Update', $permissions))
                    @else
                        <script>
                            var lateEntryGraceBtn = document.getElementById('lateEntryGraceBtn');
                            var lateEntryGraceTime = document.getElementById('lateEntryGraceTime');
                            var lateEntryOccurrenceBtn = document.getElementById('lateEntryOccurrenceBtn');
                            var lateEntrySelectOccurance = document.getElementById('lateEntrySelectOccurance');
                            var lateEntryOccurrenceCount = document.getElementById('lateEntryOccurrenceCount');
                            var lateEntryOccurrenceHour = document.getElementById('lateEntryOccurrenceHour');
                            var lateEntrySelectAbsent = document.getElementById('lateEntrySelectAbsent');
                            var exitMarkHalfDayBtn = document.getElementById('exitMarkHalfDayBtn');
                            var lateEntryMarkHalfDayBtn = document.getElementById('lateEntryMarkHalfDayBtn');
                            var graceTimeBtn = document.getElementById('graceTimeBtn');
                            var earlyExitOccurrenceBtn = document.getElementById('earlyExitOccurrenceBtn');
                            var earlyExitSelectOccurrence = document.getElementById('earlyExitSelectOccurrence');
                            var earlyExitOccurrenceHour = document.getElementById('earlyExitOccurrenceHour');
                            var earlyExitOccurrenceCount = document.getElementById('earlyExitOccurrenceCount');
                            // var earlyExitDeductionBtn = document.getElementById('earlyExitDeductionBtn');
                            var earlyExitDeductionPeriodContentid = document.getElementById('earlyExitDeductionPeriodContentId');
                            var earlyExitByBtn = document.getElementById('earlyExitByBtn');
                            var earlyExitSelectAbsent = document.getElementById('earlyExitSelectAbsent');
                            var graceTime = document.getElementById('graceTime');
                            var lateEntryMarkHalfDayMinutes = document.getElementById('lateEntryMarkHalfDayMinutes');
                            var allowEarlyOverTimeBtn = document.getElementById('allowEarlyOverTimeBtn');
                            var lateOverTimeBtn = document.getElementById('lateOverTimeBtn');
                            var minMaxOverTimeBtn = document.getElementById('minMaxOverTimeBtn');
                            var allowLateOverTimeBtn = document.getElementById('allowLateOverTimeBtn');
                            var earlyOverTimeBtn = document.getElementById('earlyOverTimeBtn');
                            var minOverTimeBtn = document.getElementById('minOverTimeBtn');
                            var maxOverTimeBtn = document.getElementById('maxOverTimeBtn');
                            var missPunchOccurrenceBtn = document.getElementById('missPunchOccurrenceBtn');
                            var missPunchOccurrenceContent = document.getElementById('missPunchOccurrenceContent');
                            var missPunchOccurrenceCount = document.getElementById('missPunchOccurrenceCount');
                            var missPunchDeductionPeriodContent = document.getElementById('missPunchDeductionPeriodContent');
                            var missPunchRequestD = document.getElementById('missPunchRequestDay');
                            var missPunchRequestBtn = document.getElementById('missPunchRequestBtn');
                            var maxOverTimeBtn = document.getElementById('maxOverTimeBtn');
                            var missPunchDaySelectAbsent = document.getElementById('missPunchDaySelectAbsent');
                            var gatePassOccurrenceContent = document.getElementById('gatePassOccurrenceContent');
                            var gatePassOccurrenceCount = document.getElementById('gatePassOccurrenceCount');
                            var gatePassOccurrenceBtn = document.getElementById('gatePassOccurrenceBtn');
                            var gatePasSelectAbsent = document.getElementById('gatePasSelectAbsent');

                            lateEntryGraceBtn.disabled = true;
                            lateEntryGraceTime.disabled = true;
                            lateEntryOccurrenceBtn.disabled = true;
                            lateEntrySelectOccurance.disabled = true;
                            lateEntryOccurrenceCount.disabled = true;
                            lateEntryOccurrenceHour.disabled = true;
                            lateEntrySelectAbsent.disabled = true;
                            exitMarkHalfDayBtn.disabled = true;
                            lateEntryMarkHalfDayBtn.disabled = true;
                            graceTimeBtn.disabled = true;
                            earlyExitOccurrenceBtn.disabled = true;
                            earlyExitSelectOccurrence.disabled = true;
                            earlyExitOccurrenceHour.disabled = true;
                            earlyExitOccurrenceCount.disabled = true;
                            earlyExitDeductionPeriodContentid.disabled = true;
                            earlyExitByBtn.disabled = true;
                            earlyExitSelectAbsent.disabled = true;
                            graceTime.disabled = true;
                            lateEntryMarkHalfDayMinutes.disabled = true;
                            allowEarlyOverTimeBtn.disabled = true;
                            lateOverTimeBtn.disabled = true;
                            minMaxOverTimeBtn.disabled = true;
                            allowLateOverTimeBtn.disabled = true;
                            earlyOverTimeBtn.disabled = true;
                            minOverTimeBtn.disabled = true;
                            missPunchOccurrenceBtn.disabled = true;
                            missPunchOccurrenceContent.disabled = true;
                            missPunchOccurrenceCount.disabled = true;
                            missPunchDeductionPeriodContent.disabled = true;
                            missPunchRequestD.disabled = true;
                            missPunchRequestBtn.disabled = true;
                            maxOverTimeBtn.disabled = true;
                            missPunchDaySelectAbsent.disabled = true;
                            gatePassOccurrenceContent.disabled = true;
                            gatePassOccurrenceCount.disabled = true;
                            gatePassOccurrenceBtn.disabled = true;
                            gatePasSelectAbsent.disabled = true;
                        </script>
                    @endif
    </form>
@endsection
