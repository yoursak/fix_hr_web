@extends('admin.pagelayout.master')
@section('title')
    Business / Holiday Policy Setting
@endsection
  
@section('content')
<style>
    .nav-link.icon {
        line-height: 0;
    }

    .modal-header,
    .modal-footer {
        background-color: #f8f8ff;
        /* color: #fff; */
    }

    .modal-open {
        overflow: hidden
    }

    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: auto
    }

    .modal {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1050;
        display: none;
        width: 100%;
        height: 100%;
        overflow: hidden;
        outline: 0
    }

    .modal-dialog {
        position: relative;
        width: auto;
        margin: .5rem;
        pointer-events: none
    }

    .modal.fade .modal-dialog {
        transition: -webkit-transform .3s ease-out;
        transition: transform .3s ease-out;
        transition: transform .3s ease-out, -webkit-transform .3s ease-out;
        -webkit-transform: translate(0, -50px);
        transform: translate(0, -50px)
    }

    @media (prefers-reduced-motion:reduce) {
        .modal.fade .modal-dialog {
            transition: none
        }
    }

    .modal.show .modal-dialog {
        -webkit-transform: none;
        transform: none
    }

    .modal.modal-static .modal-dialog {
        -webkit-transform: scale(1.02);
        transform: scale(1.02)
    }

    .modal-dialog-scrollable {
        display: -ms-flexbox;
        display: flex;
        max-height: calc(100% - 1rem)
    }

    .modal-dialog-scrollable .modal-content {
        max-height: calc(100vh - 1rem);
        overflow: hidden
    }

    .modal-dialog-scrollable .modal-footer,
    .modal-dialog-scrollable .modal-header {
        -ms-flex-negative: 0;
        flex-shrink: 0
    }

    .modal-dialog-scrollable .modal-body {
        overflow-y: auto
    }

    .modal-dialog-centered {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        min-height: calc(100% - 1rem)
    }

    .modal-dialog-centered::before {
        display: block;
        height: calc(100vh - 1rem);
        height: -webkit-min-content;
        height: -moz-min-content;
        height: min-content;
        content: ""
    }

    .modal-dialog-centered.modal-dialog-scrollable {
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        height: 100%
    }

    .modal-dialog-centered.modal-dialog-scrollable .modal-content {
        max-height: none
    }

    .modal-dialog-centered.modal-dialog-scrollable::before {
        content: none
    }

    .modal-content {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: .3rem;
        outline: 0
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: #000
    }

    .modal-backdrop.fade {
        opacity: 0
    }

    .modal-backdrop.show {
        opacity: .5
    }

    .modal-header {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: calc(.3rem - 1px);
        border-top-right-radius: calc(.3rem - 1px)
    }

    .modal-header .close {
        padding: 1rem 1rem;
        margin: -1rem -1rem -1rem auto
    }

    .modal-title {
        margin-bottom: 0;
        line-height: 1.5
    }

    .modal-body {
        position: relative;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1rem
    }

    .modal-footer {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: end;
        justify-content: flex-end;
        padding: .75rem;
        border-top: 1px solid #dee2e6;
        border-bottom-right-radius: calc(.3rem - 1px);
        border-bottom-left-radius: calc(.3rem - 1px)
    }

    .modal-footer>* {
        margin: .25rem
    }

    .modal-scrollbar-measure {
        position: absolute;
        top: -9999px;
        width: 50px;
        height: 50px;
        overflow: scroll
    }

    @media (min-width:576px) {
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto
        }

        .modal-dialog-scrollable {
            max-height: calc(100% - 3.5rem)
        }

        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 3.5rem)
        }

        .modal-dialog-centered {
            min-height: calc(100% - 3.5rem)
        }

        .modal-dialog-centered::before {
            height: calc(100vh - 3.5rem);
            height: -webkit-min-content;
            height: -moz-min-content;
            height: min-content
        }

        .modal-sm {
            max-width: 300px
        }
    }

    @media (min-width:992px) {

        .modal-lg,
        .modal-xl {
            max-width: 800px
        }
    }

    @media (min-width:1200px) {
        .modal-xl {
            max-width: 1140px
        }
    }
