@extends('admin.setupLayout.master')
@section('title', 'Dashboard')

@section('content')
    <div class="iniitial-header m-5">
        <h2><b>FixingDots Pvt.Ltd</b></h2>
        <span class="fs-16">
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Account Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Business Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Attendance Setting<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Setup Activation<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Subscription<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class=""><i class="fa fa-circle mx-2 text-primary"></i>Add Employee<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
            <span class="text-muted"><i class="fa fa-circle mx-2"></i>Finish<i
                    class="fa fa-angle-right my-auto mx-2"></i></span>
        </span>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex justify-content-center my-auto">
                <div class="card p-5">
                    <div class="iniitial-header">
                        <h4><b>Add Employee</b></h3>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-6 text-center">

                                <h3><b style="color: rgb(22, 109, 83)">Regular Employee</b></h3>
                                <div>
                                    <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="#addempmodal"><b>Add Employee</b></a>
                                    <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Upload Bulk</b>
                                    </a>
                                    
                                </div><a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Download Sample
                                            Template</b>
                                    </a>
                            </div>
                            <div class="col-xl-6 text-center">
                                <h3 class="text-center"><b style="color: rgb(22, 109, 83)">Contractual Employee</b></h3>

                                <div class="text-center">
                                    <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="#addempmodal"><b>Add Employee</b></a>
                                    <a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Upload Bulk</b>
                                    </a>
                                    
                                </div><a class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="#"><b><i class="fa fa-file-excel-o me-1"></i>Download Sample
                                            Template</b>
                                    </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div>
            <a href="{{ url('setup/subscription') }}" class="btn btn-primary">Previous</a>
        </div>

        <div class="">
            <a href="{{ url('/') }}" class="btn btn-primary">Finish</a>
        </div>
    </div>
    @endsection
