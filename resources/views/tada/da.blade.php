@extends('admin.setting.setting')
@section('subtitle')
    Business
@endsection
@section('settings')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">TA</h4>
    </div>
    <div class="card-body">
        <div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary d-flex justify-content-end" value="1" type="button" id="addButton" onclick="hide_data(this.value);array_data(this.value);" style="height: 50px; display: flex; align-items: center; justify-content: center;">
                    +Add
                </button>
                <input type="hidden" value="1" id="delete_id">
            </div>
        </div>
        <div class="row p-0 m-0">

            <div class="col-xl-2">
                <div class="form-group select2-lg">
                    <label for="field-3" class="form-label"><span style="font-size:15px;">Grade</span><span style="color:red">*</span><span style="font-size:14px; color:black">
                            :</span></label>
                    <select class="form-select form-select-lg select2 select2-hidden-accessible" id="inputGroupSelect012" tabindex="-1" aria-hidden="true">
                        <option value="">Select</option>

                    </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-inputGroupSelect012-container"><span class="select2-selection__rendered" id="select2-inputGroupSelect012-container" title="Select">Select</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="form-group select2-lg">
                    <label for="field-3" class="form-label"><span style="font-size:15px;">Travel
                            Type</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                    <select class="form-select form-select-lg select2 select2-hidden-accessible" id="travel" onchange="travel_select(this)" tabindex="-1" aria-hidden="true">
                        <option value="">Select Travel Type</option>
                        <option value="1">International</option>
                        <option value="2">National</option>
                        <option value="3">Local</option>
                    </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-travel-container"><span class="select2-selection__rendered" id="select2-travel-container" title="Select Travel Type">Select Travel Type</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="col-xl-2" id="limot_0">
                <div class="form-group select2-lg">
                    <label for="field-3" class="form-label"><span style="font-size:15px;">Limit</span><span style="color:red">*</span><span style="font-size:14px; color:black">
                            :</span></label>
                    <select class="form-select form-select-lg select2 select2-hidden-accessible" id="limit" onchange="limit_amount(this)" tabindex="-1" aria-hidden="true">
                        <option value="">Select </option>
                        <option value="1">Set Limit</option>
                        <option value="2">Amount</option>
                    </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-limit-container"><span class="select2-selection__rendered" id="select2-limit-container" title="Select ">Select </span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="form-group select2-lg">
                    <label for="field-3" class="form-label"><span style="font-size:15px;">Amount</span><span style="color:red">*</span><span style="font-size:14px; color:black">
                            :</span></label>
                    <input class="form-control form-control-lg" placeholder="Amount" type="text">
                </div>
            </div>
            <div class="col-xl-2">
                <div class="form-group select2-lg">
                    <label for="field-3" class="form-label"><span style="font-size:15px;">Contry</span><span style="color:red">*</span><span style="font-size:14px; color:black">
                            :</span></label>
                    <select class="form-select form-select-lg select2 select2-hidden-accessible" id="inputGroupSelect012" tabindex="-1" aria-hidden="true">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-inputGroupSelect012-container"><span class="select2-selection__rendered" id="select2-inputGroupSelect012-container" title="One">One</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="form-group select2-lg">
                    <label for="field-3" class="form-label"><span style="font-size:15px;">State</span><span style="color:red">*</span><span style="font-size:14px; color:black">
                            :</span></label>
                    <select class="form-select form-select-lg select2 select2-hidden-accessible" id="inputGroupSelect012" tabindex="-1" aria-hidden="true">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-inputGroupSelect012-container"><span class="select2-selection__rendered" id="select2-inputGroupSelect012-container" title="One">One</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
            </div>
            <div class="col-xl-1 p-0">
                <div class="col-md-1"><button class="btn btn-danger" type="button" id="removeButton_' + cloneCount + '" onclick="deleteRow(this)" style="margin-top: 30px;">X</button></div>
            </div>
        </div>
    </div>
</div>
@endsection
