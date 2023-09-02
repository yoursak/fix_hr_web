@extends('admin.setting.setting')
@section('subtitle')
Roles And Permissions
@endsection
@section('settings')
<!-- ROW -->
<div class="row">
    <div class="col-xl-3">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Designations</h4>
            </div>
            <div class="nav flex-column admisetting-tabs" id="settings-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" data-bs-toggle="pill" href="#tab-1" role="tab">
                    <i class="nav-icon las la-cog"></i> General Settings
                </a>
                <a class="nav-link"  data-bs-toggle="pill" href="#tab-2" role="tab">
                    <i class="nav-icon las la-envelope"></i> Email Settings
                </a>
                <a class="nav-link"  data-bs-toggle="pill" href="#tab-3" role="tab">
                    <i class="nav-icon lar la-credit-card"></i> Payment Settings
                </a>
                <a class="nav-link" data-bs-toggle="pill" href="#tab-4" role="tab">
                    <i class="nav-icon las la-lock"></i> Security Settings
                </a>
                <a class="nav-link"  data-bs-toggle="pill" href="#tab-5" role="tab">
                    <i class="nav-icon las la-share-alt"></i> Social Settings
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-9">
        <div class="tab-content adminsetting-content" id="setting-tabContent">
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="card-title">Security Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Email Verification</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Update</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Debug</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Register</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Google Captcha</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" >
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th class=" border-bottom-0">Module Permission</th>
                                    <th class=" border-bottom-0 text-center">Read</th>
                                    <th class=" border-bottom-0 text-center">Write</th>
                                    <th class=" border-bottom-0 text-center">Create</th>
                                    <th class=" border-bottom-0 text-center">Delete</th>
                                    <th class=" border-bottom-0 text-center">Import</th>
                                    <th class=" border-bottom-0 text-center">Export</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Employee</td>
                                    <td >
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="card-footer">
                            <a  href="javascript:void(0);" class="btn btn-success">Save Changes</a>
                            <a  href="javascript:void(0);" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                <div class="card">
                    <div class="card-header  border-0">
                        <h4 class="card-title">Security Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Email Verification</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Update</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Debug</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Register</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Google Captcha</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" >
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-3" role="tabpanel">
                <div class="card">
                    <div class="card-header  border-0">
                        <h4 class="card-title">Security Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Email Verification</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Update</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Debug</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Register</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Google Captcha</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" >
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-4" role="tabpanel">
                <div class="card">
                    <div class="card-header  border-0">
                        <h4 class="card-title">Security Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Email Verification</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Update</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Debug</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Register</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Google Captcha</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" >
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-5" role="tabpanel">
                <div class="card">
                    <div class="card-header  border-0">
                        <h4 class="card-title">Security Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Email Verification</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Update</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">App Debug</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Register</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label">Google Captcha</label>
                                </div>
                                <div class="col-2 pe-0">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" >
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ROW -->
@endsection