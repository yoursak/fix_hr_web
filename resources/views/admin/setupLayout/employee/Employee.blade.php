@extends('admin.setupLayout.master')
@section('title', 'Dashboard')
@section('js')
    <script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js?v1.3') }}"></script>
    <script src="{{ asset('assets/plugins/formwizard/fromwizard.js?v3.80') }}"></script>
    <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/filupload.js?v=10') }}"></script>
    <script>
        LoaderPackageDropify('load', 'Employee Bulk Upload Select Regular Excel File');
        LoaderPackageDropify('load2', 'Employee Bulk Upload Select Contractual Excel File');
    </script>
@endsection
@section('content')
    <div class="iniitial-header m-4">
        <h2 class="m-0"><b>Welcome to FixHR</b></h2>

        <p class="fs-16 text-muted">Kindly complete step by step process to register your business with us, do not skip setup
            process other wise it will not function</p>
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
                            <div class=" col-xl-6 col-sm-12 text-center     " id="regularEmployeeAdddd">
                                <div>
                                    <h4><b>Regular Employee</b></h3>
                                </div>
                                <div>
                                    {{-- <a type="button" class="modal-effect btn btn-outline-primary my-2 border-0"
                                            data-bs-toggle="modal" data-effect="effect-scale" data-bs-target="#newStudentModal"><b>
                                                Add
                                                Employee</b></a> --}}
                                    <a href="{{ url('admin/employee/export_file/1') }}"
                                        class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="{{ url('admin/employee/export_file') }}"><b><i
                                                class="fa fa-file-excel-o me-1"></i>Download
                                            Sample Template</b>
                                    </a>
                                    <form action="{{ url('admin/employee/import_file') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="text" id="emp_type" name="emp_type" value="1" hidden>
                                        <input type="file" name="csv_file" class="load" data-height="90"
                                            data-allowed-file-extensions="xlsx">
                                        <button type="submit" class="btn btn-outline-primary my-2 border-0"> <b>Upload
                                                Employees</b></button>
                                    </form>

                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-12 justify-content-center   " id="contractualEmployeeAdd">
                                {{-- <div class="row justify-content-center  ">
                                    <div class="col-sm-10 justify-content-center">
                                        <p class="form-label">Select Contractual Type</p>
                                        <div class="form-group ">
                                            <select id="ContractType" wire:model="employee_contractual_type"
                                                name="contractualtype" class="form-control">
                                                <option value="" selected>Select Contractual Type</option>
                                                @foreach ($getContractualType as $item)
                                                    <option value="<?= $item->id ?>"><?= $item->contractual_type ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div>

                                    <h4 class="text-center"><b>Contractual Employee</b></h3>
                                </div>

                                <div class="text-center">
                                    {{-- <a type="button" class="modal-effect btn btn-outline-primary my-2 border-0"
                                        data-bs-toggle="modal" data-effect="effect-scale"
                                        data-bs-target="#newStudentModal"><b>
                                            Add
                                            Employee</b></a> --}}
                                    <a href="{{ url('admin/employee/export_file/2') }}"
                                        class="btn btn-outline-primary my-2 border-0" data-bs-toggle="modal"
                                        data-bs-target="{{ url('admin/employee/export_file/2') }}"><b><i
                                                class="fa fa-file-excel-o me-1"></i>Download
                                            Sample Template</b>
                                    </a>
                                    <form action="{{ url('admin/employee/import_file') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="text" id="emp_type" name="emp_type" value="2" hidden>
                                        <input type="file" name="csv_file" class="load2" data-height="90"
                                            data-allowed-file-extensions="xlsx">
                                        <button type="submit" class="btn btn-outline-primary my-2 border-0"> <b>Upload
                                                Employees</b></button>
                                    </form>

                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>
    <div class="d-flex justify-content-between m-3">
        <div>
            <a href="{{ url('setup/subscription') }}" class="btn btn-primary">Previous</a>
        </div>
        <div class="">
            <button id="saveButton" class="btn btn-primary" onclick="showSwal()">Finish</button>
            {{-- <a href="{{ url('/') }}" id="saveButton" class="btn btn-primary">Finish</a> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      function showSwal() {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Your business has been created successfully!',
        timer: 2000,
        showConfirmButton: false,
        willClose: () => {
            // Make an Ajax request to clear the session
            $.ajax({
                url: "{{ route('clear-session') }}",
                method: 'GET',
                success: function (response) {
                    console.log('Session cleared successfully');
                },
                error: function (error) {
                    console.error('Error clearing session:', error);
                }
            });

            // Redirect after the alert is closed
            window.location.href = "{{ url('/') }}";
        },
    });
}

    </script>
@endsection