</style>  

<div class=" p-0 mt-3">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/settings/business')}}">Settings</a></li>
        <li><a href="{{ url('admin/settings/business')}}">Business Setting</a></li>
        <li class="active"><span><b>Holiday Templates</b></span></li>
    </ol>
</div>
<div class="page-header d-md-flex d-block">
        @php
            $centralUnit = new App\Helpers\Central_unit();
            $HolidayTemplate = $centralUnit->Template();
            $Holiday = $centralUnit->Holiday();
            // dd($HolidayTemplate);
            
            $j = 0;
        @endphp
        <div class="page-leftheader">
            <div class="page-title">Holiday Templates</div>
            <p class="text-muted m-0">Create Template to give automatic paid leaves to staff on public holidays</p>
        </div>
        <div class="page-rightheader ms-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplate">Create
                            Templates</button>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Holiday Policy List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-10">S.No.</th>
                                <th class="border-bottom-0">Holiday Policy Name</th>

                                <th class="border-bottom-0">Numbers of Holiday</th>

                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $j = 1;
                            @endphp
                            @foreach ($HolidayTemplate as $item)
                                <tr>
                                    <td class="font-weight-semibold">{{ $j++ }}.</td>
                                    <td class="font-weight-semibold">{{ $item->temp_name }}</td>
                                    <td class="font-weight-semibold"><?php 
                                    $load= $centralUnit->GetPolicysCount($item->temp_id);
                                    $ll=$load[0];
                                    echo $ll; 
                                    ?>
                                    </td>
                                    <td>
                                         <a class="btn action-btns btn-primary btn-icon btn-sm" href="javascript:void(0);" id="editTempBtn{{ $item->temp_id }}"
                                            onclick="openEditModel(this)"  data-bs-toggle="modal"
                                            data-bs-target="#updateTemplate{{ $item->temp_id }}">
                                            <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                data-original-title="View/Edit"></i>
                                        </a>

                                        {{-- <a class="btn btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                            onclick="ItemDeleteModel(this)" data-id='<?= //$item->id ?>'
                                            data-weekly_name='<?= //$item->name ?>' data-bs-toggle="modal"
                                            data-bs-target="#editDeleteModel"><i class="feather feather-trash"></i>
                                        </a> --}}
                                        {{-- <a class="btn text-primary" id="editTempBtn{{ $item->temp_id }}" data-bs-toggle="modal"
                                            data-bs-target="#updateTemplate{{ $item->temp_id }}"><b>Edit</b></a> --}}

                                            <a class="btn action-btns  btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                            onclick="ItemDeleteModel(this)" data-id='<?=  $item->temp_id ?>'
                                            data-temp_name='<?= $item->temp_name ?>' data-bs-toggle="modal"
                                            data-bs-target="#editDeleteModel"><i class="feather feather-trash"></i>
                                        </a>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
   
    <div class="modal fade" id="editDeleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('delete.holidayTemp')  }}" method="POST">
                    @csrf
                    <input type="text" id="holiday_policy_id" name="holiday_policy_id" hidden>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Holiday Policy Name <b>
                            </b></p>
                        <h4 id="assign_emp"></h4><b>
                        </b>
                        <p></p>

                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer">

                        <a class="btn btn-light" data-bs-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-danger" id="">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function ItemDeleteModel(context) {
           var id = $(context).data('id');
           var name = $(context).data('temp_name')
           $('#holiday_policy_id').val(id);
           $('#assign_emp').text(name);

       }
   </script>
    <div class="row">
        @foreach ($HolidayTemplate as $template)
            {{-- <div class="card"> --}}
                {{-- @php
                    // dd($template);
                    $i = 0;
                    foreach ($Holiday->where('template_id', $template->temp_id) as $holiday) {
                        $i++;
                    }
                @endphp --}}

                {{-- <div class="card-body border-bottum-0">
        

                    <div class="row">
                        <div class="col-8 col-xl-3 my-auto">
                            <h5 class="my-auto">{{ $template->temp_name }}</h5>
                        </div>
                        <div class="col-4 col-xl-2 d-none d-md-block my-auto">
                            <p class="my-auto text-muted">{{ $i }} Holidays</p>
                        </div>
                        <div class="col-12 col-xl-3 my-auto d-none d-md-block">
                            <p class="my-auto text-muted">Applied to 14 Employees</p>
                        </div>
                        <div class="col-8 col-xl-2">
                            <p class="my-auto text-muted">
                                <a class=" modal-effect btn text-primary" data-bs-toggle="modal"
                                    data-bs-target="#ManageEmployee{{ $template->temp_id }}"><b>Manage Employee
                                        List</b></a>
                            </p>
                        </div>
                        <div class="col-4 col-xl-2 d-flex">
                            <p class="my-auto text-muted text-end">
                                <a class="btn text-primary" id="editTempBtn{{ $template->temp_id }}" data-bs-toggle="modal"
                                    data-bs-target="#updateTemplate{{ $template->temp_id }}"><b>Edit</b></a>
                            </p>
                            <form action="{{ route('delete.holidayTemp', $template->temp_id) }}" method="post">
                                @csrf
                                <p class="my-auto text-muted text-end">
                                    <button type='submit' class="btn text-danger"
                                        id="editTempBtn{{ $template->temp_id }}"><b>Delete</b></button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div> --}}

                <div class="modal fade" id="ManageEmployee{{ $template->temp_id }}">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header p-5">
                                <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Manage Employee
                                </h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                                </button>
                            </div>

                            <div class="card-header border-0">
                                <h4 class="card-title">Assign Policy to Employee</h4>
                            </div>
                            <div class="modal-body m-5">
                                <div class="row">
                                    <div class="col-md-12 col-xl-3">
                                        <div class="form-group">
                                            <label class="form-label">Branch:</label>
                                            <select name="attendance" class="form-control custom-select select2"
                                                data-placeholder="Select Branch">
                                                <option value="1">select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-3">
                                        <div class="form-group">
                                            <label class="form-label">Department:</label>
                                            <select name="attendance" class="form-control custom-select select2"
                                                data-placeholder="Select Department">
                                                <option value="1">select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-3">
                                        <div class="form-group">
                                            <label class="form-label">Designation:</label>
                                            <select name="attendance" class="form-control custom-select select2"
                                                data-placeholder="Select Designation">
                                                <option value="1">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3"></div>
                                    <div class="col-xl-3"></div>
                                    <div class="col-xl-3"></div>
                                    <table class="table mb-0 text-nowrap">
                                        <thead>
                                            <div class="card-header border-bottom-0">
                                                <div class="card-title">
                                                    Employee List
                                                </div>
                                                <div class="page-rightheader ms-auto">
                                                    <div
                                                        class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                                        <div class="btn-list d-flex">
                                                            <div class="d-flex my-5">
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" id="allAllow"
                                                                        onchange="allow()" class="custom-switch-input">
                                                                    <span class="custom-switch-indicator"></span>
                                                                </label>
                                                                <h5 class="title ms-5 my-auto">Select All</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </thead>
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="d-flex">
                                                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                                                    <h5 class="mb-0"><b><i
                                                                                class="fa fa-user fs-20 mx-3"></i>Jayant
                                                                            Nishas</b><br /><span class="text-muted"><i
                                                                                class="fa fa fs-20 mx-3"></i><span
                                                                                class="fs-14">Software
                                                                                Developer</span></span></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <span class="d-sm-none d-md-block"><b class="my-auto"><i
                                                                        class="fa fa-phone fs-20 mx-3"></i> +91
                                                                    1234567890</b></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="custom-switch">
                                                        <input type="checkbox" id="emp_check" name="employeeAllow"
                                                            class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <script>
                                function allow() {
                                    $allcheck = document.getElementById('allAllow');

                                    $checkbox = document.getElementById('emp_check');
                                    if ($allcheck.checked == true) {
                                        $checkbox.checked = true;
                                    } else {
                                        $checkbox.checked = false;
                                    }

                                }
                            </script>

                            <div class="modal-footer d-flex justify-content-center">
                                <div class="text-center">
                                    <button class="btn btn-success" type="submit" id="submit" data-bs-target="">
                                        Save & Apply</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        @endforeach
    </div>
    </div>

    <div class="container">
        <div class="modal fade" id="createTemplate">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h5 class="modal-title" style="font-size:18px;">New Holiday Template
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>

                    <div class="card-header border-0">
                        <h4 class="card-title">Create New Holiday</h4>
                    </div>
                    <form action="{{ route('add.holiday') }}" method="post">
                        @csrf
                        <div class="modal-body m-5">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <p class="form-label">Template Name</p>
                                        <input type="text" class="form-control header-text"
                                            placeholder="Enter Template Name" aria-label="text" tabindex="1"
                                            name="temp_name" required>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <p class="form-label">From</p>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                type="date" name="temp_from" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <p class="form-label">To</p>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" placeholder="DD-MM-YYYY"
                                                type="date" name="temp_to" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <!-- Hover added -->
                                    <div class="mt-3 border-bottom">
                                        <div class="col">
                                            <h4 class="card-title"><span>Holiday</span></h4>
                                        </div>

                                        <div class="row" style="align-items: center;">
                                            <div class="col-md-10 dynamic-field" id="dynamic-field-1">
                                                <div class="row" id="row">
                                                    <div class="col-xl-4 pt-3">
                                                        <div class="form-group">
                                                            <label for="field" class="hidden-md">Holiday Name*</label>
                                                            <input type="text" id="holidayNames"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 pt-3">
                                                        <div class="form-group">
                                                            <label for="field" class="hidden-md">Date</label>
                                                            <input type="date" id="holidayDates"
                                                                class="form-control" />

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-1 pt-4 col-md-1 append-buttons">
                                                <button type="button" onclick="addSetData()" class="btn btn-outline-primary add_item_btn"><i class="fe fe-plus bold"></i>
                                                </button>
                                                {{-- <button type="button" 
                                                    class="btn btn-primary btn-sm mb-2 text-uppercase shadow-sm"><i
                                                        class="fa fa-plus fa-fw"></i>
                                                </button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12 table-responsive-sm">
                                        <table width="100%" id="displayTable"
                                            class="table text-center table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Holiday Name</th>
                                                    <th>Date</th>
                                                    <th>Day</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div hidden class="moreManpower row">

                                </div>

                                <div class=" text-end">
                                    <button type="reset" class="btn btn-outline-dark" id="tempSave"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Reset">Reset</button>
                                    <button type="submit" class="btn btn-outline-primary" id="tempSave"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Apply
                                        Template</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @foreach ($HolidayTemplate as $template)
        <div class="container">
            <div class="modal fade" id="updateTemplate{{ $template->temp_id }}">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">
                            <h5 class="modal-title" style="font-size:18px;">Update Holiday Template</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>

                        <div class="card-header border-0">
                            <h4 class="card-title">Update Holiday</h4>
                        </div>
                        <form action="{{ route('update.holiday') }}" method="post">
                            @csrf
                            <div class="modal-body m-5">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <p class="form-label">Template Name</p>
                                            <input type="text" class="form-control header-text"
                                                placeholder="Enter Template Name" value="{{ $template->temp_id }}"
                                                aria-label="text" tabindex="1" name="update_temp_id" hidden>
                                            <input type="text" class="form-control header-text"
                                                placeholder="Enter Template Name" value="{{ $template->temp_name }}"
                                                aria-label="text" tabindex="1" name="update_temp_name" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="form-label">From</p>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div><input class="form-control fc-datepicker"
                                                    value="{{ $template->temp_from }}" placeholder="DD-MM-YYYY"
                                                    type="date" name="update_temp_from" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="form-label">To</p>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="feather feather-calendar"></i>
                                                    </div>
                                                </div><input class="form-control fc-datepicker"
                                                    value="{{ $template->temp_to }}" placeholder="DD-MM-YYYY"
                                                    type="date" name="update_temp_to" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <!-- Hover added -->
                                        <div class="mt-3 border-bottom">
                                            <div class="col">
                                                <h4 class="card-title"><span>Holiday</span></h4>
                                            </div>

                                            <div class="row" style="align-items: center;">
                                                <div class="col-md-10 dynamic-field">
                                                    <div class="row" id="row">
                                                        <div class="col-xl-4 pt-3">
                                                            <div class="form-group">
                                                                <label for="field" class="hidden-md">Holiday
                                                                    Name*</label>
                                                                <input type="text" class="form-control"
                                                                    id="update_holiday_name{{ $template->temp_id }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 pt-3">
                                                            <div class="form-group">
                                                                <label for="field" class="hidden-md">Date</label>
                                                                <input type="date" class="form-control"
                                                                    id="update_holiday_date{{ $template->temp_id }}" />

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-1 pt-4 col-md-1 append-buttons">
                                                    
                                                    <button type="button"  id="{{ $template->temp_id }}" onclick="updateAppend(this.id)" class="btn btn-outline-primary add_item_btn"><i class="fe fe-plus bold"></i>
                                                    </button>
                                               
                                                    {{-- <button type="button" id="{{ $template->temp_id }}"
                                                        onclick="updateAppend(this.id)"
                                                        class="btn btn-primary btn-sm mb-2 text-uppercase shadow-sm"><i
                                                            class="fa fa-plus fa-fw"></i>
                                                    </button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-12 table-responsive-sm">
                                            <table width="100%" id="displayTableUpdate{{ $template->temp_id }}"
                                                class="table text-center table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Holiday Name</th>
                                                        <th>Date</th>
                                                        <th>Day</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Holiday->where('template_id', $template->temp_id) as $holiday)
                                                        <tr>
                                                            <td>{{ $holiday->holiday_name }}</td>
                                                            <td>{{ $holiday->holiday_date }}</td>
                                                            <td>{{ $holiday->day }}</td>
                                                            <td>
                                                                <button type="button" id="{{ $holiday->holiday_id }}" onclick="deleteHolidayOnly(this.id,{{ $template->temp_id }})" class="btn btn-outline-danger remove_item_btn_edit" ><i class="feather feather-trash"></i></button>
                                                                {{-- <button type="button"  class="btn btn-danger btn-sm" >Delete</button> --}}
                                                                {{-- <button type="button" id="{{ $holiday->holiday_id }}"
                                                                    class="btn btn-danger btn-sm"
                                                                    onclick="deleteHolidayOnly(this.id,{{ $template->temp_id }})">Delete</button> --}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div hidden class="UpdatemoreManpower{{ $template->temp_id }} row">

                                            </div>
                                        </div>
                                        <script>
                                            function deleteHolidayOnly(id, temp) {

                                                // console.log(document.getElementById("displayTableUpdate"+temp));
                                                // alert(id);
                                                $.ajax({
                                                    url: "{{ url('/delete/holiday') }}",
                                                    type: "POST",
                                                    data: {
                                                        state: id,
                                                        _token: '{{ csrf_token() }}'
                                                    },
                                                    dataType: 'json',
                                                    success: function(result) {
                                                        location.reload();
                                                        console.log(result);

                                                    }
                                                });
                                            }
                                        </script>
                                    </div>

                                    <div class=" text-end">
                                        <a class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</a>
                                        {{-- <button type="reset" class="btn btn-outline-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Reset">Reset</button> --}}
                                        <button type="submit" class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Save">Apply</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @endforeach

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        var holidayData = [];

        function addSetData() {
            var holidayName = document.getElementById('holidayNames').value;
            var holidayDate = document.getElementById('holidayDates').value;

            if (holidayName && holidayDate) {
                var day = getDayName(holidayDate);
                addHoliday(holidayName, holidayDate, day);
                clearForm();
            } else {
                alert("All fields are required!");
            }
        }

        function clearForm() {
            document.getElementById('holidayNames').value = '';
            document.getElementById('holidayDates').value = '';
        }

        function getDayName(dateString) {
            // Create a Date object from the input string
            var date = new Date(dateString);

            // Get the day name
            var options = {
                weekday: 'long'
            };
            var dayName = date.toLocaleDateString(undefined, options);

            return dayName;
        }



        function addHoliday(name, date, day) {
            var table = document.getElementById("displayTable").getElementsByTagName('tbody')[0];
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            cell1.innerHTML = name;
            cell2.innerHTML = date;
            cell3.innerHTML = day;
            
                                                               
            cell4.innerHTML =
                '<button type="button"  onclick="deleteHoliday(this)" class="btn btn-outline-danger " ><i class="feather feather-trash"></i></button>';

            // Add the holiday data to the array
            holidayData.push({
                name: name,
                date: date,
                day: day
            });

            updateLoaderArray();
        }

        function deleteHoliday(button) {
            var row = button.parentNode.parentNode;
            var rowIndex = row.rowIndex;
            row.parentNode.removeChild(row);
            holidayData.splice(rowIndex - 1, 1);
            updateLoaderArray();
        }

        function updateDayField() {
            var selectedDate = document.getElementById('holidayDate').value;
            if (selectedDate) {
                var dateObject = new Date(selectedDate);
                var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var dayOfWeek = daysOfWeek[dateObject.getDay()];
                document.getElementById('autoDay').value = dayOfWeek;
            }
        }

        // Add event listener to update the "Day" field when the date is changed
        document.getElementById('holidayDate').addEventListener('change', updateDayField);

        function updateLoaderArray() {
            var loader = '';

            holidayData.forEach(function(data) {
                loader += `
                    <input type="text" name="holiday_name[]" value="${data.name}">
                    <input type="date" name="holiday_date[]" value="${data.date}">
                    <input type="text" name="holiday_day[]" value="${data.day}">
                `;
            });

            $('.moreManpower').eq(0).html(loader);
        }
    </script>

    <script>
        var holidayUpdateData = [];

        function updateAppend(id) {
            var holidayNameUpdate = document.getElementById('update_holiday_name' + id).value;
            var holidayDateUpdate = document.getElementById('update_holiday_date' + id).value;

            // alert(holidayNameUpdate);
            if (holidayNameUpdate && holidayDateUpdate) {
                var dayUpdate = getDayName(holidayDateUpdate);
                addHolidayUpdate(holidayNameUpdate, holidayDateUpdate, dayUpdate, id);
                clearUpdateForm(id);
            } else {
                alert("All fields are required!");
            }
        }

        function addHolidayUpdate(name, date, day, id) {
            var table = document.getElementById("displayTableUpdate" + id).getElementsByTagName('tbody')[0];
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);

            cell1.innerHTML = name;
            cell2.innerHTML = date;
            cell3.innerHTML = day;
            cell4.innerHTML ='<button type="button"  onclick="deleteHoliday(this)" class="btn btn-outline-danger " ><i class="feather feather-trash"></i></button>';

            // Add the holiday data to the array
            holidayUpdateData.push({
                name: name,
                date: date,
                day: day
            });

            LoaderArray(id);
        }

        function clearUpdateForm(id) {
            document.getElementById('update_holiday_name' + id).value = '';
            document.getElementById('update_holiday_date' + id).value = '';
        }

        function LoaderArray(id) {
            var loaderUpdate = '';

            holidayUpdateData.forEach(function(data) {
                loaderUpdate += `
                    <input type="text" name="update_name[]" value="${data.name}">
                    <input type="date" name="update_date[]" value="${data.date}">
                    <input type="text" name="update_day[]" value="${data.day}">
                `;
            });

            $('.UpdatemoreManpower' + id).eq(0).html(loaderUpdate);
        }
    </script>
@endsection
