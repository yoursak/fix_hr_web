@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Create Shift
@endsection
@section('settings')
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Create Shift</h4>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="btn-list d-flex">
                                <a class="modal-effect btn btn-primary btn-block mx-3" data-effect="effect-scale"
                                    data-bs-toggle="modal" href="#additionalModal" id="btnOpen">Add New shift</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @foreach ($Shifts as $shift)
                        <div class="row">
                            <div class="col-12 col-xl-4 text-secondary my-auto">
                                <h5>{{ $shift->shift_name }}</h5>
                            </div>
                            <div class="col-5 col-xl-3 text-muted my-auto">
                                <p>{{ $shift->shift_from }} - {{ $shift->shift_to }}</p>
                            </div>
                            <div class="col-5 col-xl-3 text-muted my-auto">
                                <p>Assigned to 15 Employees</p>
                            </div>
                            <div class="col-2 col-xl-1 btn">
                                <div class="dropdown header-message" id="moredrop">
                                    <div class="nav-link icon" data-bs-toggle="dropdown">
                                        <i class="fe fe-more-vertical fs-22"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end animated">
                                        <div class="header-dropdown-list message-menu" id="message-menu">
                                            <div class=" dropdown-item d-flex align-items-center justify-content-around">
                                                <i class="fe fe-edit fs-18"></i>
                                                <i class="fe fe-trash-2 fs-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- add new shift --}}

    <div class="modal fade" id="additionalModal">
        <div class="modal-dialog modal-lg" role="document">
            {{-- <form action="{{ route('add.shift') }}" method="post"> --}}
            {{-- @csrf --}}
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Shift</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Shift Type</label>
                                <select onchange="load(this.value)" name="shiftType"
                                    class="form-control custom-select select2" data-placeholder="Select Country"
                                    id="shifttype" required>
                                    <option label="Select Country"></option>
                                    <option value="fixed">Fixed Shift</option>
                                    <option value="rotational">Rotational Shift</option>
                                    <option value="open">Open Shift</option>
                                </select>
                            </div>
                            
                            <div class="form-group d-none" id="shifttime">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Shift Name</label>
                                        <input class="form-control mb-4" placeholder="Enter Shift Name" type="text" name="shiftName">
                                    </div>
                                    <div class="col-xl-3">
                                        <label class="form-label">Start Time</label>
                                        <input class="form-control" id="start_time" onchange="myFunction()" placeholder="Set time" type="time" name="fixShiftStart">
                                    </div>
                                    <div class="col-xl-3">
                                        <label class="form-label">End Time</label>
                                        <input class="form-control" id="end_time" onchange="myFunction()" placeholder="Set time" type="time" name="fixShiftEnd">
                                    </div>
                                    <div class="col-xl-3">
                                        <label class="form-label">Break(Min)</label>
                                        <input class="form-control" id="break_time" onchange="myFunction()" placeholder="Set time" type="number" name="fixShiftBreak">
                                    </div>
                                    <div class="col-xl-3">
                                        <label class="form-label">Break is</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" id="paid" class="custom-control-input" onchange="myFunction()" name="example-radios" value="option1" checked>
                                                    <span class="custom-control-label">Paid</span>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" id="unpaid" class="custom-control-input" onchange="myFunction()" name="example-radios" value="option1" checked>
                                                    <span class="custom-control-label">Unpaid</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                               function myFunction() {
                                let start_time = document.getElementById("start_time").value;
                                let end_time = document.getElementById("end_time").value;
                                let break_time = document.getElementById("break_time").value;
                                // Example time inputs
                                const startTime = start_time;
                                const endTime = end_time;
                                const breakTime = break_time; // in minutes

                                // Parse the time inputs
                                const [startHours, startMinutes] = startTime.split(":").map(Number);
                                const [endHours, endMinutes] = endTime.split(":").map(Number);

                                // Calculate the time difference in minutes
                                let differenceMinutes = (endHours * 60 + endMinutes) - (startHours * 60 + startMinutes);

                                // Ensure the differenceMinutes is positive
                                if (differenceMinutes < 0) {
                                differenceMinutes += 1440; // 24 hours in minutes
                                }


                                if($('#unpaid').is(':checked')){
                                    // Subtract break time
                                differenceMinutes -= breakTime;
                                }

                                // Ensure the result is positive
                                if (differenceMinutes < 0) {
                                differenceMinutes = 0;
                                }

                                // Calculate the hours and minutes for the result
                                const resultHours = Math.floor(differenceMinutes / 60);
                                const resultMinutes = differenceMinutes % 60;

                                // Format the result as "HH:MM"
                                const formattedResult = `${String(resultHours).padStart(2, '0')}:${String(resultMinutes).padStart(2, '0')}`;

                                console.log(`Result: ${formattedResult}`);
                                }
                            </script>
                            <div class="form-group d-none" id="workhour">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="form-label">Hour</label>
                                        <input class="form-control m-0" placeholder="Set" type="number" name="openHour">
                                    </div>
                                    <div class="col-xl-3">
                                        <label class="form-label">Minutes</label>
                                        <input class="form-control" placeholder="Set" type="number" name="openMin">
                                    </div>
                                    <div class="col-xl-3">
                                        <label class="form-label">Break(Min)</label>
                                        <input class="form-control" placeholder="Set" type="number" name="openBreak">
                                    </div>
                                    <div class="col-xl-3">
                                        <label class="form-label">Total Hour</label>
                                        <span>09:00 Hrs</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-none" id="shiftname2">
                                <label class="form-label"> Rotetional Shift Name</label>
                                <input class="form-control mb-4" placeholder="Enter Shift Name" type="text" name="rotationalShiftName">
                            </div>

                            <div class="table-responsive d-none" id="additionaltbl">
                                <div class="row">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div id="education_fields"></div>
                                            <div class="col-sm-3 nopadding">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="Shiftname" name="Shiftname[]" value="" placeholder="Shift Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 nopadding">
                                                <div class="form-group">
                                                    <input type="time" class="form-control" id="Major" name="from[]" value="" placeholder="Major">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 nopadding">
                                                <div class="form-group">
                                                    <input type="time" class="form-control" id="Degree" name="to[]" value="" placeholder="Degree">
                                                </div>
                                            </div>

                                            <div class="col-sm-3 nopadding">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="educationDate" placeholder="Break in min" name="break[]"/>
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-success" type="button" onclick="education_fields()">
                                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- table-responsive -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" id="savechanges">Save changes</button>
                    <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            {{-- </form> --}}
        </div>

        <script>
            function load(value) {
                // alert(value);
                if (value == 'fixed') {
                    $('#shiftname').removeClass('d-none');
                    $('#shiftname2').addClass('d-none');
                    $('#shifttime').removeClass('d-none');
                    $('#unpaidbreaklabel').removeClass('d-none');
                    $('#unpaidbreak').removeClass('d-none');
                    $('#workhour').addClass('d-none');
                    $('#additionaltbl').addClass('d-none');
                } else if (value == 'rotational') {
                    $('#shiftname').addClass('d-none');
                    $('#shiftname2').removeClass('d-none');
                    $('#shifttime').addClass('d-none');
                    $('#unpaidbreaklabel').addClass('d-none');
                    $('#unpaidbreak').addClass('d-none');
                    $('#workhour').addClass('d-none');
                    $('#additionaltbl').removeClass('d-none');
                } else {
                    $('#shiftname2').addClass('d-none');
                    $('#shiftname').removeClass('d-none');
                    $('#shifttime').addClass('d-none');
                    $('#unpaidbreaklabel').addClass('d-none');
                    $('#unpaidbreak').addClass('d-none');
                    $('#workhour').removeClass('d-none');
                    $('#additionaltbl').addClass('d-none');
                }
            }

            var room = 1;

            function education_fields() {
                room++;
                var objTo = document.getElementById('education_fields')
                var divtest = document.createElement("div");
                divtest.setAttribute("class", "form-group row removeclass" + room);
                var rdiv = 'removeclass' + room;
                divtest.innerHTML =
                    '<div class="col-sm-3 nopadding">' +
                    '<div class="form-group">' +
                    '<input type="text" class="form-control" id="Shiftname" name="Shiftname[]" value="" placeholder="Shift name">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3 nopadding">' +
                    '<div class="form-group">' +
                    '<input type="time" class="form-control" id="Major" name="from[]" value="" placeholder="Major">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3 nopadding">' +
                    '<div class="form-group">' +
                    '<input type="time" class="form-control" id="Degree" name="to[]" value="" placeholder="Degree">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3 nopadding">' +
                    '<div class="form-group">' +
                    '<div class="input-group">' +
                    '<input type="text" class="form-control" id="educationDate" placeholder="Break in min" name="rotetional_break[]">' +
                    '<div class="input-group-btn">' +
                    '<button class="btn btn-danger" type="button" onclick="remove_education_fields(' + room + ');">' +
                    '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>' +
                    '</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="clear"></div>';


                objTo.appendChild(divtest)
            }

            function remove_education_fields(rid) {
                $('.removeclass' + rid).remove();
            }
        </script>
    </div>
@endsection
