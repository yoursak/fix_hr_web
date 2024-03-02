@extends('admin.setupLayout.master')

@section('title')
    Dashboard
@endsection
@section('content')
    <div class="row mt-3 mx-2">
        <div class="card">
            <div class="card-header">
                <h3>Welcome to Fix HR</h3>

            </div>

            <div class="card-body">
                <h4>Fix HR offers the following features to help you set up your business.</h4>
                {{-- Let's organize the information and create a step-by-step guide for setting up your business: --}}
                <div>
                    <ul class="fs-18">
                        <li class=" mb-3 ">
                            <i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip" title=""
                                data-bs-original-title="fa fa-universal-access" aria-label="fa fa-universal-access"> </i>
                            &nbsp; Create or update your business account settings, including essential information such as
                            company
                            name,
                            contact details,
                            and address.

                        </li>
                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Add or update multiple branches, departments, and designations based on your business structure
                            and
                            requirements.
                        </li>

                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Set up custom templates for leave, holiday, and week-off policies tailored to your company's
                            policies
                            and
                            regulations.
                        </li>
                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Create custom shift templates to manage employee work schedules efficiently and accommodate
                            various
                            shifts.
                        </li>

                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Configure and set up multiple modes of attendance, such as QR codes, facial recognition, or
                            other
                            methods,
                            to suit your
                            business needs.
                        </li>
                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Enable the system to manage leaves, mis-punch corrections, and gate pass requests to streamline
                            employee
                            requests.
                        </li>
                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Establish automation rules for attendance to simplify tracking and management of employee
                            working
                            hours.
                        </li>

                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Set up permissions for camera access, particularly if you're using QR codes or facial
                            recognition
                            for
                            attendance
                            tracking.
                        </li>


                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Assign separate policies and shifts to individual employees based on their roles and
                            responsibilities
                            within
                            the
                            company.
                        </li>
                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Download daily or monthly attendance reports to monitor and analyse employee attendance
                            patterns.
                        </li>
                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Generate leave balance reports to keep track of employee leave entitlements and usage.
                        </li>
                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Download or upload bulk employee data to ensure accurate and efficient data management.
                        </li>
                        <li class="mb-3"><i class="fa fa-universal-access text-primary" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="fa fa-universal-access"
                                aria-label="fa fa-universal-access"></i> &nbsp;
                            Manage admin setup by assigning different roles and permissions to various users within the
                            system.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div>
            {{-- <a href="{{ url('/setup/set-all-mode') }}" class="btn btn-primary">Previous</a> --}}
        </div>
        <div class="">
            <a href="{{ url('/setup/account-settings') }}" class="btn btn-primary">Next</a>
        </div>
    </div>
@endsection
