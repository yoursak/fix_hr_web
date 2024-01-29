@extends('admin.pagelayout.master')
<script src="{{ asset('assets/js/cities.js?v=2.34') }}"></script>
@section('title')
Employee
@endsection
@section('css')
{{--
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" /> --}}
@endsection

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