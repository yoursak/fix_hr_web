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
                    <div class="row">
                        <div class="col-2 col-xl-1 pe-0 my-auto">
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="col-5 col-xl-4 text-secondary my-auto">
                            <h5>General Shift</h5>
                        </div>
                        <div class="col-5 col-xl-3 text-muted my-auto">
                            <p>09:00 AM - 06:00 PM</p>
                        </div>
                        <div class="col-10 col-xl-3 text-muted my-auto">
                            <p>Assigned to 15 Employees</p>
                        </div>
                        <div class="col-2 col-xl-1 btn">
                            <div class="dropdown header-message" id="moredrop">
                                <div class="nav-link icon" data-bs-toggle="dropdown">
                                    <i class="fe fe-more-vertical fs-22"></i>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end animated">
                                    <div class="header-dropdown-list message-menu" id="message-menu">
                                        <div
                                            class=" dropdown-item d-flex align-items-center justify-content-around">
                                            <i class="fe fe-edit fs-18"></i>
                                            <i class="fe fe-trash-2 fs-18"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- add new shift --}}
    <div class="modal fade" id="attMode">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Add New Shift</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="">
                                        <label class="form-label">Shift Type</label>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <select name="country" class="form-control custom-select select2"
                                                data-placeholder="Select Country">
                                                <option label="Select Country"></option>
                                                <option value="br">Fixed Shift</option>
                                                <option value="cz">Rotational Shift</option>
                                                <option value="de">Open Shift</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="">
                                        <label class="form-label">Shift name</label>
                                    </div>
                                    <div class="pe-0">
                                        <input class="form-control mb-4" placeholder="Enter Shift Name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="">
                                        <label class="form-label">Shift Time</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 my-auto">
                                            <label for="from">FROM</label>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="input-group">
                                                <input class="form-control" id="tpBasic" placeholder="Set time"
                                                    type="time">
                                            </div>
                                        </div>
                                        <div class="col-xl-1 my-auto">
                                            <label for="to">TO</label>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="input-group">
                                                <input class="form-control" id="tpBasic" placeholder="Set time"
                                                    type="time">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex">
                                    <label for="additional"><b>Add Additional Details :</b></label>
                                    <label for="additional">
                                        <a class="modal-effect mx-3 text-primary" data-effect="effect-scale"
                                            data-bs-toggle="modal" href="#additionalModal"><b>Add </b></a>
                                    </label>
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
    {{-- additional details --}}
    <div class="modal fade" id="additionalModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Ne Shift</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="">
                                        <label class="form-label">Shift Type</label>
                                    </div>
                                    <div class="">
                                        <div class="form-group">
                                            <select name="country" class="form-control custom-select select2"
                                                data-placeholder="Select Country" id="shifttype">
                                                <option label="Select Country"></option>
                                                <option value="fs">Fixed Shift</option>
                                                <option value="rs">Rotational Shift</option>
                                                <option value="os">Open Shift</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="shiftname">
                                <div class="row">
                                    <div class="">
                                        <label class="form-label">Shift name</label>
                                    </div>
                                    <div class="pe-0">
                                        <input class="form-control mb-4" placeholder="Enter Shift Name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none" id="shifttime">
                                <div class="row">
                                    <div class="">
                                        <label class="form-label">Shift Time</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 my-auto">
                                            <label for="from">FROM</label>
                                        </div>
                                        <div class="col-xl-2">
                                            <div class="input-group">
                                                <input class="form-control" id="tpBasic" placeholder="Set time"
                                                    type="time">
                                            </div>
                                        </div>
                                        <div class="col-xl-1 my-auto">
                                            <label for="to">TO</label>
                                        </div>
                                        <div class="col-xl-2">
                                            <div class="input-group">
                                                <input class="form-control" id="tpBasic" placeholder="Set time"
                                                    type="time">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none" id="workhour">
                                <div class="row">
                                    <div class="col-3">
                                        <label class="form-label">Work Hours</label>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group">
                                            <input class="form-control" id="tpBasic" placeholder="Set time"
                                                type="time">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between d-none" id="addbreak">
                                    <label for="additional"><b class="d-none" id="unpaidbreaklabel">Unpaid Break :</b></label>
                                    <label for="additional">
                                        <a class="modal-effect mx-3 text-primary d-none" id="unpaidbreak"><b>Add</b></a>
                                    </label>
                                    <table class="table card-table table-vcenter text-nowrap mb-0 border-0 d-none" id="unpaidbreaktbl">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <input class="form-control" id="tpBasic" placeholder="Set time"
                                                            type="time">
                                                    </div>
                                                </td>
                                                <td>
                                                    <span><b>Total Payable Hours</b></span><br/>
                                                    <span>09:00 hrs</span>
                                                </td>
                                                <td>
                                                    <span><b class="text-primary btn" id="unpaiddelete">Delete</b></span><br/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive d-none" id="additionaltbl">
                            <table class="table card-table table-vcenter text-nowrap mb-0 border-0">
                                <thead>
                                    <tr>
                                        <th>Relational Shift Name</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Unpaid Break</th>
                                        <th>Net Payable Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Enter Shift Name"
                                                    type="text">
                                            </div>
                                        </th>
                                        <td>
                                            <div class="input-group">
                                                <input class="form-control" id="tpBasic" placeholder="Set time"
                                                    type="time">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input class="form-control" id="tpBasic" placeholder="Set time"
                                                    type="time">
                                            </div>
                                        </td>
                                        <td>
                                            <b class="btn text-primary" id="addtime">ADD</b>
                                            <input class="form-control d-none" id="breaktime" placeholder="Set time" type="time">
                                        </td>
                                        <td>00:00 Hrs</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- table-responsive -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="savechanges">Save changes</button> <button class="btn btn-light"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
