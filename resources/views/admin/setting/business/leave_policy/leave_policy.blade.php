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
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Leave Templates</div>
        <p class="text-muted">Create Template to give leaves to staff on month if they want</p>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block">
                <div class="btn-list">
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#myModal">
                        Create Templates
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    {{-- create modal  --}}
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Leave Policy</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.leavepolicySubmit') }}" method="POST">
                    @csrf
                    <div class="modal-body m-5">
                        @csrf
                        <div class="row">

                            <div class="col">
                                <h4 class="card-title"><span>Leave Setting</span></h4>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Policy Name</label>
                                <div class="col">
                                    <input type="text" class="form-control bg-muted form-label" id="inputName"
                                        placeholder="Enter Template Name" name="policyname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Leave Policy Cycle</label>
                                <div class="col-sm-5">
                                    {{-- <input type="text" class="form-control bg-muted form-label" id="inputName"
                                            placeholder="Enter Template Name" name="policyname"> --}}
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="btnradio" id="btnradiomonth"
                                            value="1" checked=true>
                                        <label class="btn btn-outline-dark" for="btnradiomonth">Monthly</label>
                                        <input type="radio" class="btn-check" name="btnradio" id="btnradioyear"
                                            value="2">
                                        <label class="btn btn-outline-dark" for="btnradioyear">Yearly</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-xl-2 col-form-label">Leave Period</label>
                                <div class="form-row col-xl-5">
                                    <input type="date" name="leave_periodfrom" class="form-control col-xl-4" required>
                                    <label class="col-xl-1" for="">To</label>
                                    <input type="date" name="leave_periodto" class="form-control col-xl-4 " required>
                                </div>
                            </div>


                        </div>

                        <hr style="background: black" />
                        <div class="form-group">
                            <!-- Hover added -->
                            <div class="mt-3 border-bottom">
                                <div class="col">
                                    <h4 class="card-title"><span>Leave Category</span></h4>
                                </div>

                                <div class="row" style="align-items: center;">

                                    <div class="col-md-10 dynamic-field" id="dynamic-field-1">
                                        <div class="row" id="row">

                                            <div class="col-md-3 col-xl-3 pt-3">
                                                <div class="form-group">
                                                    <label for="field" class="hidden-md">Category Name*</label>
                                                    <input type="text" id="categoryname" class="form-control" />

                                                </div>
                                            </div>

                                            <div class="col-md-2 col-xl-2 pt-3">
                                                <div class="form-group">
                                                    <label for="field" class="hidden-md">Days*</label>
                                                    <input type="number" id="days" class="form-control" />

                                                </div>
                                            </div>
                                            <div class="col-md-2 col-xl-2 pt-3">
                                                <label for="inputState" class="form-label">Unused Leave Rule</label>
                                                <select class="form-control select2" data-placeholder="Leave Rule"
                                                    id="leaverules">
                                                    <option value="" label="Fixed Amount"></option>
                                                    <option>Lapse</option>
                                                    <option>Carry Forward</option>
                                                    <option>Encash</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2 col-xl-2 pt-3">
                                                <div class="form-group">
                                                    <label>Carry Forward Limit</label>
                                                    <input type="number" id="carryforward" class="form-control" />
                                                </div>

                                            </div>
                                            <div class="col-md-2 col-xl-2 pt-3">
                                                <label for="inputState" class="form-label">Applicable To</label>
                                                <select class="form-control select2" id="applicables"
                                                    data-placeholder="Applicable To">
                                                    <option value="" label="Fixed Amount"></option>
                                                    <option>All</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                      <div class="form-group">
                                                          <input hidden type="number" id="totalset0" class="form-control"
                                                              name="totalset0" />
                                                      </div>
      
                                                  </div> --}}
                                        </div>
                                    </div>

                                    <div class="col-xl-1 pt-4 col-md-1 append-buttons">

                                        <button type="button" onclick="addSetData()"
                                            class="btn btn-primary btn-sm mb-2 text-uppercase shadow-sm"><i
                                                class="fa fa-plus fa-fw"></i>
                                        </button>
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
                                            {{-- <th>SNo</th> --}}
                                            <th>Category Name</th>
                                            <th>Days</th>
                                            <th>Unused Leave Rule</th>
                                            <th>Carry Forward Limit</th>
                                            <th>Applicable To</th>
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

                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <div class="text-center">
                            <button class="btn btn-success" type="submit" id="submit" data-bs-target="">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
    $temp = new App\Helpers\Central_unit();
    $LeaveTemp = $temp -> LeavePolicyList(Session::get('business_id'), Session::get('branch_id'));
