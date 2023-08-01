@extends('admin.setting.setting')
@section('subtitle')
    Salary / Admin Setting
@endsection

@section('css')
@endsection
@section('settings')

<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Share Employee App</div>
        <p class="text-muted">We will send them an SMS with invite link</p>
    </div>
    <div class="page-rightheader ms-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
            <div class="d-lg-flex d-block">
                <div class="btn-list">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#clockinmodal" id="">Send All at Once</button>
                        <a href="#" class="btn btn-outline-primary d-none"><i
                            class="si si-paper-plane  text-primary"></i>Send Only Selected</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-body border-bottum-0 " id="">
            <table class="table mb-0 text-nowrap">
                <tbody>
                    <tr class="border-bottom">
                        <td>
                            <label class="custom-switch">
                                <input type="checkbox" name="custom-switch-checkbox"
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="me-3 mt-0 mt-sm-1 d-block">
                                    <h6 class="mb-0">Faith Harris</h6>
                                    <div class="clearfix"></div>
                                    <small class="text-muted">UI designer</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-start fs-13">+91 1234567890</td>
                        <td class="text-end">
                            <a href="javascript:void(0);" class="action-btns"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Send SMS"><i
                                    class="si si-paper-plane  text-primary"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class=" text-end">
    <a href="{{url('settings/businesssetting')}}" class="btn btn-success" id="formsave" data-bs-toggle="tooltip" data-bs-placement="top" title="Save">Apply Changes</a>
</div>
@endsection
