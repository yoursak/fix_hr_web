@extends('admin.setting.setting')
@section('subtitle')
    Salary / Admin Setting
@endsection

@section('css')
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
@endsection
@section('settings')
    {{--
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> --}}
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Leave Templates</div>
            <p class="text-muted">Create Template to give leaves to staff on month if they want</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        {{-- <a href="javascript:void(0);" type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                        data-bs-target="#deletemodalview">Create Templates</a> --}}
                        {{-- <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                        data-bs-target="#clockinmodal" id="newTempFormBtn">Create Templates</button> --}}
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#myModal">
                            Create Templates
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container">
        <!-- Button to Open the Modal -->

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-5">
                        <h5 class="modal-title px-5" id="exampleModalLongTitle" style="font-size:18px;">Leave Policy</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-5 px-5">
                        <form action="{{ route('leave.policy')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col border-0">
                                    <h4 class="card-title "><span>Leave Setting</span></h4>
                                </div>
                                <div class="card-body mb-0 pb-0">
                                    <div class="form-row form-group pt-2 m-0">
                                        <div class="col-4 col-xl-4 p-0">
                                            <p class="my-auto fs-15 form-label">Policy Name</p>
                                        </div>
                                        <div class="col-8 col-xl-4 ">
                                            <input type="text" class="form-control bg-muted form-label" id="inputName"
                                                placeholder="Enter Template Name" name="policyname">
                                        </div>
                                    </div>

                                    <div class="row pt-3">
                                        <div class="col-4 col-xl-4 ">
                                            <p class="my-auto fs-15 form-label">Leave Policy Cycle</p>
                                        </div>
                                        <div class="col-8 col-xl-4 ">
                                            <div class="btn-group" role="group"
                                                aria-label="Basic radio toggle button group">
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradiomonth"
                                                    checked="">
                                                <label class="btn btn-outline-dark" for="btnradiomonth">Monthly</label>
                                                <input type="radio" class="btn-check" name="btnradio" id="btnradioyear">
                                                <label class="btn btn-outline-dark" for="btnradioyear">Yearly</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pt-3">
                                        <div class="col-xl-4">
                                            <p class="my-auto fs-15 form-label pb-2 ">Leave Period</p>
                                        </div>
                                        <div class="col-xl-6 my-auto">
                                            <div class="form-group d-flex">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="feather feather-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input class="form-control fc-datepicker" name="leavefrom" placeholder="DD-MM-YYYY"
                                                        type="date">
                                                </div>
                                                <label class="form-label mx-3 my-auto">To</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="feather feather-calendar"></i>
                                                        </div>
                                                    </div><input class="form-control fc-datepicker" name="leaveto" placeholder="DD-MM-YYYY"
                                                        type="date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr style="background: black" />
                            <div class="row ">
                                <div class="col border-0">
                                    <h4 class="card-title"><span>Leave Category</span></h4>
                                </div>
                                
                                    <div class="row card-body pr-0" id="show_item">

                                    </div>
                                    <div  class="row card-body pr-0" >
                                        <div class="col-xl-3 pt-3">
                                            <label for="inputCity" class="form-label">Category Name</label>
                                            <input type="text" class="form-control" id="inputCity" name="categoryname"
                                                placeholder="Category Name">
                                        </div>
                                        <div class="col-xl-2 pt-3">
                                            <label for="inputCity" class="form-label ">Days</label>
                                            <input type="number" class="form-control bg-muted" name="days" placeholder="Count">
                                        </div>
                                        <div class="col-xl-2 pt-3">
                                            <label for="inputState" class="form-label">Unused Leave Rule</label>
                                            <select class="form-control select2" data-placeholder="Leave Rule" name="leaverule">
                                                <option label="Fixed Amount"></option>
                                                <option>Lapse</option>
                                                <option>Carry Forward</option>
                                                <option>Encash</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 pt-3">
                                            <label for="inputCity" class="form-label" >Carry Forward Limit</label>
                                            <input type="text" class="form-control" name="cfl" id="inputCity"
                                                placeholder="Days">
                                        </div>

                                        <div class="col-xl-2 pt-3">
                                            <label for="inputState" class="form-label">Applicable To</label>
                                            <select class="form-control select2" name="applicable" data-placeholder="Applicable To">
                                                <option label="Fixed Amount"></option>
                                                <option>All</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-1 pt-3 text-end">
                                            <label for="inputCity" class="form-label ">&nbsp;</label>
                                            <button type="button" class="btn btn-outline-primary add_item_btn"><i
                                                    class="fe fe-plus bold"></i></button>

                                            {{-- <a href="javascript:void(0);" id="hidehide" style="display:none"
                                            class="action-btns" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Delete"><i class="feather feather-trash danger text-danger"></i></a>
                                        <a href="javascript:void(0);" id="showshow" class="n add_item_btn action-btns"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                            value="Add More" onclick="addMore()"><i
                                                class="fe fe-plus text-primary"></i></a> --}}
                                            {{-- <button id="hidehide" style="display:none">Hide</button> --}}
                                            {{-- <button id="">Show</button> <a href=""></a> --}}

                                        </div>

                                    </div>

                                {{-- </div> --}}
                            </div>



                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <div class="text-center">
                                <button class="btn btn-success" type="submit" data-bs-target="">Apply</button>
                            </div>
                        </form>

                        {{-- <div class="">
                        {{-- <button class="btn btn-danger mx-2" data-bs-dismiss="modal">Decline</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    {{-- delete confirmation --}}

    {{-- delete confirmation --}}


    <div class="row">
        <div class="card">
            <div class="card-body ">
                {{-- border-bottum-0 p-2 --}}
                <div class="row">
                    <div class="col-6 col-xl-3 my-auto">
                        <h5 class="my-auto">FD Leave Template</h5>
                    </div>
                    <div class="col-6 col-xl-2 my-auto">
                        <p class="my-auto text-muted">2 Leaves Per Month</p>
                    </div>
                    <div class="col-xl-3 my-auto">
                        <p class="my-auto text-muted">Applied to 14 Employees</p>
                    </div>
                    <div class="col-8 col-xl-2">
                        <p class="my-auto text-muted">
                            <a class="btn text-primary" id="manageemp1" href="#"><b>Manage Employee List</b></a>
                            <a class="btn btn-outline-success d-none" id="manageemp2" href="#"><b>Apply</b></a>
                        </p>
                    </div>
                    <div class="col-4 col-xl-2">
                        <p class="my-auto text-muted text-end">
                            <a class="btn text-primary" id="editTempBtn" href="#"><b>Edit Template</b></a>
                            <a class="btn btn-outline-success d-none" id="applyTempBtn" href="#"><b>Apply</b></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottum-0 d-none" style="height: 20rem; overflow:scroll" id="emplist1">
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
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
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Mail"><i
                                        class="feather feather-edit  text-primary"></i></a>
                                <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete"><i
                                        class="feather feather-trash-2 text-danger"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class=" text-end">
        <a href="{{ url('settings/businesssetting') }}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Save">Apply Changes</a>
    </div>

    {{-- Set Multilavel Approval Modal --}}
    <div class="modal fade" id="SetMultilavelApprovalModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0 ">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Set Multilavel Approval</h6>
                        </div>
                        <div class="card-body border-0">
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label class="form-label">Choose Type of Approval:</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Type of Approval" id='lavelofapproval'>
                                            <option label="Select Employee"></option>
                                            <option value="1">Lavel One</option>
                                            <option value="2">Lavel Two</option>
                                            <option value="3">Lavel Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-11 col-md-11 col-xl-11 ms-auto">
                                            <div class="form-group d-none" id="firstlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">First
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                            <div class="form-group d-none" id="secondlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Second
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                            <div class="form-group d-none" id="thirdlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Final
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    {{-- Edit Multilavel Approval Modal --}}
    <div class="modal fade" id="EditMultilavelApprovalModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-body border-0">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h6 class="card-title">Edit Multilavel Approval</h6>
                        </div>
                        <div class="card-body border-0">
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label class="form-label">Choose Type of Approval:</label>
                                        <select name="attendance" class="form-control custom-select select2"
                                            data-placeholder="Type of Approval" id='Editlavelofapproval'>
                                            <option label="Select Employee"></option>
                                            <option value="1">Lavel One</option>
                                            <option value="2">Lavel Two</option>
                                            <option value="3">Lavel Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-11 col-md-11 col-xl-11 ms-auto">
                                            <div class="form-group d-none" id="Editfirstlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">First
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                            <div class="form-group d-none" id="Editsecondlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Second
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                            <div class="form-group d-none" id="Editthirdlavel">
                                                <label class="form-label fs-12" style="color: rgb(173, 139, 144);">Final
                                                    Approved By:</label>
                                                <select name="attendance"
                                                    class="form-control custom-select select2 d-none"
                                                    data-placeholder="Select Employee">
                                                    <option label="Select Employee"></option>
                                                    <option value="1">Employer</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">HR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".add_item_btn").click(function(e) {
                e.preventDefault();
                // $("#show_item").prepend('<div class="col-xl-3 pt-3" id="dynamictable"> <label for="inputCity" class="form-label">Category Name</label> <input type="text" class="form-control" id="inputCity" placeholder="Category Name"> </div> <div class="col-xl-2 pt-3"> <label for="inputCity" class="form-label">Days</label> <input type="number" class="form-control bg-muted" placeholder="Count"> </div> <div class="col-xl-2 pt-3"> <label for="inputState" class="form-label">Unused Leave Rule</label> <select class="form-control select2" data-placeholder="Leave Rule"> <option label="Leave Rule"></option> <option>Lapse</option> <option>Carry Forward</option> <option>Encash</option> </select> </div> <div class="col-xl-2 pt-3"> <label for="inputCity" class="form-label">Carry Forward Limit</label> <input type="text" class="form-control" id="inputCity" placeholder="Days"> </div> <div class="col-xl-2 pt-3"> <label for="inputState" class="form-label">Applicable To</label> <select class="form-control select2" data-placeholder="Applicable To"> <option label="Applicable To"></option> <option>All</option> <option>Male</option> <option>Female</option> </select> </div> <div class="col-xl-1 pt-3 text-end"> <label for="inputCity" class="form-label ">&nbsp;</label><a href="javascript:void(0);" id="hidehide" style="display:none" class="action-btns" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash danger text-danger"></i></a> <a href="javascript:void(0);" id="showshow" class="n add_item_btn action-btns" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" value="Add More" onclick="addMore()"><i class="fe fe-plus text-primary"></i></a></div>')
                $("#show_item").append(
                    ' <div class="col-xl-3 pt-3"> <label for="inputCity" class="form-label">Category Name</label> <input type="text" class="form-control" id="inputCity" placeholder="Category Name"> </div> <div class="col-xl-2 pt-3"> <label for="inputCity" class="form-label ">Days</label> <input type="number" class="form-control bg-muted" placeholder="Count"> </div> <div class="col-xl-2 pt-3"> <label for="inputState" class="form-label">Unused Leave Rule</label> <select class="form-control select2" data-placeholder="Leave Rule"> <option label="Fixed Amount"></option> <option>Lapse</option> <option>Carry Forward</option> <option>Encash</option> </select> </div> <div class="col-xl-2 pt-3"> <label for="inputCity" class="form-label">Carry Forward Limit</label> <input type="text" class="form-control" id="inputCity" placeholder="Days"> </div> <div class="col-xl-2 pt-3"> <label for="inputState" class="form-label">Applicable To</label> <select class="form-control select2" data-placeholder="Applicable To"> <option label="Fixed Amount"></option> <option>All</option> <option>Male</option> <option>Female</option> </select> </div> <div class="col-xl-1 pt-3 text-end"> <label for="inputCity" class="form-label ">&nbsp;</label> <button type="button" class="btn btn-outline-danger remove_item_btn"><i class="feather feather-trash "></i></button>  </div>  ');
            });

            $(document).on('click','.remove_item_btn',function(e){
                e.preventDefault();
                let row_item = $(this).parent().parent();
                $(row_item).remove();
            })
        });
        // function addMore() {

        //     $('#dynamictable').append(
        //         '<div class="col-xl-3 pt-3" id="dynamictable"> <label for="inputCity" class="form-label">Category Name</label> <input type="text" class="form-control" id="inputCity" placeholder="Category Name"> </div> <div class="col-xl-2 pt-3"> <label for="inputCity" class="form-label">Days</label> <input type="number" class="form-control bg-muted" placeholder="Count"> </div> <div class="col-xl-2 pt-3"> <label for="inputState" class="form-label">Unused Leave Rule</label> <select class="form-control select2" data-placeholder="Leave Rule"> <option label="Leave Rule"></option> <option>Lapse</option> <option>Carry Forward</option> <option>Encash</option> </select> </div> <div class="col-xl-2 pt-3"> <label for="inputCity" class="form-label">Carry Forward Limit</label> <input type="text" class="form-control" id="inputCity" placeholder="Days"> </div> <div class="col-xl-2 pt-3"> <label for="inputState" class="form-label">Applicable To</label> <select class="form-control select2" data-placeholder="Applicable To"> <option label="Applicable To"></option> <option>All</option> <option>Male</option> <option>Female</option> </select> </div> <div class="col-xl-1 pt-3 text-end"> <label for="inputCity" class="form-label ">&nbsp;</label><a href="javascript:void(0);" id="hidehide" style="display:none" class="action-btns" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash danger text-danger"></i></a> <a href="javascript:void(0);" id="showshow" class="n add_item_btn action-btns" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" value="Add More" onclick="addMore()"><i class="fe fe-plus text-primary"></i></a></div>');
        // }

        // $(document).ready(function() {
        //     $("#hidehide").click(function() {
        //         $("#hidehide").hide();
        //         $("#showshow").show();
        //     });
        //     $("#showshow").click(function() {
        //         $("#hidehide").show();
        //         $("#showshow").hide();
        //     });
        // });
    </script>
@endsection
