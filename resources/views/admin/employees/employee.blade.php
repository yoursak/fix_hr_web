@extends('admin.pagelayout.master')
<script src="{{ asset('assets/js/cities.js?v=2.34') }}"></script>
@section('title')
Employee
@endsection

@section('js')

<script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js?v1.3') }}"></script>
<script src="{{ asset('assets/plugins/formwizard/fromwizard.js?v3.80') }}"></script>
<script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
<script src="{{ asset('assets/js/filupload.js?v=10') }}"></script>
<script>
    LoaderPackageDropify('load', 'Employee Bulk Upload Select Excel File');
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

    #btnXyz:hover {
        color: #fff
    }
</style>

@section('content')
<livewire:admin.employee-page>

    @endsection

    @section('js')

    <script>
        window.addEventListener('close-modal', event => {

        $('#studentModal').modal('hide');
        $('#updateStudentModal').modal('hide');
        $('#deleteStudentModal').modal('hide');
    })
    </script>
    @endsection