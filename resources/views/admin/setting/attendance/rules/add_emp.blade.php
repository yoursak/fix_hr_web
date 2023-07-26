@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Automation Rule / Late Entry Rule / Asign Employee
@endsection
@section('css')
    <style>

    </style>
@endsection
@section('settings')
    <div class="row row-sm">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="title">Assign Employee</h4>
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
                    <div class="col-sm-6 col-md-4 col-xl-3 d-flex">
                        <a class="modal-effect btn btn-primary btn-block mb-3" data-effect="effect-scale"
                            data-bs-toggle="modal" href="#modaldemo8">Save</a>
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
                        <li class="success mt-6">
                            <a target="_blank" href="javascript:void(0);"
                                class="font-weight-semibold fs-14 text-success ms-3">Set a rule value</a>
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


    {{-- finish form --}}
    <div class="modal fade" id="modaldemo8" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body m-5">
                    <h4 class="text-success">Rule Added Successfully !!</h4>
                    <button class="btn btn-success text-light" data-bs-dismiss="modal">
                        <a href="{{ url('settings/attendancesetting/automationrule') }}">Finish</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