?>

@foreach ($LeaveTemp as $item)
<div class="row">
    <div class="card">
        <div class="card-body ">
            {{-- border-bottum-0 p-2 --}}
            <div class="row">
                <div class="col-6 col-xl-3 my-auto">
                    <h5 class="my-auto">{{$item->policy_name}}</h5>
                </div>
                <div class="col-6 col-xl-2 my-auto">
                    <p class="my-auto text-muted">2 Leaves Per Month</p>
                </div>
                <div class="col-xl-3 my-auto">
                    <p class="my-auto text-muted">Applied to 14 Employees</p>
                </div>
                <div class="col-8 col-xl-2">
                    <p class="my-auto text-muted">
                        <a class="btn text-primary" id="manageemp1" href="#" data-toggle="modal"
                            data-target="#ManageEmployee{{$item->id}}"><b>Manage Employee List</b></a>
                        <a class="btn btn-outline-success d-none" id="manageemp2" href="#"><b>Apply</b></a>
                    </p>
                </div>
                <div class="col-4 col-xl-2 d-flex">
                    <p class="my-auto text-muted text-end">
                        <a class="btn text-primary" id="editTempBtn" data-bs-toggle="modal"
                            data-bs-target="#editLeave{{$item->id}}"><b>Edit</b></a>
                    </p>
                    <p class="my-auto text-muted text-end">
                        <a class="btn text-danger" id="editTempBtn" data-bs-toggle="modal"
                            data-bs-target="#DeleteModal{{$item->id}}"><b>Delete</b></a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container">
    
    {{-- edit modal  --}}
    <div class="modal fade" id="editLeave{{$item->id}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Update Leave Policy</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                    </button>
                </div>
                <form action="{{ route('update.leaveTemp') }}" method="POST">
                    @csrf
                    <div class="modal-body m-5">
                        @csrf
                        <div class="row">

                            <div class="col">
                                <h4 class="card-title mb-5"><span>Update Leave Setting</span></h4>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Policy Name</label>
                                <div class="col">
                                    <input type="text" class="form-control bg-muted form-label"
                                        value="{{$item->policy_name}}" id="Update_inputName{{$item->id}}"
                                        placeholder="Enter Template Name" name="Update_policyname">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Leave Policy Cycle</label>
                                <div class="col-sm-5">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="btnradio" id="updatebtnradiomonth" value="1" checked>
                                        <label class="btn btn-outline-dark" for="updatebtnradiomonth">Monthly</label>
                                        <input type="radio" class="btn-check" name="btnradio" id="updatebtnradioyear" value="2">
                                        <label class="btn btn-outline-dark" for="updatebtnradioyear">Yearly</label>
                                    </div>
                                </div>
                                
                                
                                <script>
                                    const monthRadio = document.getElementById("updatebtnradiomonth");
                                    const yearRadio = document.getElementById("updatebtnradioyear");
                                
                                    monthRadio.addEventListener("change", function () {
                                        if (monthRadio.checked) {
                                            // Monthly radio is selected
                                            handleMonthlySelection();
                                        }
                                    });
                                
                                    yearRadio.addEventListener("change", function () {
                                        if (yearRadio.checked) {
                                            // Yearly radio is selected
                                            handleYearlySelection();
                                        }
                                    });
                                
                                    function handleMonthlySelection() {
                                        // Your code for handling the Monthly radio selection
                                        console.log("Monthly selected");
                                    }
                                
                                    function handleYearlySelection() {
                                        // Your code for handling the Yearly radio selection
                                        console.log("Yearly selected");
                                    }
                                </script>
                                
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-xl-2 col-form-label">Leave Period</label>
                                <div class="form-row col-xl-5">
                                    <input type="date" name="update_leave_periodfrom"
                                        value="{{$item->leave_period_from}}" class="form-control col-xl-4">
                                    <label class="col-xl-1" for="">To</label>
                                    <input type="date" name="update_leave_periodto" value="{{$item->leave_period_to}}"
                                        class="form-control col-xl-4 ">
                                </div>
                            </div>

                        </div>

                        <hr style="background: black" />
                        <div class="form-group">
                            <!-- Hover added -->
                            <div class="mt-3 border-bottom">
                                <div class="col">
                                    <h4 class="card-title"><span>Leave Category</span></h4>
                                </div>

                                <div class="row" style="align-items: center;">

                                    <div class="col-md-10 dynamic-field" id="dynamic-field-1">
                                        <div class="row" id="row">

                                            <div class="col-md-3 col-xl-3 pt-3">
                                                <div class="form-group">
                                                    <label for="field" class="hidden-md">Category Name*</label>
                                                    <input type="text" id="categoryname{{$item->id}}"
                                                        class="form-control" />
                                                    <input type="text" name="Tempid" value="{{$item->id}}"
                                                        class="form-control" hidden />

                                                </div>
                                            </div>

                                            <div class="col-md-2 col-xl-2 pt-3">
                                                <div class="form-group">
                                                    <label for="field" class="hidden-md">Days*</label>
                                                    <input type="number" id="days{{$item->id}}" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-xl-2 pt-3">
                                                <label for="inputState" class="form-label">Unused Leave Rule</label>
                                                <select class="form-control select2" data-placeholder="Leave Rule"
                                                    id="leaverules{{$item->id}}">
                                                    <option value="" label="Fixed Amount"></option>
                                                    <option>Lapse</option>
                                                    <option>Carry Forward</option>
                                                    <option>Encash</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2 col-xl-2 pt-3">
                                                <div class="form-group">
                                                    <label>Carry Forward Limit</label>
                                                    <input type="number" id="carryforward{{$item->id}}"
                                                        class="form-control" />
                                                </div>

                                            </div>
                                            <div class="col-md-2 col-xl-2 pt-3">
                                                <label for="inputState" class="form-label">Applicable To</label>
                                                <select class="form-control select2" id="applicables{{$item->id}}"
                                                    data-placeholder="Applicable To">
                                                    <option value="" label="Fixed Amount"></option>
                                                    <option>All</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-1 pt-4 col-md-1 append-buttons">

                                        <button type="button" onclick="updateAddSetData({{$item->id}})"
                                            class="btn btn-primary btn-sm mb-2 text-uppercase shadow-sm"><i
                                                class="fa fa-plus fa-fw"></i>
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12 table-responsive-sm">
                                <table width="100%" id="displayTable{{$item->id}}"
                                    class="table text-center table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            {{-- <th>SNo</th> --}}
                                            <th>Category Name</th>
                                            <th>Days</th>
                                            <th>Unused Leave Rule</th>
                                            <th>Carry Forward Limit</th>
                                            <th>Applicable To</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Leaves->where('leave_policy_id',$item->id) as $leave)
                                        <tr>
                                            <td>{{$leave->category_name}}</td>
                                            <td>{{$leave->days}}</td>
                                            <td>{{$leave->unused_leave_rule}}</td>
                                            <td>{{$leave->carry_forward_limit}}</td>
                                            <td>{{$leave->applicable_to}}</td>
                                            <td><a onclick="deleteHolidayOnly({{$leave->id}})"
                                                    class="btn btn-sm btn-danger">Delete</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <script>
                                    function deleteHolidayOnly(id) {
                                    
                                            // console.log(document.getElementById("displayTableUpdate"+temp));
                                            // alert(id);
                                            $.ajax({
                                                url: "{{ url('/delete/leave') }}",
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

                        </div>

                        <div hidden class="moreManpowers{{$item->id}} row">

                        </div>

                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <div class="text-center">
                            <button class="btn btn-success" type="submit" id="submit" data-bs-target="">Apply</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- manage employee modal  --}}
    <div class="modal fade" id="ManageEmployee">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Manage Employee</h5>
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
                                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                                            <div class="btn-list d-flex">
                                                <div class="d-flex my-5">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" id="allAllow" onchange="allow()"
                                                            class="custom-switch-input">
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
                                                        <h5 class="mb-0"><b><i class="fa fa-user fs-20 mx-3"></i>Jayant
                                                                Nishas</b><br /><span class="text-muted"><i
                                                                    class="fa fa fs-20 mx-3"></i><span
                                                                    class="fs-14">Software Developer</span></span></h5>
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
                    function allow(){
                            $allcheck =  document.getElementById('allAllow');

                            $checkbox = document.getElementById('emp_check');
                            if($allcheck.checked == true){
                                    $checkbox.checked = true;
                            }else{
                                    $checkbox.checked = false;
                            }

                            }
                </script>

                <div class="modal-footer d-flex justify-content-center">
                    <div class="text-center">
                        <button class="btn btn-success" type="submit" id="submit" data-bs-target=""> Save &
                            Apply</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- manage employee modal  --}}
    <div class="modal fade" id="DeleteModal{{$item->id}}">
        <div class="modal-dialog-centered modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Delete Leave Template</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                    </button>
                </div>

                    <div class="modal-body text-center">
                        <i class="fe fe-alert-triangle fs-50"></i>
                        <h4 class="text-primary fs-20 font-weight-semibold mt-2">Delete Alert</h4>
                        <p class="mb-4 mx-4"><b>Are you sure want to delete it ?</b></p>
                    </div>

                <div class="modal-footer d-flex justify-content-evenly">
                    <div class="text-center">
                        <button class="btn btn-danger" type="reset" id="submit" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    <div class="text-center">
                        <form action="{{route('delete.leaveTemp',$item->id)}}" method="post">
                            @csrf
                        <button class="btn btn-success" type="submit" id="submit">Delete</button>
                        </form>
                    </div>
                    
                </div>

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
    var i = 1;
        var carryforwardloading = 1; //inital state
        var rowData = [];

        function addSetData() {
            var categoryname = document.getElementById('categoryname').value;
            var days = document.getElementById("days").value;
            var leaverules = document.getElementById('leaverules').value;
            var carryforward = document.getElementById("carryforward").value;
            var applicable = document.getElementById('applicables').value;
            if (days != '' && carryforward != '' && categoryname != '' && leaverules != '' && applicable != '') {
                addSETData1();
                document.getElementById("categoryname").value = "";
                document.getElementById("days").value = "";
                // document.getElementById('leaverules').value = "";
                document.getElementById("carryforward").value = "";
                // document.getElementById('applicables').value = "";

            } else {
                alert("All Fields are Required!!");
            }

        }

        function addSETData1() {
            $('#displayTable').show();
            var table = document.getElementById("displayTable");
            var row = table.insertRow(-1);
            // var sno = row.insertCell(0);
            var categoryname = row.insertCell(0);
            var days = row.insertCell(1);
            var leaveRules = row.insertCell(2);
            var carryforward = row.insertCell(3);
            var applicables = row.insertCell(4);
            var action = row.insertCell(5);
            // sno.innerHTML = carryforwardloading++;

            // Get values from input fields
            var categorynameValue = document.getElementById('categoryname').value;
            var daysValue = document.getElementById('days').value;
            var carryforwardValue = document.getElementById('carryforward').value;
            var leaveRulesValue = document.getElementById('leaverules').value;
            var applicablesValue = document.getElementById('applicables').value;

            // Push the data for this row into the array
            rowData.push({
                categoryname: categorynameValue,
                days: daysValue,
                carryforward: carryforwardValue,
                leaveRules: leaveRulesValue,
                applicables: applicablesValue
            });

            categoryname.innerHTML = categorynameValue;
            days.innerHTML = daysValue;
            carryforward.innerHTML = carryforwardValue;
            leaveRules.innerHTML = leaveRulesValue;
            applicables.innerHTML = applicablesValue;

            var delete2 =
                "<button type='button' class='btn btn-primary btn-sm float-left text-uppercase'><i class='fa fa-minus fa-fw'></i></button>";
            action.innerHTML = delete2;

            $(action).click(function(e) {
                var row = action.parentNode;
                var rowIndex = row.rowIndex;
                rowData.splice(rowIndex - 1, 1);
                row.parentNode.removeChild(row);
                // Update the loader array based on the current rowData
                updateLoaderArray();
            });
            // Update the loader array based on the current rowData
            updateLoaderArray();

            return true;
        }
        // Function to update the loader array based on the rowData
        function updateLoaderArray() {
            var loader = '';

            // Iterate through the rowData and generate the loader content
            rowData.forEach(function(data) {
                loader += `<input type="text" name="category_name[]" value="${data.categoryname}">
                   <input type="text" name="days[]" value="${data.days}">
                   <input type="text" name="unused_leave_rule[]" value="${data.leaveRules}">
                   <input type="text" name="carry_forward_limit[]" value="${data.carryforward}">
                   <input type="text" name="applicable_to[]" value="${data.applicables}">`;
            });

            // Replace the content of '.moreManpower' with the updated loader content
            $('.moreManpower').eq(0).html(loader);
        }

