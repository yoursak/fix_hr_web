@extends('admin.pagelayout.master')

@section('content')
<div>
    <livewire:student-show>
</div>
@endsection

@section('script')
<script>
    window.addEventListener('close-modal', event => {

        $('#studentModal').modal('hide');
        $('#updateStudentModal').modal('hide');
        $('#deleteStudentModal').modal('hide');
    })
</script>
@endsection