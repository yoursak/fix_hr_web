@extends('admin.setting.setting')
@section('subtitle')
    Salary / Admin Setting
@endsection

@section('css')
@endsection
@section('settings')

<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Add Staff Account Number</div>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block">
                <div class="btn-list">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#clockinmodal">Excel Bulk Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class=" text-end">
    <a href="{{url('settings/salarysetting')}}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Save</a>
</div>
@endsection
