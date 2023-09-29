@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Automation Rule
@endsection
@section('settings')
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Atutomation Rules</div>
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
    <div class="row row-sm">

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a class="font-weight-semibold fs-18 ms-3">Late Entry Rule</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the
                                    box
                                </p>
                            </div>
                            <div class="d-flex my-auto">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" name="lateEntry" onchange="showLateEntryContent()"
                                        id="lateEntryBtn" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="my-3 mx-5 " id="lateEntryContent" disabled>
                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" onchange="lateEntryGraceTime()"
                                        name="lateEntryGrace" id="lateEntryGraceBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Grace time for late coming</label>
                                <div class="col-1">
                                    <input class="mb-4 d-none" id="lateEntryGraceTime" name="lateEntryGraceTime"
                                        type="text" placeholder="HH:MM" maxlength="5" oninput="formatTime(this)"
                                        style="width: 5rem">
                                </div>
                            </div>
                            <script>
                                function lateEntryGraceTime() {
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

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        onchange="lateEntryOccurenceContent()" name="lateEntryOccurence"
                                        id="lateEntryOccurenceBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Set Occurence</label>
                                <div class="d-none" id="lateEntryOccurenceContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select style="width: 5rem; height:1.5rem" id="lateEntrySelectOccurance"
                                                onchange="countHour()" name="lateEntrySelectOccurance">
                                                <option value="">Select</option>
                                                <option value="1">Count</option>
                                                <option value="2">Hour</option>
                                            </select>
                                        </div>
                                        <div class="col-6 d-flex">
                                            <input class="mb-4 d-none" value="" name="lateEntryOccurenceCount"
                                                id="lateEntryOccurenceCount" type="text" placeholder="Count"
                                                style="width: 3.2rem">
                                            <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour"
                                                id="lateEntryOccurenceHour" type="text" placeholder="HH:MM"
                                                maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function lateEntryOccurenceContent() {
                                    var lateEntryOccurenceBtn = document.getElementById('lateEntryOccurenceBtn');
                                    var lateEntryOccurenceContent = document.getElementById('lateEntryOccurenceContent');
                                    var lateEntryOccurenceCount = document.getElementById('lateEntryOccurenceCount');

                                    if (lateEntryOccurenceBtn.checked == true) {
                                        lateEntryOccurenceContent.classList.remove('d-none');
                                    } else {
                                        lateEntryOccurenceContent.classList.add('d-none');
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

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        onchange="lateEntryDeductionPeriodContent()" name="lateEntryDeduction"
                                        id="lateEntryDeductionBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Mark Absent</label>
                                <div class="d-none" id="lateEntryDeductionPeriodContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select style="width: 5rem; height:1.5rem" id="lateEntrySelectAbsent"
                                                name="lateEntrySelectAbsent">
                                                <option value="">Select</option>
                                                <option value="1">Half Day</option>
                                                <option value="2">Absent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function lateEntryDeductionPeriodContent() {
                                    var lateEntryDeductionBtn = document.getElementById('lateEntryDeductionBtn');
                                    var lateEntryDeductionPeriodContent = document.getElementById('lateEntryDeductionPeriodContent');

                                    if (lateEntryDeductionBtn.checked == true) {
                                        lateEntryDeductionPeriodContent.classList.remove('d-none');
                                    } else {
                                        lateEntryDeductionPeriodContent.classList.add('d-none');
                                    }
                                }
                            </script>

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        onchange="lateEntryMarkHalfDayMinutes()" name="lateEntryMarkHalfDay"
                                        id="lateEntryMarkHalfDayBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Mark half day if late by (Minutes)</label>
                                <div class="col-1">
                                    <input class="mb-4 d-none" value="" name="lateEntryMarkHalfDayMinutes"
                                        id="lateEntryMarkHalfDayMinutes" placeholder="Enter" type="number"
                                        min="0" style="width: 3.2rem">
                                </div>
                            </div>

                            <script>
                                function lateEntryMarkHalfDayMinutes() {
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

                                console.log(lateEntrySelect);

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

                                lateEntryMarkHalfDayMinutes();
                                lateEntryDeductionPeriodContent();
                                lateEntryOccurenceContent();
                                lateEntryGraceTime();

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
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the
                                    box
                                </p>
                            </div>
                            <div class="d-flex my-auto">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" onchange="earlyExitContent()" name="earlyExitBtn"
                                        onchange="" id="earlyExitBtn" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>

                        <div class="my-3 mx-5" id="earlyExitContent">
                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="graceTime()" class="custom-control-input"
                                        name="graceTimeBtn" id="graceTimeBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Grace time for early exit</label>
                                <div class="col-1">
                                    <input class="mb-4 d-none" value="" name="graceTime" id="graceTime"
                                        placeholder="Enter" type="number" min="0" style="width: 3.2rem">
                                </div>
                            </div>

                            <script>
                                function graceTime() {
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

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="earlyExitOccurenceContent()"
                                        class="custom-control-input" name="earlyExitOccurence" id="earlyExitOccurenceBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Set Occurence</label>
                                <div class="d-none" id="earlyExitOccurenceContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select onchange="earlyExitcountHour()" style="width: 5rem; height:1.5rem"
                                                id="earlyExitSelectOccurence" name="earlyExitSelectOccurence">
                                                <option value="">Select</option>
                                                <option value="1">Count</option>
                                                <option value="2">Hour</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <input class="mb-4 d-none" value="" name="earlyExitOccurenceCount"
                                                id="earlyExitOccurenceCount" placeholder="Enter" type="number"
                                                min="0" style="width: 3.2rem">
                                            <input class="mb-4 d-none" value="" name="earlyExitOccurenceHour"
                                                id="earlyExitOccurenceHour" type="text" placeholder="HH:MM"
                                                maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function earlyExitOccurenceContent() {
                                    var earlyExitOccurenceBtn = document.getElementById('earlyExitOccurenceBtn');
                                    var earlyExitOccurenceContent = document.getElementById('earlyExitOccurenceContent');
                                    var earlyExitOccurenceCount = document.getElementById('earlyExitOccurenceCount');

                                    // alert('hello');
                                    if (earlyExitOccurenceBtn.checked == true) {
                                        earlyExitOccurenceContent.classList.remove('d-none');
                                    } else {
                                        earlyExitOccurenceContent.classList.add('d-none');
                                        earlyExitOccurenceCount.value = '';
                                    }
                                }

                                function earlyExitcountHour() {
                                    // <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour" id="lateEntryOccurenceHour" type="text" placeholder="HH:MM" maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
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

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="earlyExitDeductionPeriodContent()"
                                        class="custom-control-input" name="earlyExitDeduction" id="earlyExitDeductionBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Mark Absent</label>
                                <div class="d-none" id="earlyExitDeductionPeriodContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select style="width: 5rem; height:1.5rem" id="earlyExitSelectAbsent"
                                                name="earlyExitSelectAbsent">
                                                <option value="">Select</option>
                                                <option value="1">Half Day</option>
                                                <option value="2">Full Day</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function earlyExitDeductionPeriodContent() {
                                    var earlyExitDeductionBtn = document.getElementById('earlyExitDeductionBtn');
                                    var earlyExitDeductionPeriodContent = document.getElementById('earlyExitDeductionPeriodContent');

                                    // alert('hello');
                                    if (earlyExitDeductionBtn.checked == true) {
                                        earlyExitDeductionPeriodContent.classList.remove('d-none');
                                    } else {
                                        earlyExitDeductionPeriodContent.classList.add('d-none');
                                    }
                                }
                            </script>

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="earlyExitByBtn()" class="custom-control-input"
                                        name="exitMarkHalfDay" id="exitMarkHalfDayBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Mark half day if early going by (Minutes):</label>
                                <div class="col-1">
                                    <input class="mb-4 d-none" value="" name="earlyExitBy" id="earlyExitByBtn"
                                        placeholder="Enter" type="number" min="0" style="width: 3.2rem">
                                </div>
                            </div>

                            <script>
                                function earlyExitByBtn() {
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

                        earlyExitByBtn();
                        earlyExitDeductionPeriodContent();
                        earlyExitOccurenceContent();
                        graceTime();
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
                {{-- break rule  --}}
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a class="font-weight-semibold fs-18 ms-3">Break Rule</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the
                                    box
                                </p>
                            </div>
                            <div class="d-flex my-auto">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" name="breakBtn" onchange="breakContent()" id="breakBtn"
                                        class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>

                        <div class="my-3 mx-5" id="breakContent">
                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="defaultBreak"
                                        id="defaultBreakBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Deduct Break hour from work hour </label>
                            </div>

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" onchange="extraTimeForBreakBtn()"
                                        name="extraBreakTime" id="extraBreakTimeBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Extra time for break </label>
                                <div class="col-1">
                                    <input class="mb-4 d-none" value="" id="extraTimeForBreakBtn"
                                        placeholder="Enter" type="number" min="0" name="extraTimeForBreak"
                                        style="width: 3.2rem">
                                </div>

                                <script>
                                    function extraTimeForBreakBtn() {
                                        var extraBreakTimeBtn = document.getElementById('extraBreakTimeBtn');
                                        var extraTimeForBreakBtn = document.getElementById('extraTimeForBreakBtn');

                                        if (extraBreakTimeBtn.checked == true) {
                                            extraTimeForBreakBtn.classList.remove('d-none');
                                        } else {
                                            extraTimeForBreakBtn.classList.add('d-none');
                                            extraTimeForBreakBtn.value = '';
                                        }
                                    }
                                </script>
                            </div>

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="breakOccurenceContent()"
                                        class="custom-control-input" name="breakOccurence" id="breakOccurenceBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Set Occurence </label>
                                <div class="d-none" id="breakOccurenceContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select onchange="breakCountHour()" style="width: 5rem; height:1.5rem"
                                                id="breakSelectOccurence" name="breakSelectOccurence">
                                                <option value="">Select</option>
                                                <option value="1">Count</option>
                                                <option value="2">Hour</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <input class="mb-4 d-none" value="" name="breakOccurenceCount"
                                                id="breakOccurenceCount" placeholder="Enter" type="number"
                                                min="0" style="width: 3.2rem">
                                            <input class="mb-4 d-none" value="" name="breakOccurenceHour"
                                                id="breakOccurenceHour" type="text" placeholder="HH:MM"
                                                maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function breakCountHour() {
                                        // <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour" id="lateEntryOccurenceHour" type="text" placeholder="HH:MM" maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
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
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="breakDeductionPeriodContent()"
                                        class="custom-control-input" name="breakDeductSalary" id="breakDeductSalaryBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Mark Absent</label>
                                <div class="d-none" id="breakDeductionPeriodContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select style="width: 5rem; height:1.5rem" id="breakSelectAbsent"
                                                name="breakSelectAbsent">
                                                <option value="">Select</option>
                                                <option value="1">Half Day</option>
                                                <option value="2">Full Day</option>
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
                        extraTimeForBreakBtn();
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
        </div>

        <div class="col-xl-4">
            <div class="card">
                {{-- Overtime Rule  --}}
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a class="font-weight-semibold fs-18 ms-3">Overtime Rule</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the
                                    box
                                </p>
                            </div>
                            <div class="d-flex my-auto">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" onchange="overtimeContent()" name="overtime" onchange=""
                                        id="overtimeBtn" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>

                        <div class="my-3 mx-5" id="overtimeContent">

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" onchange="earlyOverTimeBtn()"
                                        name="allowEarlyOverTime" id="allowEarlyOverTimeBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Allow Overtime for early comming</label>
                                <div class="col-1">
                                    <input class="mb-4 d-none" value="" name="earlyOverTime" id="earlyOverTimeBtn"
                                        placeholder="Enter" type="number" min="0" style="width: 3.2rem">
                                </div>
                            </div>

                            <script>
                                function earlyOverTimeBtn() {
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
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="lateOverTimeBtn()" class="custom-control-input"
                                        name="allowLateOverTime" id="allowLateOverTimeBtn" value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Allow Overtime for late going</label>
                                <div class="col-1">
                                    <input class="mb-4 d-none" value="" name="lateOverTime" id="lateOverTimeBtn"
                                        placeholder="Enter" type="number" min="0" style="width: 3.2rem">
                                </div>
                            </div>

                            <script>
                                function lateOverTimeBtn() {
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

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="minMaxOverTimeBtnContent()"
                                        class="custom-control-input" name="minMaxOverTime" id="minMaxOverTimeBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Allow Overtime</label>
                                <div class="d-none" id="minMaxOverTimeBtnContent">
                                    <div class="d-flex my-1">
                                        <label class="form-label mx-1">Min</label>
                                        <div class="mx-2">
                                            <input class="mb-4" value="" name="minOverTime" id="minOverTimeBtn"
                                                placeholder="Enter" type="number" min="0" style="width: 3.2rem">
                                        </div>
                                        <label class="form-label mx-1">Max</label>
                                        <div class="mx-2">
                                            <input class="mb-4" value="" name="maxOverTime" id="maxOverTimeBtn"
                                                placeholder="Enter" type="number" min="0" style="width: 3.2rem">
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
                        lateOverTimeBtn();
                        earlyOverTimeBtn();
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
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the
                                    box
                                </p>
                            </div>
                            <div class="d-flex my-auto">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" onchange="missPunchContent()" name="missPunch" onchange=""
                                        id="missPunchBtn" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>

                        <div class="my-3 mx-5" id="missPunchContent">
                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="missPunchOccurenceContent()"
                                        class="custom-control-input" name="missPunchOccurence" id="missPunchOccurenceBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Set Occurence</label>
                                <div class="d-none" id="missPunchOccurenceContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select onchange="missPunchCountHour()" style="width: 5rem; height:1.5rem"
                                                id="missPunchSelectOccurence" name="missPunchSelectOccurence">
                                                <option value="">Select</option>
                                                <option value="1">Count</option>
                                                <option value="2">Hour</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <input class="mb-4 d-none" value="" name="missPunchOccurenceCount"
                                                id="missPunchOccurenceCount" placeholder="Enter" type="number"
                                                min="0" style="width: 3.2rem">
                                            <input class="mb-4 d-none" value="" name="missPunchOccurenceHour"
                                                id="missPunchOccurenceHour" type="text" placeholder="HH:MM"
                                                maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function missPunchCountHour() {
                                        // <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour" id="lateEntryOccurenceHour" type="text" placeholder="HH:MM" maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
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

                                        // alert('hello');
                                        if (missPunchOccurenceBtn.checked == true) {
                                            missPunchOccurenceContent.classList.remove('d-none');
                                        } else {
                                            missPunchOccurenceContent.classList.add('d-none');
                                            missPunchOccurenceCount.value = '';
                                        }
                                    }
                                </script>
                            </div>

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="missPunchDeductionPeriodContent()"
                                        class="custom-control-input" name="missPunchDeduction" id="missPunchDeductionBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Mark Absent</label>
                                <div class="d-none" id="missPunchDeductionPeriodContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select style="width: 5rem; height:1.5rem" id="missPunchSelectAbsent"
                                                name="missPunchSelectAbsent">
                                                <option value="">Select</option>
                                                <option value="1">Half Day</option>
                                                <option value="2">Full Day</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function missPunchDeductionPeriodContent() {
                                    var missPunchDeductionBtn = document.getElementById('missPunchDeductionBtn');
                                    var missPunchDeductionPeriodContent = document.getElementById('missPunchDeductionPeriodContent');

                                    // alert('hello');
                                    if (missPunchDeductionBtn.checked == true) {
                                        missPunchDeductionPeriodContent.classList.remove('d-none');
                                    } else {
                                        missPunchDeductionPeriodContent.classList.add('d-none');
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
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any of the
                                    box
                                </p>
                            </div>
                            <div class="d-flex my-auto">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" onchange="gatePassContent()" name="gatePass" onchange=""
                                        id="gatePassBtn" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>

                        <div class="my-3 mx-5" id="gatePassContent">

                            <div class="d-flex my-1">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="gatePassOccurenceContent()"
                                        class="custom-control-input" name="gatePassOccurence" id="gatePassOccurenceBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Set Occurence</label>
                                <div class="d-none" id="gatePassOccurenceContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select onchange="gatePassCountHour()" style="width: 5rem; height:1.5rem"
                                                id="gatePassSelectOccurence" name="gatePassSelectOccurence">
                                                <option value="">Select</option>
                                                <option value="1">Count</option>
                                                <option value="2">Hour</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <input class="mb-4 d-none" value="" name="gatePassOccurenceCount"
                                                id="gatePassOccurenceCount" placeholder="Enter" type="number"
                                                min="0" style="width: 3.2rem">
                                            <input class="mb-4 d-none" value="" name="gatePassOccurenceHour"
                                                id="gatePassOccurenceHour" type="text" placeholder="HH:MM"
                                                maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function gatePassCountHour() {
                                        // <input class="mb-4 d-none" value="" name="lateEntryOccurenceHour" id="lateEntryOccurenceHour" type="text" placeholder="HH:MM" maxlength="5" oninput="formatTime(this)" style="width: 3.2rem">
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
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" onchange="gatePassDeductionPeriodContent()"
                                        class="custom-control-input" name="gatePassDeduction" id="gatePassDeductionBtn"
                                        value="1">
                                    <span class="custom-control-label"></span>
                                </label>
                                <label class="form-label mx-1">Mark Absent</label>
                                <div class="d-none" id="gatePassDeductionPeriodContent">
                                    <div class="row">
                                        <div class="col-6">
                                            <select style="width: 5rem; height:1.5rem" id="gatePasSelectAbsent"
                                                name="gatePasSelectAbsent">
                                                <option value="">Select</option>
                                                <option value="1">Half Day</option>
                                                <option value="2">Full Day</option>
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
                        gatePassDeductionPeriodContent()
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
    </div>
@endsection