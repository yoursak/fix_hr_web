@extends('admin.setting.setting')
@section('subtitle')
    Attendance
@endsection
@section('settings')
    <div class="row row-sm">
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="fe fe-settings"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Attendance Mode</h5>
                            </a>
                            <p>Face Id, QR Code and Location.</p>
                            <a href="#" data-bs-target="#attMode" data-bs-toggle="modal">Change Settings <i
                                    class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-secondary-transparent text-secondary border-secondary"><i
                                        class="fe fe-unlock"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Attendance Employee Access</h5>
                            </a>
                            <p>20 Employees</p>
                            <a href="#" data-bs-target="#EmployeeAccess" data-bs-toggle="modal">Change Settings <i
                                    class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-danger-transparent text-danger border-danger"><i
                                        class="fe fe-clock"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Shift Settings</h5>
                            </a>
                            <p>One Fixed Shift</p>
                            <a href="{{ url('settings/attendancesetting/createshift') }}">Change Settings <i
                                    class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-warning-transparent text-warning border-warning"><i
                                        class="fe fe-grid"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Automation Rules</h5>
                            </a>
                            <p>Track Late Entry, Early Out, Overtime, and Breaks.</p>
                            <a href="{{ url('settings/attendancesetting/automationrule') }}">Change Settings <i
                                    class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-success-transparent text-success border-success"><i
                                        class="fe fe-monitor"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Daily Work Entry</h5>
                            </a>
                            <p>Assign to Employee</p>
                            <a href="#" data-bs-target="#workAccess" data-bs-toggle="modal">Change Settings <i
                                    class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                        class="fe fe-map"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Track In & Out Time</h5>
                            </a>
                            <p>Punch Out Required</p>
                                <a href="#" data-bs-target="#ioModal" data-bs-toggle="modal">Change Settings <i
                                    class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-info-transparent text-info border-info"><i
                                        class="fe fe-umbrella"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Attendance On Holiday</h5>
                            </a>
                            <p>Attendance on Holidays, Comoff.</p>
                            <a href="#" data-bs-target="#ioModal" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2 col-sm-2 col-md-12">
                            <div class="mt-2 mb-4">
                                <span class="settings-icon bg-success-transparent text-success border-success"><i
                                        class="fe fe-user-x"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-10 col-sm-10 col-md-12">
                            <a href="#">
                                <h5 class="mb-1 text-dark">Mark Absent on Previous Day</h5>
                            </a>
                            <p>Not Activated.</p>
                            <a href="#">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- attendance mode modal --}}
    <div class="modal fade" id="attMode">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header border-0">
                    <h4 class="modal-title">Attendance Mode</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
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
                                        <label class="form-label">Mark Present By Default</label>
                                        <span class="d-block fs-12 text-muted">Default auto present, can be changed
                                            Manually</span>
                                    </div>
                                    <div class="col-xl-1 pe-0">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="custom-switch-checkbox"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header  border-0">
                            <h6 class="card-title">Manual Attendance</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xl-11">
                                        <label class="form-label">Manual Attendance</label>
                                        <span class="d-block fs-12 text-muted">Ut enim ad minim veniam, quis nostrud
                                            exercitation</span>
                                    </div>
                                    <div class="col-xl-1 pe-0">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="custom-switch-checkbox"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xl-11">
                                        <label class="form-label">Employee Attendance with Location</label>
                                        <span class="d-block fs-12 text-muted">Ut enim ad minim veniam, quis nostrud
                                            exercitation</span>
                                    </div>
                                    <div class="col-xl-1 pe-0">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="custom-switch-checkbox"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xl-11">
                                        <label class="form-label">Employee Attendace with Selfie & Location</label>
                                        <span class="d-block fs-12 text-muted">Ut enim ad minim veniam, quis nostrud
                                            exercitation</span>
                                    </div>
                                    <div class="col-xl-1 pe-0">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="custom-switch-checkbox"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save changes</button> <button class="btn btn-light"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- self attendance access modal --}}
    <div class="modal fade" id="EmployeeAccess">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Self Attendance Access</h6>
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
    </div>

    {{-- daily work entry modal --}}
    <div class="modal fade" id="workAccess">
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
    </div>

    {{-- attendance mode modal --}}
    <div class="modal fade" id="ioModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header border-0">
                    <h4 class="modal-title">Attendance Mode</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
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
                                        <span class="d-block fs-12 text-muted">Record both In & Out time for all employee</span>
                                    </div>
                                    <div class="col-xl-1 pe-0">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="custom-switch-checkbox"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xl-11">
                                        <label class="form-label">No Attendance without punch</label>
                                        <span class="d-block fs-12 text-muted">Punch out is required to mark attendance</span>
                                    </div>
                                    <div class="col-xl-1 pe-0">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="custom-switch-checkbox"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save changes</button> <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--Mark Absent on Previous Day modal --}}
@endsection
