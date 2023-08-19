<div>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="card-title">{{$title}}</h4>
                    <div class="page-rightheader ms-auto">
                        <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                            <div class="btn-list d-flex">
                                <a class="modal-effect btn btn-outline-primary border-0 my-auto"
                                    data-effect="effect-scale" data-bs-toggle="modal" href="#empType">Add New
                                    Employee</a>
                                {{-- <button class="btn btn-outline-light border-0" data-bs-toggle="tooltip"
                                data-bs-placement="top">
                                <div class="dropdown profile-dropdown">

                                    <a href="javascript:void(0);" class="nav-link leading-none my-auto "
                                        data-bs-toggle="dropdown">
                                        <span><i class="feather feather-credit-card me-1"></i>Make Bulk
                                            Payment</span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                                        <a class=" dropdown-item d-flex" href="{{ url('onlinepay/makepayment') }}">
                                            <div class="mt-1">Online Pay</div>
                                        </a>
                                        <a class="dropdown-item d-flex" href="{{ url('onlinepay/payment_entry') }}">
                                            <div class="mt-1">Save Payment Entry</div>
                                        </a>

                                        <a class=" dropdown-item d-flex"
                                            href="{{ url('onlinepay/bulkallowance') }}">
                                            <div class="mt-1">Allowance/Deduction/Bonus </div>
                                        </a>
                                    </div>
                                </div>
                            </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Branch:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Branch">
                                    <option label="Select Branch"></option>
                                    <option value="1">Raipur</option>
                                    <option value="2">Gudgaon</option>
                                    <option value="3">Ludhiana</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Department:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Department">
                                    <option label="Select Department"></option>
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
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Designation:</label>
                                <select name="attendance" class="form-control custom-select select2"
                                    data-placeholder="Select Designation">
                                    <option label="Select Designation"></option>
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
                        <div class="col-md-12 col-xl-2">
                            <div class="form-group">
                                <label class="form-label">Employee:</label>
                                <input type="search" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-2 m-auto">

                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-primary btn-sm">Copy</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">CSV</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">Excel</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">PDF</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">Print</button>
                        </div>
                    </div>
                    </div>
                       
                    <div class="row">

                    </div>
                </div>
                <div class="card-body ant-table" style="padding:0px">   

                    <div class="table-responsive" style="text-align: center;">


                        <table class="table  table-vcenter text-nowrap  border-bottom" id="example">

                            <thead>
                             
                                <tr>
                                    {{-- <th class="border-bottom-0">S. No.</th> --}}
                                    <th class="border-bottom-0 text-center">Employee Name</th>
                                    <th class="border-bottom-0 w-5 text-center">Employee ID</th>
                                    <th class="border-bottom-0 text-center">Department</th>
                                    <th class="border-bottom-0 text-center">Designation</th>
                                    <th class="border-bottom-0 text-center">Joining Date</th>
                                    <th class="border-bottom-0 text-center">Phone Number</th>
                                    {{-- <th class="border-bottom-0">Add Payment</th> --}}
                                    <th class="border-bottom-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody style="padding: 0px;">
                                <tr>
                                    {{-- <td>1</td> --}}
                                    <td style="text-align: center">
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround me-3"
                                                style="background-image: url()"></span>
                                            <div class="my-auto">
                                                <h6 class="mb-1 fs-14 my-auto"><a href="{{ url('/emprofile') }}">Aman
                                                        Sahu</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>FD2987</td>
                                    <td>Designing Department</td>
                                    <td>Web Designer</td>
                                    <td>05-05-2017</td>
                                    <td>+9685321475</td>
                                    {{-- <td>
                                    <a class="modal-effect btn btn-outline-primary border-0 btn-block mb-3"
                                        data-effect="effect-super-scaled" data-bs-toggle="modal"
                                        href="#modaldemo8">Add Payment</a>
                                </td> --}}
                                    <td>
                                        <div class="d-flex">
                                            <div id="actionBtn1" class="d-none">
                                                <a href="javascript:void(0);" class="action-btns1 "
                                                    data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                    <i class="feather feather-edit secondary text-secondary"
                                                        data-bs-toggle="tooltip" data-original-title="View"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="action-btns1"
                                                    data-bs-toggle="modal" data-bs-target="#deletemodal">
                                                    <i class="feather feather-trash danger text-danger"
                                                        data-bs-toggle="tooltip" data-original-title="View"></i>
                                                </a>
                                            </div>

                                            <div class="toggle-effect ms-auto" data-bs-toggle="modal" data-bs-traget=""> <a class="open-toggle"
                                                href="#"> <i id="moreBtn"
                                                    class="si si-options-vertical"></i></a>
                                        </div>
                                        </div>

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