@extends('admin.pagelayout.master')
@section('title')
    Employee
@endsection
@section('css')
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js?v1.3') }}"></script>
    <script src="{{ asset('assets/plugins/formwizard/fromwizard.js?v3.80') }}"></script>
    <script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ asset('assets/js/filupload.js?v=10') }}"></script>

    <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.min.js') }}"></script>
    <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.js') }}"></script>

    <script>
        LoaderPackageDropify('load', 'Employee Bulk Upload Select Regular Excel File');
        LoaderPackageDropify('load2', 'Employee Bulk Upload Select Contractual Excel File');
    </script>
@endsection

<style>
    .emp-id-exists {
        border-color: red;
        color: red;
    }

    .message-exists {
        color: red;
    }

    /* #btnXyz:hover {
        color: #fff
    } */

    table td {
        padding: 0;
    }
</style>


@section('content')
    <livewire:admin.employee-page>
    @section('js')
        <script>
            window.addEventListener('close-modal', event => {

                $('#studentModal').modal('hide');
                $('#updateStudentModal').modal('hide');
                $('#deleteStudentModal').modal('hide');
            })
        </script>
    @endsection
@endsection
