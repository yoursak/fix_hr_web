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
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
<form method="POST" action="{{ route('add.department') }}">
    @csrf
    <div class="page-header d-md-flex d-block">
        @php
        $Department = App\Helpers\Central_unit::DepartmentList();
        $Branch = App\Helpers\Central_unit::BranchList();
        // dd($Department);
        $i = 0;
        $j = 1;
        foreach ($Department as $item) {
        $i++;
        }

        @endphp
        <div class="page-leftheader">
            <div class="page-title">Department Setting</div>
            <p class="text-muted">{{ $i }} Active Department</p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button type="reset" id="addNewDepartment" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#clockinmodal">Add Department</button>
                        <button type="submit" id="SaveNewDepartment" class="btn btn-outline-success d-none"
                            data-bs-toggle="modal" data-bs-target="#clockinmodal">Save Department</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Departments</b></span></h4>
            </div>
            <div class="card-body d-none" id="addDepartment">
                <div class="row">
                    <div class="card" style="color: rgb(56, 113, 117)">
                        <div class="card-header  border-0">
                            <div>
                                <h5 class="title"><span style="color:rgb(79, 136, 109)"><b>Add Department
                                            Detail</b></span></h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Branch</p>
                                        <select name='branch' class="form-control select2" data-placeholder="Branch"
                                            required>
                                            @foreach ($Branch as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <p class="form-label">Department's Name</p>
                                        <input name='department' type="text" class="form-control" value=""
                                            placeholder="Enter Name" aria-label="Search" tabindex="1" required>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body ant-table" style="padding:0px">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom " id="example10">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-10">S.No.</th>
                                <th class="border-bottom-0">Branch Name</th>
                                <th class="border-bottom-0">Deparment Name</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                                $Departments = App\Helpers\Central_unit::DepartmentList(); ?>

                            {{-- {{$branchList}} --}}
                            @foreach ($Departments as $items)
                            <tr>
                                <td class="font-weight-semibold">{{ $count++ }}</td>
                                <td class="font-weight-semibold">{{ $items->branch_name }}</td>
                                <td class="font-weight-semibold">{{ $items->depart_name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div id="actionBtn{{ $count }}" class="d-none">
                                            {{-- <a href="javascript:void(0);" class="action-btns"
                                                data-bs-toggle="modal" data-bs-target="#editBranchName"
                                                id="BranchEditbtn" title="Edit">
                                                <i class="feather feather-edit  text-dark"></i>
                                            </a> --}}
                                            <a class="btn" data-bs-target="#modaldemo2"
                                                data-value1="{{ $items->branch_name}}" data-value2="{{ $items->depart_name }}"
                                                data-id="{{ $items->depart_id }}" data-name="{{ $items->depart_name }}"
                                                data-bs-toggle="modal" href="#">
                                                <i class='feather feather-edit  text-dark'
                                                    style='font-size:24px'></i></a>

                                            <a href="javascript:void(0);" class="action-btns" data-bs-toggle="modal"
                                                data-bs-target="#departDeletebtn{{ $items->depart_id }}"
                                                id="BranchEditbtn" title="Edit">
                                                <i class="feather feather-trash  text-dark"></i>
                                            </a>
                                        </div>

                                        <div class="ms-auto"><i id="{{ $count }}" onclick="btnFunc(this)"
                                                class="btn si si-options-vertical ms-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <?php ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</form>

<div class="modal fade" id="modaldemo2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <form method="POST" action="{{ route('admin.updatedepartment', $item->depart_id) }}">
                @csrf

                <div class="modal-header">
                    <h6 class="modal-title">Edit Designation Preview</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="editId" name="editid" value="">

                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <p class="form-label">Branch</p>
                            <input type="text" class="form-control" id="value1" readonly>
                            <select name='editbranch' class="form-control select2" data-placeholder="Branch" required>
                                @foreach ($Branch as $branch)
                                <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            {{-- <p class="form-label">Department</p> --}}
                            {{-- <input type="text" class="form-control" id="value2" readonly> --}}
                            <div class="form-group">
                                <p class="form-label">Department's Name</p>
                                <input name='editdepartment' id="value2" type="text" class="form-control"
                                    placeholder="Enter Name" aria-label="Search" tabindex="1" required>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary savebtn">Update Continue</button>

                </div>
            </form>
        </div>
    </div>

</div>
@foreach ($Department as $item)
{{-- @dd($Department); --}}
<div class="modal fade" id="departDeletebtn{{ $item->depart_id }}" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body">
                <h3>Are you sure want to Delete, <span class="text-primary">{{ $item->depart_name }}</span> ?</h3>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Decline</button>
                <form method="POST" action="{{ route('delete.department', $item->depart_id) }}">
                    @csrf
                    <button type="submit" data-confirm-delete="true" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    new DataTable('#example10', {
            dom: '<"top"lfB>rtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
        });
</script>
<script>
    function btnFunc(e) {
            // document.getElementByClassName('animatedBtn').classList.replace(animatedBtn,d-none);
            document.getElementById("actionBtn" + e.id).classList.toggle("d-none");
            document.getElementById("actionBtn" + e.id).classList.toggle("animatedBtn");
    }
      
</script>
<script>
    $(document).ready(function() {
    $('#modaldemo2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var value1 = button.data('value1');
        var value2 = button.data('value2');
        console.log(value1);
        $('#value1').val(value1);
        $('#value2').val(value2);
        
        $('#editId').val(id);
        $('#editName').val(name);
        });
    });
</script>
@endsection

@endsection