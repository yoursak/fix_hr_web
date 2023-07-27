
@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Attendance on Holiday
@endsection
@section('settings')
    <div class="row row-sm">
        <div class="">
            <div class="card">
                <div class="tab-menu-heading p-0 border-0">
                    <div class="tabs-menu1 px-3">
                        <ul class="nav">
                            <li><a href="#tab-7" class="active" data-bs-toggle="tab">Rules</a></li>
                            <li><a href="#tab-8" class="text-muted">Employee Selection</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-15 ms-3">Allow Attendance on paid holiday</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <p class="my-auto text-muted">14 Employee Asigned</p>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('settings/attendancesetting/automationrule/lateentry')}}" data-bs-target="#paidHoliday" data-bs-toggle="modal">Assign Employee</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-15 ms-3">Camp Off Leave</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <p class="my-auto text-muted">14 Employee Asigned</p>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('settings/attendancesetting/automationrule/lateentry')}}"  data-bs-target="#campOff" data-bs-toggle="modal">Assign Employee</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a target="_blank" href="#"
                                    class="font-weight-semibold fs-15 ms-3">Do NOT allow Attendance on paid holiday</a>
                                <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You can define rule by selecting any
                                    of the box</p>
                            </div>
                            <p class="my-auto text-muted">14 Employee Asigned</p>
                            <div class="d-flex my-auto">
                                <h6 class="text-primary btn"><a  href="{{url('settings/attendancesetting/automationrule/lateentry')}}"  data-bs-target="#donotpaidHoliday" data-bs-toggle="modal">Assign Employee</a></h6>
                                <i class="fa fa-angle-right fs-22"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- paid holiday modal --}}
    <div class="modal fade" id="paidHoliday">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Allow Attendance on paid holiday</h6>
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
    {{-- camp off leave modal --}}
    <div class="modal fade" id="campOff">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Camp Off Leave</h6>
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
    {{-- do not paid holiday modal --}}
    <div class="modal fade" id="donotpaidHoliday">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Do NOT allow Attendance on paid holiday</h6>
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
@endsection
