{{-- <?php dd('train_travelmode', $newdata_third, 'air_travelmode', $newdata_second, 'road_travelmode', $newdata_first); ?> --}}
{{-- <?php dd(count($air_travelmode)); ?> --}}
@extends('admin.setting.setting')
@section('subtitle')
    Business
@endsection
@section('settings')
    <style>

        .design {
            font-family: sans-serif, Roboto;
            font-size: 14px;
            font-weight: 300;
        }
        .font{
            font-size: 18px;
        }
    </style>
<div class=" p-0 pt-2">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/settings/tada') }}">Allowance Settings</a></li>
        <li class="active"><span><b>Travel Mode</b></span></li>
    </ol>
</div>
<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Travel Mode</div>
        <p class="text-muted">Create and activate your Mode of Travel</p>
    </div>
</div>
    <div>
        <form action="{{ url('admin/settings/tada/travel_country/save') }}" method="POST">
            @csrf
            <div class="container-fluid mx-0 px-0">
                <div class="row row-sm ">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 column air">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- <div class="column air"> --}}
                                                <div class="row d-flex justify-content-between align-items-center mb-3">
                                                    <div class="col-md-10 col-10">
                                                        <h2 class=""><span class="font" >By Air</span></h2>
                                                    </div>
                                                    <div class="col-md-2 col-2 text-md-right text-right">
                                                        <label>
                                                            <input type="checkbox" name="by_air_toget" value="1" onchange="toggle_mode('air')" id="lateEntryBtn_air" class="custom-switch-input">
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row d-flex justify-content-between align-items-center mb-3">
                                                    <div class="col-md-10 col-10">
                                                        <p class="design">Create your travel class</p>
                                                    </div>
                                                    <div class="col-md-2 col-2 text-md-right text-right">
                                                        <button type="button"  id="air_one" value="{{isset($air_travelmode) ? count($air_travelmode) : '' }}" disabled class="btn btn-primary" onclick="addInputAndDeleteButton('air')"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                @isset($newdata_first)
                                                    @foreach ($newdata_first as $index => $item)
                                                        <div class="row">
                                                            <div class="col-md-10 col-10">
                                                                <div class="mb-3">
                                                                    <input type="text" class="form-control custom-input" data_type="air" value="{{ $item->travel_type }}" required name="air_update[]" id="airContentInput{{$index}}" aria-describedby="basic-addon2" readonly>
                                                                    <input type="hidden" id="by_air_hidden" name="by_air_hidden[]" value="{{ $item->travel_id}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-2 text-md-right text-right">
                                                                <button class="btn btn-danger" type="button" data_button="air" onclick="deleteInputAndButton(this)" disabled><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endisset
                                                <input type="hidden" name="by_air_id" value="1">
                                                {{-- <input type="hidden" value="@isset($newdata_second){{ $newdata_second->travel_id }}  @endisset" name="travel_id"> --}}
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 column train ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row d-flex justify-content-between align-items-center mb-3">
                                                <div class="col-md-10 col-10 ">
                                                    <h2 class=""><span class="font">By Train</span></h2>
                                                </div>
                                                <div class="col-md-2 col-2 text-md-right text-right">
                                                    <label>
                                                        <input type="checkbox" name="by_train_toget" value="1" onchange="toggle_mode_train('train')" id="lateEntryBtn_train" class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between align-items-center mb-3">
                                        <div class="col-md-10 col-10">
                                            <p class="design">Create your travel class</p>
                                        </div>
                                        <div class="col-md-2 col-2 text-md-right text-right">
                                            <button type="button" class="btn btn-primary" id="train_one" value="{{isset($train_travelmode) ? count($train_travelmode) : '' }}" onclick="addInputAndDeleteButton('train')" disabled><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    @isset($newdata_second)
                                        @foreach ($newdata_second as $index => $item)
                                            <div class="row">
                                                <div class="col-md-10 col-10">
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control custom-input" data_type="train" id="trainContentInput{{$index}}" required value="{{ $item->travel_type }}" name="train_update[]" aria-describedby="basic-addon2" readonly>
                                                        <input type="hidden" id="by_train_hidden" name="by_train_hidden[]" value="{{ $item->travel_id}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-2 text-md-right text-right">
                                                    <button class="btn btn-danger" type="button" data_button="train" onclick="deleteInputAndButton(this)" disabled><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                    <input type="hidden" name="by_train_id" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                  <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 column road ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row d-flex justify-content-between align-items-center mb-3">
                                            <div class="col-md-10 col-10">
                                                <h2 class=""><span class="font">By Road</span></h2>
                                            </div>
                                            <div class="col-md-2 col-2 text-md-right text-right">
                                                <label>
                                                    <input type="checkbox" name="by_road_toget" value="1" onchange="toggle_mode_road('road')" id="lateEntryBtn_road" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-between align-items-center mb-3">
                                    <div class="col-md-10 col-10">
                                        <p class="design">Create your vehicle type</p>
                                    </div>
                                    <div class="col-md-2 col-2 text-md-right text-right">
                                        <button type="button" id="by_road_active" class="btn btn-primary" value="{{isset($road_travelmode) ? count($road_travelmode) : '' }}" onclick="addInputAndDeleteButton('road')" disabled><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                @isset($newdata_third)
                                    @foreach ($newdata_third as $index => $item)
                                        <div class="row">
                                            <div class="col-md-10 col-10">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control custom-input" data_type="road" id="roadContentInput{{$index}}" value="{{ $item->travel_type }}" readonly required name="road_update[]" aria-describedby="basic-addon2">
                                                    <input type="hidden" id="by_road_hidden" name="by_road_hidden[]" value="{{$item->travel_id}}">
                                                </div>

                                            </div>
                                            <div class="col-md-2 col-2 text-md-right text-right">
                                                <button class="btn btn-danger" type="button" data_button="road" onclick="deleteInputAndButton(this)" disabled><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endisset
                                <input type="hidden" name="by_rode_id" value="3">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                        {{-- <button class="btn btn-secondary">Reset</button> --}}
                        <button type="submit" class="btn btn-primary btn-custom ">Save & apply</button>
                </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const counters = {};

        function addInputAndDeleteButton(section) {
            console.log('section',section);
            if (!counters[section]) {
                counters[section] = 2;
            } else {
                counters[section]++;
            }
        const inputField = '<div class="col-md-10 col-10 mb-3 design">' +
            '<input type="text" class="form-control" data_type="' + section + '" name="' + section + '[]" id="' + section + 'ContentInput' + counters[section] + '" required autofocus></div>';
        // Create delete button
        const deleteButton =
                '<div class="col-md-2 col-2"><button class="btn btn-danger" data_button="' + section + '" onclick="deleteInputAndButton(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></div>';
            $('.' + section).append('<div class="row">' + inputField + deleteButton + '</div>');
                    }
            function deleteInputAndButton(button) {
                $(button).parent().parent().remove();
            }
        function toggle_mode(section){    // all toggle i air Enable and Disabel
            let data_toggol = document.getElementById('lateEntryBtn_air').value;
            if(document.getElementById('lateEntryBtn_air').checked == true ){
                if(data_toggol == 1){
                    if (!counters[section]) {
                        counters[section] = 2;
                    } else {
                        counters[section]++;
                    }
                    // const inputField = '<div class="col-8 mb-3 design">' +
                    //         '<input type="text" class="form-control" data_type="'+section+'" name="' + section + '[]" id="' + section + 'ContentInput' + counters[section] + '" required></div>';
                    // // Create delete button
                    // const deleteButton =
                    //     '<div class="col-4"><button class="btn btn-danger" data_button="'+section+'" onclick="deleteInputAndButton(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></div>';

                    // $('.' + section).append('<div class="row">' + inputField + deleteButton + '</div>');
                    const inputField = '<div class="col-md-10 col-10 mb-3 design">' +
                                        '<input type="text" class="form-control" data_type="' + section + '" name="' + section + '[]" id="' + section + 'ContentInput' + counters[section] + '" required autofocus></div>';
        // Create delete button
                const deleteButton =
                    '<div class="col-md-2 col-2"><button class="btn btn-danger" data_button="' + section + '" onclick="deleteInputAndButton(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></div>';
                    $('.' + section).append('<div class="row">' + inputField + deleteButton + '</div>');
                }
                var inputs = document.querySelectorAll('[data_type="air"]');
                var data_button = document.querySelectorAll('[data_button="air"]');
                inputs.forEach(function(input) {
                    input.readOnly  = false;
                });
                data_button.forEach(function(input) {
                    input.disabled  = false;
                });
                document.getElementById('air_one').disabled = false;
                document.getElementById('lateEntryBtn_air').value = 0;
            }else{
                document.getElementById('air_one').disabled = true;
                var inputs = document.querySelectorAll('[data_type="air"]');
                var data_button = document.querySelectorAll('[data_button="air"]');
                inputs.forEach(function(input) {
                    input.readOnly  = true;
                });
                data_button.forEach(function(input) {
                    input.disabled  = true;
                });
            }
        }
        function toggle_mode_train(section){    // Train toggle i air Enable and Disabel
            console.log(section);
            console.log('new data', document.getElementById('lateEntryBtn_train').checked);
            let data_toggol = document.getElementById('lateEntryBtn_train').value;
            if(document.getElementById('lateEntryBtn_train').checked == true ){
                console.log('aaya data',document.getElementById('train_one').value);
                if(data_toggol == 1){
                    if (!counters[section]) {
                        counters[section] = 2;
                    } else {
                        counters[section]++;
                    }
                    // const inputField = '<div class="col-8 mb-3 design">' +
                    //         '<input type="text" class="form-control" data_type="'+section+'" name="' + section + '[]" id="' + section + 'ContentInput' + counters[section] + '"></div>';
                    // // Create delete button
                    // const deleteButton =
                    //     '<div class="col-4"><button class="btn btn-danger" data_button="'+section+'" onclick="deleteInputAndButton(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></div>';

                    // $('.' + section).append('<div class="row">' + inputField + deleteButton + '</div>');
                    const inputField = '<div class="col-md-10 col-10 mb-3 design">' +
                            '<input type="text" class="form-control" data_type="' + section + '" name="' + section + '[]" id="' + section + 'ContentInput' + counters[section] + '" autofocus></div>';

        // Create delete button
                    const deleteButton =
                            '<div class="col-md-2 col-2"><button class="btn btn-danger" data_button="' + section + '" onclick="deleteInputAndButton(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></div>';
                            $('.' + section).append('<div class="row">' + inputField + deleteButton + '</div>');

                }
                var inputs = document.querySelectorAll('[data_type="train"]');
                inputs.forEach(function(input) {
                    input.readOnly  = false;
                });
                var data_button = document.querySelectorAll('[data_button="train"]');
                data_button.forEach(function(input) {
                    input.disabled  = false;
                });
                document.getElementById('train_one').disabled = false;
                document.getElementById('lateEntryBtn_train').value = 0;
            }else{
                document.getElementById('train_one').disabled = true;
                var inputs = document.querySelectorAll('[data_type="train"]');
                inputs.forEach(function(input) {
                    input.readOnly  = true;
                });
                var data_button = document.querySelectorAll('[data_button="train"]');
                data_button.forEach(function(input) {
                    input.disabled  = true;
                });
            }
        }
        function toggle_mode_road(section){    // Train toggle i air Enable and Disabel
            console.log(section);
            console.log('new data', document.getElementById('lateEntryBtn_road').checked);
            let data_toggol = document.getElementById('lateEntryBtn_road').value;
            if(document.getElementById('lateEntryBtn_road').checked == true ){
                console.log('aaya data',document.getElementById('train_one').value);
                if(data_toggol == 1){
                    if (!counters[section]) {
                        counters[section] = 2;
                    } else {
                        counters[section]++;
                    }
                    // const inputField = '<div class="col-8 mb-3 design">' +
                    //         '<input type="text" class="form-control" data_type="'+section+'" name="' + section + '[]" id="' + section + 'ContentInput' + counters[section] + '"></div>';
                    // // Create delete button
                    // const deleteButton =
                    //     '<div class="col-4"><button class="btn btn-danger" data_button="'+section+'" onclick="deleteInputAndButton(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></div>';

                    // $('.' + section).append('<div class="row">' + inputField + deleteButton + '</div>');
                    const inputField = '<div class="col-md-10 col-10 mb-3 design">' +
                    '<input type="text" class="form-control" data_type="' + section + '" name="' + section + '[]" id="' + section + 'ContentInput' + counters[section] + '" autofocus></div>';

                // Create delete button
                const deleteButton =
                    '<div class="col-md-2 col-2"><button class="btn btn-danger" data_button="' + section + '" onclick="deleteInputAndButton(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></div>';

                $('.' + section).append('<div class="row">' + inputField + deleteButton + '</div>');

                }
                var inputs = document.querySelectorAll('[data_type="road"]');
                inputs.forEach(function(input) {
                    input.readOnly  = false;
                });
                var data_button = document.querySelectorAll('[data_button="road"]');
                data_button.forEach(function(input) {
                    input.disabled  = false;
                });
                document.getElementById('by_road_active').disabled = false;
                document.getElementById('lateEntryBtn_road').value = 0;
            }else{
                document.getElementById('by_road_active').disabled = true;
                var inputs = document.querySelectorAll('[data_type="road"]');
                inputs.forEach(function(input) {
                    input.readOnly  = true;
                });
                var data_button = document.querySelectorAll('[data_button="road"]');
                data_button.forEach(function(input) {
                    input.disabled  = true;
                });
            }
        }
    </script>

@endsection