</script>

<script>
    var updateCounter = 1;
    var updateCarryForwardLoadingCounter = 1; // Initial state
    var updateRowData = [];

    function updateAddSetData(id) {
        var updateCategoryName = document.getElementById('categoryname' + id).value;
        var updateDays = document.getElementById("days" + id).value;
        var updateLeaveRules = document.getElementById('leaverules' + id).value;
        var updateCarryForward = document.getElementById("carryforward" + id).value;
        var updateApplicables = document.getElementById('applicables' + id).value;
        if (updateDays !== '' && updateCarryForward !== '' && updateCategoryName !== '' && updateLeaveRules !== '' && updateApplicables !== '') {
            updateAddSetData1(id);
            document.getElementById("categoryname" + id).value = "";
            document.getElementById("days" + id).value = "";
            document.getElementById("carryforward" + id).value = "";
        } else {
            alert("All Fields are Required!!");
        }
    }

    function updateAddSetData1(id) {
        $('#displayTable' + id).show();
        var table = document.getElementById("displayTable" + id);
        var row = table.insertRow(-1);
        var categoryNameCell = row.insertCell(0);
        var daysCell = row.insertCell(1);
        var leaveRulesCell = row.insertCell(2);
        var carryForwardCell = row.insertCell(3);
        var applicablesCell = row.insertCell(4);
        var actionCell = row.insertCell(5);

        var updateCategoryNameValue = document.getElementById('categoryname' + id).value;
        var updateDaysValue = document.getElementById('days').value;
        var updateCarryForwardValue = document.getElementById('carryforward' + id).value;
        var updateLeaveRulesValue = document.getElementById('leaverules' + id).value;
        var updateApplicablesValue = document.getElementById('applicables' + id).value;

        updateRowData.push({
            categoryname: updateCategoryNameValue,
            days: updateDaysValue,
            carryforward: updateCarryForwardValue,
            leaveRules: updateLeaveRulesValue,
            applicables: updateApplicablesValue
        });

        categoryNameCell.innerHTML = updateCategoryNameValue;
        daysCell.innerHTML = updateDaysValue;
        carryForwardCell.innerHTML = updateCarryForwardValue;
        leaveRulesCell.innerHTML = updateLeaveRulesValue;
        applicablesCell.innerHTML = updateApplicablesValue;

        var deleteButton =
            "<button type='button' class='btn btn-primary btn-sm float-left text-uppercase'><i class='fa fa-minus fa-fw'></i></button>";
        actionCell.innerHTML = deleteButton;

        $(actionCell).on(function (e) {
            var row = actionCell.parentNode;
            var rowIndex = row.rowIndex;
            updateRowData.splice(rowIndex - 1, 1);
            row.parentNode.removeChild(row);
            LoaderArray();
        });

        LoaderArray(id);

        return true;
    }

    function LoaderArray(id) {
        var updateLoader = '';

        updateRowData.forEach(function (data) {
            updateLoader += `<input type="text" name="category_name[]" value="${data.categoryname}">
               <input type="text" name="update_days[]" value="${data.days}">
               <input type="text" name="update_unused_leave_rule[]" value="${data.leaveRules}">
               <input type="text" name="update_carry_forward_limit[]" value="${data.carryforward}">
               <input type="text" name="update_applicable_to[]" value="${data.applicables}">
               `;
        });

        $('.moreManpowers' + id).eq(0).html(updateLoader);
    }
</script>

@endsection