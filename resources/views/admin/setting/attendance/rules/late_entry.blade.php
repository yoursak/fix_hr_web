@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Automation Rule / Late Entry Rule
@endsection
@section('css')
    <style>

    </style>
@endsection
@section('settings')
    <div class="row row-sm">
        <div class="col-lg-8">
            <div class="card">
                <div class="tab-menu-heading table_tabs mt-2 p-0 ">
                    <div class="tabs-menu1">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li><a href="#tab6" class="active" data-bs-toggle="tab">Rules</a></li>
                            <li><a href="#tab7" data-bs-toggle="tab">Employee Selections</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body table_tabs1 p-0 border-0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab6">
                            <div class="table-responsive recent_jobs pt-2 pb-2 ps-2 pe-2 card-body">
                                <div class="custom-controls-stacked m-5">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="example-checkbox1"
                                            value="option1" id="rule1">
                                        <span class="custom-control-label" style="color: #B07C9E">Deduct
                                            Salary if employee is late by more than</span>
                                    </label>
                                    <div class="row d-none" id="main_elem">
                                        <div id="elem">
                                            <div class="row" id="more_time_range">
                                                <div class="col-xl-5">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <span class="feather feather-clock"></span>
                                                            </div>
                                                        </div>
                                                        <input class="form-control" id="tpBasic" placeholder="Set time"
                                                            type="text">
                                                    </div>
                                                </div>
                                                <div class="col-xl-5">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select name="somename" class="form-control SlectBox"
                                                                onclick="console.log($(this).val())"
                                                                onchange="console.log('change is firing')">
                                                                <!--placeholder-->
                                                                <option title="Volvo is a car" value="volvo">Per Minute
                                                                    Salary</option>
                                                                <option value="saab">Saab</option>
                                                                <option value="mercedes">Mercedes</option>
                                                                <option value="audi">Audi</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2">
                                                    <a href="javascript:void(0);" class="action-btns" id="remove_elem"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i
                                                            class="feather feather-trash-2 text-danger"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="btn" id="add_elem"><b class="text-primary">Add Time Range</b></p>
                                            <label class="custom-control custom-checkbox mx-5">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox1"
                                                    value="option1" id="o_check">
                                                <span class="custom-control-label" id="rule1"><b
                                                        style="color: #473441">Set Ocurence</b></span>
                                            </label>
                                        </div>
                                        <div class="row mx-5 d-none" id="rowMx">
                                            <div class="col-xl-5">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <select name="somename" class="form-control SlectBox"
                                                            id="Occurrence">
                                                            <!--placeholder-->
                                                            <option title="Volvo is a car" value="count">Count</option>
                                                            <option value="hour">Hour</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5" id="o_count">
                                                <div class="input-group">
                                                    <input class="form-control" id="tpBasic" placeholder="Set Count"
                                                        type="number">
                                                </div>
                                            </div>
                                            <div class="col-xl-5 d-none" id="o_time">
                                                <div class="input-group">
                                                    <input class="form-control" id="tpBasic" placeholder="Set time"
                                                        type="time">
                                                </div>
                                            </div>
                                        </div>
                                    </div><a href="{{ url('settings/attendancesetting/automationrule/asignemp') }}"
                                        class="btn btn-primary btn-sm m-3 d-none" id="next_btn">Save and Continoue</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="tab7">
                            <div class="table-responsive recent_jobs pt-2 pb-2 ps-2 pe-2 card-body">
                                <table class="table mb-0 text-nowrap">
                                    <tbody>
                                        <tr class="border-bottom">
                                            <td>
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="custom-switch-checkbox"
                                                        class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="me-3 mt-0 mt-sm-1 d-block">
                                                        <h6 class="mb-0">Faith Harris</h6>
                                                        <div class="clearfix"></div>
                                                        <small class="text-muted">UI designer</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-start fs-13">+91 1234567890</td>
                                            <td class="text-end">
                                                <a href="javascript:void(0);" class="action-btns"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Mail"><i
                                                        class="feather feather-edit  text-primary"></i></a>
                                                <a href="javascript:void(0);" class="action-btns"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i
                                                        class="feather feather-trash-2 text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body pt-2">
                    <ul class="timeline ">
                        <li class="success mt-6">
                            <a target="_blank" href="javascript:void(0);"
                                class="font-weight-semibold text-success fs-14 ms-3">Create your first rule</a>
                            <p class="mb-0 pb-0 fs-12 text-success ms-3 mt-1">You can define rule by selecting any of the
                                box
                            </p>
                        </li>
                        <li class="primary mt-6">
                            <a target="_blank" href="javascript:void(0);"
                                class="font-weight-semibold fs-14 text-muted ms-3">Set a rule value</a>
                            <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">set a value for your rule type</p>
                        </li>
                        <li class="pink mt-6">
                            <a target="_blank" href="javascript:void(0);"
                                class="font-weight-semibold fs-14 text-muted ms-3">Assign Employee</a>
                            <p class="mb-0 pb-0 text-muted fs-12  ms-3 mt-1">Select thwe that you want the rule to be
                                assigned to.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
