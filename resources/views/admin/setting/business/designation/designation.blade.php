@extends('admin.setting.setting')
@section('subtitle')
Salary / Department Setting
@endsection

@section('css')
<style>
    .dataTables_wrapper .dt-buttons {
        float: none;
        text-align: center;

    }

    .top {
        padding: 10px;
    }

    th {
        text-align: center;
    }

    /* Aman Sir */
    .animatedBtn {
        position: relative;
        animation-name: example;
        animation-duration: 200ms;
    }

    @keyframes example {
        0% {
            left: 30px;

        }

        100% {
            left: 0px;

        }
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection

@section('settings')
<div class="page-header d-md-flex d-block">
    @php
    $Designation = App\Helpers\Central_unit::DesignationList();
    $Department = App\Helpers\Central_unit::DepartmentList();
    $Branch = App\Helpers\Central_unit::BranchList();
    $i = 0;
    $j = 1;
    foreach ($Designation as $item) {
    $i++;
    }

    @endphp
    <div class="page-leftheader">
        <div class="page-title">Designation Setting</div>
        <p class="text-muted">{{$i}} Active Designation</p>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block">
                <div class="btn-list">
                    <button type="reset" id="addNewDepartment" class="btn btn-outline-dark" data-bs-toggle="modal"
                        data-bs-target="#clockinmodal">Assign Designation</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="card">
        <div class="card-header  border-0">
            <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Designation</b></span></h4>
        </div>

        <div class="card-body d-none" id="addDepartment">
            <div class="row">
                <div class="card" style="color: rgb(56, 113, 117)">
                    <div class="card-header  border-0">
                        <div>
                            <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Add Designation
                                        Detail</b></span></h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{route('add.designation')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label"> Designation Name</p>
                                        <input name="designation" type="text" class="form-control" value=""
                                            placeholder="Enter Name" aria-label="Search" tabindex="1" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Branch</p>
                                        <select name="branch" class="form-control select2"
                                            data-placeholder="Department" required>
                                            @foreach ($Branch as $branch)
                                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Deparment</p>
                                        <select name="department" class="form-control select2"
                                            data-placeholder="Department" required>
                                            @foreach ($Department as $department)
                                            <option value="{{$department->id}}">{{$department->depart_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3 my-auto">
                                    <button type="submit" id="SaveNewDepartment" class="btn btn-outline-success d-none"
                                        data-bs-toggle="modal" data-bs-target="#clockinmodal">Save Department</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="card-header  border-0">
                        <div>
                            <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Add Employees</b></span>
                            </h5>
                            <p class="text-muted">You can add active Employees</p>
                        </div>
                    </div>
                    <div class="card-body" style="height:15rem; overflow:scroll">
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
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><i
                                                class="feather feather-edit  text-primary"></i></a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </td>
                                </tr>
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
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><i
                                                class="feather feather-edit  text-primary"></i></a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </td>
                                </tr>
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
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><i
                                                class="feather feather-edit  text-primary"></i></a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </td>
                                </tr>
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
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><i
                                                class="feather feather-edit  text-primary"></i></a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </td>
                                </tr>
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
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><i
                                                class="feather feather-edit  text-primary"></i></a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </td>
                                </tr>
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
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit"><i
                                                class="feather feather-edit  text-primary"></i></a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete"><i
                                                class="feather feather-trash-2 text-danger"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="card-body ant-table" style="padding:0px">
            <div class="table-responsive">
                <table class="table  table-vcenter text-nowrap  border-bottom " id="example10">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Designation Name</th>
                            <th class="border-bottom-0">Department Name</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Designation as $item)
                        <tr>
                            <td class="font-weight-semibold">{{$j++;}}.</td>
                            <td class="font-weight-semibold">{{$item->desig_name}}</td>
                            <td class="font-weight-semibold">{{$item->depart_name}}</td>
                            <td>
                                <div class="d-flex">
                                    <div id="actionBtn{{$j}}" class="d-none">
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="modal"
                                            data-bs-target="#editBranchName" id="BranchEditbtn" title="Edit">
                                            <i class="feather feather-edit  text-dark"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="modal"
                                            data-bs-target="#desigDeletebtn{{$item->id}}" id="BranchEditbtn"
                                            title="Edit">
                                            <i class="feather feather-trash  text-dark"></i>
                                        </a>
                                    </div>
                                    <div class="ms-auto"><i id="{{$j}}" onclick="btnFunc(this)"
                                            class="btn si si-options-vertical ms-auto"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($Designation as $item)
{{-- @dd($Designation); --}}
<div class="modal fade" id="desigDeletebtn{{$item->id}}" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body">
                <h3>Are you sure want to Delete, <span class="text-primary">{{$item->desig_name}}</span> ?</h3>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">Decline</button>
                <form method="POST" action="{{route('delete.designation',$item->id)}}">
                    @csrf
                    <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>



<script>
    new DataTable('#example10', {
        dom: '<"top"lfB>rtip'
        , buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
    , });

</script>
<script>
    function btnFunc(e){
        // document.getElementByClassName('animatedBtn').classList.replace(animatedBtn,d-none);
        document.getElementById("actionBtn"+e.id).classList.toggle("d-none");
        document.getElementById("actionBtn"+e.id).classList.toggle("animatedBtn");
    }
</script>
@endsection