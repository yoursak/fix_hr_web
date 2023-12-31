<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- Developed By fixingfots.com/FixingDots/index2    /3.x [XR&CO'2014], Tue, 18 Jul 2023 06:20:41 GMT -->
<!-- Added   -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added   -->

<head>
    @include('admin.layout.head')
    <style>
        .rotate {
            transition: 500ms;
            transform: rotate(90deg);
            /* Adjust the desired rotation value */
        }

        .bg-inf {
            background-color: #a3d5dd;
            /* Change to your desired color */
        }
    </style>
</head>

<body class="app sidebar-mini ltr">

    <div class="row m-5">
        <div class="page-header d-block">
            <div class="page-leftheader d-flex justify-content-center">
                <h1 class="display-5">Create Your Business Portfolio</h1>
            </div>
            <div class="page-rightheader ms-md-auto">
                <div class="d-flex justify-content-center flex-wrap my-auto end-content breadcrumb-end">
                    <div class="d-lg-flex d-block">
                        <div class="btn-list">
                            <button type="button" id="addNewBranch" class="btn btn-outline-dark" data-bs-toggle="modal"
                                data-bs-target="#branchName">Add Branch</button>
                            <button type="button" id="addNewDepart" class="btn btn-outline-dark" data-bs-toggle="modal"
                                data-bs-target="#departName">Add Department</button>
                            <button type="button" id="addNewDesig" class="btn btn-outline-dark" data-bs-toggle="modal"
                                data-bs-target="#desigName">Add Designation</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card" id="repoerCard4">
                <div class="card-body border-bottum-0">
                    <div class="row">
                        <div class="col-11 my-auto">
                            <div class="row">
                                <div class="col-xl-9 my-auto">
                                    <h5 class="my-auto">FixingDots</h5>
                                </div>
                                <div class="col-xl-3">
                                    <p class="my-auto text-muted text-end">
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="modal"
                                            data-bs-target="#editBranchName" id="BranchEditbtn" title="Edit">
                                            <i class="feather feather-edit  text-dark"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="action-btns" data-bs-toggle="tooltip"
                                            data-bs-placement="top" id="BranchDeletebtn" title="Delete">
                                            <i class="feather feather-trash text-dark"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 my-auto text-end">
                            <i class="fe fe-chevron-right fs-30 btn " id="reportBtn4"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottum-0 m-3" id="contentCard4">
                    <div class="row">
                        <div class="card" id="repoerCard2">
                            <div class="card-header  border-0">
                                <h4 class="card-title"><span style="color:rgb(104, 96, 151)"><b>Department</b></span>
                                </h4>
                            </div>
                            <div class="card-body border-bottum-0">
                                <div class="row">
                                    <div class="col-11 my-auto">
                                        <div class="row">
                                            <div class="col-xl-8 my-auto">
                                                <h5 class="my-auto">Informaton Technology</h5>
                                            </div>
                                            <div class="col-xl-3">
                                                <p class="my-auto text-muted text-end">
                                                    <a href="javascript:void(0);" class="action-btns"
                                                        data-bs-toggle="modal" data-bs-target="#editBranchName"
                                                        id="BranchEditbtn" title="Edit">
                                                        <i class="feather feather-edit  text-dark"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-btns"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        id="BranchDeletebtn" title="Delete">
                                                        <i class="feather feather-trash text-dark"></i>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1 my-auto text-end">
                                        <i class="fe fe-chevron-right fs-30 btn " id="reportBtn2"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card" id="contentCard2">
                                <div class="card-header  border-0">
                                    <h4 class="card-title"><span
                                            style="color:rgb(104, 96, 151)"><b>Designation</b></span></h4>
                                </div>
                                <div class="card-body border-bottum-0">
                                    <div class="row">
                                        <div class="col-xl-9 my-auto">
                                            <h5 class="my-auto">Software Engineer</h5>
                                        </div>
                                        <div class="col-xl-3">
                                            <p class="my-auto text-muted text-end">
                                                <a href="javascript:void(0);" class="action-btns"
                                                    data-bs-toggle="modal" data-bs-target="#editBranchName"
                                                    id="BranchEditbtn" title="Edit">
                                                    <i class="feather feather-edit  text-dark"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="action-btns"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    id="BranchDeletebtn" title="Delete">
                                                    <i class="feather feather-trash text-dark"></i>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" text-end">
            <a href="{{ url('/') }}" class="btn btn-primary" id="formsave" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Save">Save & continue</a>
            <a href="{{ url('/') }}" class="btn btn-outline-primary" id="formsave" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Save">Skip</a>
        </div>
    </div>

    {{-- Edit Branch Name --}}
    <div class="modal fade" id="editBranchName">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Edit Branch Name</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Name</p>
                        <input class="form-control" placeholder="Business Name" type="text" value="Fixing Dots">
                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Branch Name --}}
    <div class="modal fade" id="branchName">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Branch Name</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Branch Name</p>
                        <input class="form-control" placeholder="Business Name" type="text">
                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Department Name --}}
    <div class="modal fade" id="departName">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Department Name</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <div class="form-group">
                            <p class="form-label">Branch</p>
                            <select class="form-control select2" data-placeholder="Department">
                                <option label="Fixed Amount"></option>
                                <option selected>Fixing Dots</option>
                                <option>KES</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <p class="form-label">Department Name</p>
                            <input type="text" class="form-control" value="" placeholder="Enter Name"
                                aria-label="Search" tabindex="1">
                        </div>
                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Save & Continue</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Designation Name --}}
    <div class="modal fade" id="desigName">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-header border-0">
                    <h4 class="modal-title ms-2">Designation Name</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg">
                        <div class="form-group">
                            <p class="form-label">Branch</p>
                            <select class="form-control select2" data-placeholder="Department">
                                <option label="Fixed Amount"></option>
                                <option selected>Fixing Dots</option>
                                <option>KES</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <p class="form-label">Department</p>
                            <select class="form-control select2" data-placeholder="Department">
                                <option label="Fixed Amount"></option>
                                <option selected>Fixing Dots</option>
                                <option>KES</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <p class="form-label">Designation Name</p>
                            <input type="text" class="form-control" value="" placeholder="Enter Name"
                                aria-label="Search" tabindex="1">
                        </div>

                        <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                                class="text-primary">Terms & Conditions</a></p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary savebtn">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BACK TO TOP -->
    <a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>

    @yield('script')
    @include('admin.layout.script')
</body>

<!-- Developed By fixingfots.com/FixingDots/index2    /3.x [XR&CO'2014], Tue, 18 Jul 2023 06:20:43 GMT -->

</html>
