@extends('admin.setting.setting')
@section('subtitle')
    Business / Holiday Policy Setting
@endsection

@section('css')
@endsection
@section('settings')
    <div class="page-header d-md-flex d-block">
        @php
            $HolidayTemplate = App\Helpers\Central_unit::Template();
            $Holiday = App\Helpers\Central_unit::Holiday();
            //    dd($HolidayTemplate);
            $j = 0;
        @endphp
        <div class="page-leftheader">
            <div class="page-title">Holiday Templates</div>
            <p class="text-muted">Create Template to give automatic paid leaves to staff on public holidays</p>
        </div>
        <div class="page-rightheader ms-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" class="btn btn-outline-dark" id="newTempFormBtn" onclick="myFunc()">Create
                            Templates</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form action="{{ route('add.holiday') }}" method="post">
            @csrf
            <div class="card d-none" id="newTemplate">
                <div class="card-body" id="TempName">
                    <div class="row">
                        <div class="col-md-12 col-xl-4">
                            <div class="form-group">
                                <p class="form-label">Template Name</p>
                                <input type="text" class="form-control header-text" placeholder="Enter Template Name"
                                    aria-label="text" tabindex="1" name="temp_name" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-6">
                            <p class="form-label">Annual Holiday Period</p>
                            <div class="form-group d-flex">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="date"
                                        name="temp_from" required>
                                </div>
                                <label class="form-label mx-3 my-auto">To</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY" type="date"
                                        name="temp_to" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="TempForm">
                    <div class="row">
                        <div class="card-header  border-0">
                            <h4 class="title">Holidays</h4>
                            <div class="page-rightheader ms-auto">
                                <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                    <div class="btn-list d-flex">
                                        <a class="btn btn-block mb-3" id="addField"><b class="text-primary">Add New
                                                Holiday</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="holidayCard">
                            <div class="row">
                                <div class="col-xl-5 my-auto d-none d-xl-block">
                                    <p class="my-auto ">Holiday Name</p>
                                </div>
                                <div class="col-xl-6 my-auto d-none d-xl-block">
                                    <p class="my-auto ">Holiday Date</p>
                                </div>
                            </div>
                            <div class="row my-auto py-2" id="addedForm0">
                                <div class="col-5 col-xl-5 my-auto">
                                    <input type="text" class="form-control bg-muted" id="inputName"
                                        placeholder="Holiday Name" name="holiday_name[]" required>
                                </div>
                                <div class="col-5 col-xl-4 my-auto">
                                    <div class="form-group d-flex my-auto">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                type="date" name="holiday_date[]" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 col-xl-1 my-auto">
                                    <div class="d-flex justify-content-end">
                                        <a class="action-btns remove_btn" id="0" title="Delete"
                                            onclick="deleteElem(this.id)"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" text-end">
                        <button type="reset" class="btn btn-outline-dark" id="tempSave" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Reset">Reset</button>
                        <button type="submit" class="btn btn-outline-success" id="tempSave" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Save">Apply Template</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="card">
            @foreach ($HolidayTemplate as $template)
                @php
                    // dd($template);
                    $i = 0;
                    foreach ($Holiday->where('template_id', $template->temp_id) as $holiday) {
                        $i++;
                    }
                @endphp
                <div class="card-body border-bottum-0">
                    <div class="row">
                        <div class="col-8 col-xl-3 my-auto">
                            <h5 class="my-auto">{{ $template->temp_name }}</h5>
                        </div>
                        <div class="col-4 col-xl-2 my-auto">
                            <p class="my-auto text-muted">{{ $i }} Holidays</p>
                        </div>
                        <div class="col-12 col-xl-3 my-auto">
                            <p class="my-auto text-muted">Applied to 14 Employees</p>
                        </div>
                        <div class="col-8 col-xl-2">
                            <p class="my-auto text-muted">
                                <a class="btn text-primary" id="manageEmp{{ $template->temp_id }}"
                                    onclick="manageemp(this.id)"><b>Manage Employee
                                        List</b></a>
                                <a class="btn btn-outline-success d-none" id="saveemp{{ $template->temp_id }}"
                                    onclick="saveeemp(this.id)"><b>Apply</b></a>
                            </p>
                        </div>
                        <div class="col-4 col-xl-2">
                            <p class="my-auto text-muted text-end">
                                <a class="btn text-primary" id="editTempBtn{{ $template->temp_id }}"
                                    onclick="editTemplate(id)"><b>Edit Template</b></a>
                                <a class="btn btn-outline-success d-none" id="applyTempBtn{{ $template->temp_id }}"
                                    href="#" onclick="saveTemplate(id)"><b>Apply</b></a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body border-bottum-0 d-none" style="height: 20rem; overflow:scroll"
                    id="emplist{{ $template->temp_id }}">
                    <table class="table mb-0 text-nowrap">
                        <tbody>
                            <tr class="border-bottom">
                                <td>
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
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
                                    <a class="action-btns" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Mail"><i class="feather feather-edit  text-primary"></i></a>
                                    <a class="action-btns" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                

                    <div class="card-body d-none" id="searchTemp{{ $template->temp_id }}">
                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <p class="form-label">Template Name</p>
                                    <input type="text" class="form-control header-search" placeholder="Template Name"
                                        value="{{ $template->temp_name }}" name="temp_name">
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                <p class="form-label">Annual Holiday Period</p>
                                <div class="form-group d-flex">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="feather feather-calendar"></i>
                                            </div>
                                        </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                            type="date" value="{{ $template->temp_from }}" name="temp_from">
                                    </div>
                                    <label class="form-label mx-3 my-auto">To</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="feather feather-calendar"></i>
                                            </div>
                                        </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                            type="date" value="{{ $template->temp_to }}" name="temp_to">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-none" id="editTempForm{{ $template->temp_id }}">
                        <div class="row">
                            <div class="card-header  border-0">
                                <h4 class="title">Holidays</h4>
                                <div class="page-rightheader ms-auto">
                                    <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                        <div class="btn-list d-flex">
                                            <a class="modal-effect btn btn-block mb-3" id="addField2"><b class="text-primary">Add New Holiday</b></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="holidayCard2">
                                <div class="row">
                                    <div class="col-xl-5 my-auto d-none d-xl-block">
                                        <p class="my-auto ">Holiday Name</p>
                                    </div>
                                    <div class="col-xl-6 my-auto d-none d-xl-block">
                                        <p class="my-auto ">Holiday Date</p>
                                    </div>
                                </div>
                                @foreach ($Holiday->where('template_id', $template->temp_id) as $holiday)
                                    <div class="row my-auto py-2" id="addedForm2{{$j++}}">
                                        <div class="col-5 col-xl-5 my-auto">
                                            <input type="text" class="form-control bg-muted" id="inputName"
                                                placeholder="Holiday Name" value="{{ $holiday->holiday_name }}" name="holiday_name[]">
                                        </div>
                                        <div class="col-5 col-xl-4 my-auto">
                                            <div class="form-group d-flex my-auto">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="feather feather-calendar"></i>
                                                        </div>
                                                    </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                        type="date" value="{{ $holiday->holiday_date }}" name="holiday_date[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 col-xl-1 my-auto">
                                            <div class="d-flex justify-content-end">
                                                <a class="action-btns" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" id="D{{$j}}" onclick="deleteElem2(this.id)"><i class="feather feather-trash-2 text-danger"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Apply Changes</a>
    </div>
@endsection
