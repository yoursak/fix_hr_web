@extends('admin.pagelayout.master2')
@section('title')
    Setup Activation | Create Shift
@endsection
@section('css')
@endsection
@section('content')

<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Travel Type</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary d-flex justify-content-end" value="1" type="button" id="addButton" onclick="hide_data(this.value);array_data(this.value);" style="height: 50px; display: flex; align-items: center; justify-content: center;">
                        +Add
                    </button>
                    <input type="hidden" value="1" id="delete_id">
                </div>
                <div class="row p-0 m-0">
                    {{-- <div class="col-xl-1">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Grade</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                            <select class="form-select form-select-lg select2" id="grade">
                                <option value="">Select</option>
                                @foreach ($grade_list as $item)
                                <option value="<?php $item->id ?>">{{ $item->grade_name}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div> --}}
                    <div class="col-xl-2">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;" id="">Travel Type</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                            <select class="form-select form-select-lg select2" id="travel" onchange="travel_select(this)">
                                    <option value="">Select Travel Type</option>
                                    <option value="1">International</option>
                                    <option value="2">Out Station</option>
                                    <option value="3">Local</option>
                                </select>
                        </div>
                    </div>
                    <div class="col-xl-2" id="country_0">
                        <div class="form-group select2-lg">

                            {{-- <div class="form-group row"> --}}
                                <div class="">
                                    <label for="field-3" class="form-label"><span style="font-size:15px;">Country</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                                    {{-- <label class="form-label">Search Select-4:</label> --}}
                                    <select multiple="multiple" class="SlectBox-grp-src" id="country">
                                        <option selected>Select</option>
                                        @php
                                            $no = 1;
                                            @endphp
                                        @empty(!$country_list)
                                            @foreach ($country_list as $item)
                                                <option value="<?= $item->id ?>"> <?= $no++ ?>&nbsp;|&nbsp;<?= $item->name ?>&nbsp;</option>
                                            @endforeach
                                        @endempty
                                    </select>
                                </div>
                            {{-- </div> --}}
                            {{-- <select class="form-select select2 custom-select country" name="shiftsetting[]" data-placeholder="Choose Shift Policy" multiple required onclick="select_country()">
                                <option>Select</option>
                                @php
                                    $no = 1;
                                @endphp
                                @empty(!$country_list)
                                    @foreach ($country_list as $item)
                                        <option value="<?= $item->id ?>"> <?= $no++ ?>&nbsp;|&nbsp;<?= $item->name ?>&nbsp;</option>
                                    @endforeach
                                @endempty
                            </select> --}}
                        </div>
                    </div>

                    <div class="col-xl-1" id="limot_0">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Limit</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                            <select class="form-select form-select-lg select2" id="limit" onchange="limit_amount(this)">
                                <option value="">Select </option>
                                <option value="1">Set Limit</option>
                                <option value="2">Amount</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-1">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Amount</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                            <input class="form-control form-control-lg" placeholder="Amount" type="text" id="amount">
                        </div>
                    </div>
                    <div class="col-xl-2" id="state_0">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">State</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                            <select class="form-select form-select-lg select2 " id="state" onchange="change_state(this)">
                                <option value="">Select State</option>
                                @foreach ($state_list as $item)
                                <option value="{{ $item->id }}">{{ $item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-1" id="tier_0">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Tier City</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                            <select class="form-select form-select-lg select2"  onchange="change_state_city(this)" id="tier">
                                <option value="">Select </option>
                                <option value="1">L1</option>
                                <option value="2">L2</option>
                                <option value="3">L3</option>
                                <option value="4">L4</option>
                                <option value="5">Other</option> <!-- Changed "other" to "Other" for consistency -->
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-2" id="city_0">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">City</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>
                            {{-- <select class="form-select form-select-lg select2" id="city_q">
                                <option value="">Select City</option> --}}
                            <select class="form-control select2 custom-select select2-hidden-accessible" name="shiftsetting[]" data-placeholder="Choose Shift Policy" multiple="" required="" tabindex="-1" aria-hidden="true" id="city">
                                <option label="Choose Shift Policy"></option>
                                <option value=""> Select</option>
                                {{-- @foreach ($city_list as $item)
                                <option value="<?php $item->id ?>">{{ $item->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-1 p-0">
                            <div class="col-md-1"><button class="btn btn-danger" type="button" id="removeButton_' + cloneCount + '" onclick="deleteRow_first(this)" style="margin-top: 30px;" >X</button></div>
                    </div>
                </div>
                <div id="add_row"></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom-0">
            <div class="card-title">Dual List Box</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-none border">
                        <div class="card-body">
                            <div class="transfer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom-0">
            <div class="card-title">Select Box</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="from-group mb-5 mb-lg-0">
                        <select multiple="multiple" name="favorite_fruits" id="fruit_select">
                            <option selected="selected" disabled="disabled">HTML5</option>
                            <option>CSS3</option>
                            <option>PHP</option>
                            <option>Jquery</option>
                            <option>.Net</option>
                            <option>Java</option>
                            <option>Android</option>
                            <option>AngularJS</option>
                            <option>Photoshop</option>
                            <option>Python</option>
                            <option>SQL</option>
                            <option>Java Script</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="from-group">
                        <select multiple="multiple" name="favorite_fruits" id="fruit_select1">
                            <optgroup label="Software Side">
                                <option>Web designer</option>
                                <option>Web Developer</option>
                                <option>Application Developer</option>
                                <option>App Designer</option>
                            </optgroup>
                            <optgroup label="Voice Side">
                                <option>Tell Caller</option>
                                <option>Recruiter</option>
                                <option>HR</option>
                                <option>Data Entry</option>
                                <option>Mapping</option>
                                <option>US Recruiter</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/apexcharts.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<script>

</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example-dropUp').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: true
        });
    });
</script>

{{-- testing` --}}


<script>
    function hide_data(value) {
    // Your logic for hiding data goes here
    console.log('Hiding data for value: ' + value);

    }
    var no = 1;
    function array_data(value) {
    var cloneCount = $('.row').length + 1; // Assuming cloneCount is the count of existing rows
    no++;
    $('#add_row').append(
    '<div class="row p-0 m-0" id=remove_'+no+'>' +
    '<div class="col-xl-1 p-0">' +
    '<div class="form-group select2-lg">'+
        // '<label for="field-3" class="form-label"><span style="font-size:15px;">Grade</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>'+
        '<select class="form-select form-select-lg select2" id="grade">'+
            '<option value="">Select</option>'+
            // '@foreach ($grade_list as $item)'+
            // '<option value="<?php $item->id ?>">{{ $item->grade_name}}</option>'+
            // '@endforeach'+
        '</select>'+
    '</div>'+
    '</div>' +
    '<div class="col-xl-2">' +
    '<div class="form-group select2-lg">' +
        '<select class="form-select form-select-lg select2" id="inputGroupSelect012">' +
        '<option value="1">One</option>' +
        '<option value="2">Two</option>' +
        '<option value="3">Three</option>' +
        '</select>' +
    '</div>' +
    '</div>' +
    '<div class="col-xl-2">' +
    '<div class="form-group select2-lg">' +
        '<select class="form-select form-select-lg select2" id="inputGroupSelect012">' +
        '<option value="1">One</option>' +
        '<option value="2">Two</option>' +
        '<option value="3">Three</option>' +
        '</select>' +
    '</div>' +
    '</div>' +
    '<div class="col-xl-1">' +
    '<div class="form-group select2-lg">'+
                    // '<label for="field-3" class="form-label"><span style="font-size:15px;">Limit</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>'+
                    '<select class="form-select form-select-lg select2" id="limit" onchange="limit_amount(this)">'+
                        '<option value="">Select </option>'+
                        '<option value="1">Set Limit</option>'+
                        '<option value="2">Amount</option>'+
                    '</select>'+
                '</div>'+
    '</div>' +
    '<div class="col-xl-1">'+
    '<div class="form-group select2-lg">'+
        // '<label for="field-3" class="form-label"><span style="font-size:15px;">Amount</span><span style="color:red">*</span><span style="font-size:14px; color:black"> :</span></label>'+
        '<input class="form-control form-control-lg" placeholder="Amount" type="text" id="amount">'+
    '</div>'+
    '</div>'+
    '<div class="col-xl-2">' +
    '<div class="form-group select2-lg">' +
        '<select class="form-select form-select-lg select2" id="inputGroupSelect012">' +
        '<option value="1">One</option>' +
        '<option value="2">Two</option>' +
        '<option value="3">Three</option>' +
        '</select>' +
    '</div>' +
    '</div>' +
    '<div class="col-xl-2">' +
    '<div class="form-group select2-lg">' +
        '<select class="form-select form-select-lg select2" id="inputGroupSelect012">' +
        '<option value="1">One</option>' +
        '<option value="2">Two</option>' +
        '<option value="3">Three</option>' +
        '</select>' +
    '</div>' +
    '</div>' +
    '<div class="col-xl-1 p-0">' +
        '<div class="col-md-1"><button class="btn btn-danger" type="button" id="removeButton_' + no + '" onclick="deleteRow(this)"  >X</button></div>' +
    '</div>' +
    '</div>'
    );

    }

    function deleteRow(button) {
    console.log(button.id);
    let removeId = button.id.replace('removeButton_', ''); // Extract numeric part from the button's id
    $('#remove_'+removeId).remove();
    }
    function deleteRow_first(button) {
    let removeId = button.id.replace('removeButton_', ''); // Extract numeric part from the button's id
    console.log('remove_'+removeId);
    $('#remove_'+removeId).remove();
    // document.getElementById()
    }

    function travel_select(val) {
    let travel = val.value;
    console.log('travel',travel);

    if (travel == 1) {
        console.log(document.getElementById('tier'));

    document.getElementById('state_0').style.display = 'none';
    document.getElementById('city_0').style.display = 'none';
    document.getElementById('tier_0').style.display = 'none';
    document.getElementById('city').disabled = true;
    document.getElementById('state').disabled = true;
    document.getElementById('tier').disabled = true;
    document.getElementById('country').disabled = false;
    document.getElementById('country_0').style.display ='block';
    }else if (travel == 2) {
    document.getElementById('state_0').style.display = 'block';
    document.getElementById('city_0').style.display = 'block';
    document.getElementById('tier_0').style.display = 'block';
    document.getElementById('state').disabled = false;
    document.getElementById('city').disabled = false;
    document.getElementById('country_0').style.display = 'none';
    document.getElementById('country').disabled = true;
    } else if (travel == 3) {
    document.getElementById('state_0').style.display = 'none';
    document.getElementById('state').disabled = true;
    document.getElementById('tier_0').style.display = 'none';
    document.getElementById('country').disabled = true;
    document.getElementById('country_0').style.display = 'none';
    document.getElementById('city_0').style.display = 'block';
    document.getElementById('city').disabled = false;
    }
    // else{

    //     document.getElementById('state_0').style.display = 'none';
    //     document.getElementById('city_0').style.display = 'none';
    //     document.getElementById('state').disabled = false;
    //     document.getElementById('city').disabled = false;
    // }
    }
    function limit_amount(val){
        let limit_amount = val.value;
        console.log('limit_amount',limit_amount);

        if (limit_amount == 1) {
        document.getElementById('amount').disabled = false;
        }else if (limit_amount == 2) {
        document.getElementById('amount').disabled = true;
        }
    }


    function change_state(val) {   // state wise  city
        let state_id = val.value;
        console.log('state_id', state_id);
        $.ajax({
            url: "{{url('admin/settings/tada/getCity')}}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "state_id": state_id
            },
            success: function (response) {
                // console.log(response);
                console.log('Response:', response.city); // Log the entire response object
                var selOpts1 = "<option value='' readonly>Select Model</option>";
                if (Array.isArray(response.city)) {
                    response.city.forEach(function (data) {
                        console.log('data:', data); // Log each individual data object to inspect its structure
                        // if (data && data.name) {
                            selOpts1 += "<option value='" + data.id + "'>" + data.name + "</option>";
                        // }
                    });
                } else {
                    // Handle non-array response here, if needed
                }
                console.log('selOpts1',selOpts1);
                document.getElementById('city_').innerHTML = selOpts1;
            },
            error: function(xhr, status, error) {
                console.error("Error:", error); // Log any errors that occur during the AJAX request
            }
        });
    }
    function change_state_city(val) {   // tier wise city
        document.getElementById('city_q').innerHTML = '';
        let state_id = val.value;
        let tiar_city = 'tier_city';
        console.log('state_id', state_id);
        $.ajax({
            url: "{{url('admin/settings/tada/getCity')}}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "state_id": state_id,
                "data" : tiar_city
            },
            success: function (response) {
                // console.log(response);
                console.log('Response:', response.city); // Log the entire response object
                var selOpts1 = "<option value='' readonly>Select Model</option>";
                if (Array.isArray(response.city)) {
                    response.city.forEach(function (data) {
                        console.log('data:', data); // Log each individual data object to inspect its structure
                        // if (data && data.name) {
                            selOpts1 += "<option value='" + data.id + "'>" + data.name + "</option>";
                        // }
                    });
                } else {
                    // Handle non-array response here, if needed
                }
                console.log('selOpts1',selOpts1);
                document.getElementById('city').innerHTML = selOpts1;
            },
            error: function(xhr, status, error) {
                console.error("Error:", error); // Log any errors that occur during the AJAX request
            }
        });
    }

//     function change_state_city(selectElement) {
//     // Your logic here
//     console.log("Selected value:", selectElement.value);
//     // You can add your logic to handle the selected value
// }


</script>
@endsection
