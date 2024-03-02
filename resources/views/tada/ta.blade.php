@extends('admin.pagelayout.master2')
@section('title')
    Business
@endsection
@section('css')
@endsection
@section('content')
{{-- <div class="card" >
    <div class="card-header border-bottom-0">
        <div class="card-title">Select All Styles</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group row">
                    <label class="col-md-12 form-label">Single Select:</label>
                    <div class="col-md-12">
                        <select name="somename" class="form-control SlectBox" onclick="console.log($(this).val())"
                            onchange="console.log('change is firing')">
                            <!--placeholder-->
                            <option title="Volvo is a car" value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 form-label">Disabled Select:</label>
                    <div class="col-md-12">
                        <select class="SlectBox form-control box-shadow-0" disabled>
                            <option value="volvo">Volvo</option>
                            <option selected value="saab">Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option disabled value="opt1">option1</option>
                            <option value="opt2">option2</option>
                            <option value="opt3">option3</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 form-label">Inline Select:</label>
                    <div class="col-md-12">
                        <select class="SlectBox form-control">
                            <option>selected</option>
                            <option>Volvo</option>
                            <option>Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option>Volvo</option>
                            <option>Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option>Volvo</option>
                            <option>Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option>Volvo</option>
                            <option>Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group row">
                    <label class="col-md-12 form-label">Multiple Select:</label>
                    <div class="col-md-12">
                        <select multiple="multiple" class="testselect2">
                            <option selected value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 form-label">Disabled Select:</label>
                    <div class="col-md-12">
                        <select multiple="multiple" class="testselect2 " disabled>
                            <option selected value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option disabled="disabled" value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option value="bmw">BMW</option>
                            <option value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option class="someclass" value="audi">Audi</option>
                            <option class="someclass" value="bmw">BMW</option>
                            <option class="someclass" value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option value="audi">Audi</option>
                            <option value="bmw">BMW</option>
                            <option value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option value="hyundai">Hyundai</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 form-label">Optgroup Support:</label>
                    <div class="col-md-12">
                        <select multiple="multiple" class="testselect2">
                            <option selected value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option disabled="disabled" value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option value="bmw">BMW</option>
                            <option value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option class="someclass" value="audi">Audi</option>
                            <option class="someclass" value="bmw">BMW</option>
                            <option class="someclass" value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option value="audi">Audi</option>
                            <option value="bmw">BMW</option>
                            <option value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option value="hyundai">Hyundai</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group row">
                    <label class="col-md-12 form-label">Multiple Select-1:</label>
                    <div class="col-md-12">
                        <select multiple="multiple" onchange="console.log($(this).children(':selected').length)"
                            class="select1">
                            <option selected value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option disabled="disabled" value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option selected value="bmw">BMW</option>
                            <option value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-md-12 form-label">Multiple Select-2:</label>
                    <div class="col-md-12">
                        <select multiple="multiple" onchange="console.log($(this).children(':selected').length)"
                            class="select3">
                            <option selected value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option disabled="disabled" value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option selected value="bmw">BMW</option>
                            <option value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 form-label">Search Select-1:</label>
                    <div class="col-md-12">
                        <select class="search_test">
                            <option class="hemant" selected value="saab">Saab</option>
                            <option class="hemant" value="opel">Opel</option>
                            <option disabled="disabled" value="mercedez">Mercedez</option>
                            <optgroup label="US Brands">
                                <option value="chrysler">Chrysler</option>
                                <option value="gm">General Motors</option>
                                <option value="ford">Ford</option>
                                <option disabled="disabled" value="plymouth">Plymouth
                                </option>
                            </optgroup>
                            <optgroup label="French Brands">
                                <option value="citroen">Citroën</option>
                                <option value="peugeot">Peugeot</option>
                                <option value="renault">Renault</option>
                                <option value="nissan">Nissan</option>
                            </optgroup>
                            <optgroup label="Italian brands">
                                <option value="fiat">Fiat</option>
                                <option value="alpha-Romeo">Alpha Romeo</option>
                                <option value="lamborghini">Lamborghini</option>
                            </optgroup>
                            <optgroup disabled="disabled" label="German brands">
                                <option value="audi">Audi</option>
                                <option value="bMW">BMW</option>
                                <option value="volkswagen">Volkswagen</option>
                            </optgroup>
                            <option value="aston-martin">Aston Martin</option>
                            <option value="hyundai">Hyundai</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group row">
                    <label class="col-md-12 form-label">Search Select-2:</label>
                    <div class="col-md-12">
                        <select class="search-box">
                            <option class="hemant" selected value="saab">Saab</option>
                            <option class="hemant" value="opel">Opel</option>
                            <option disabled="disabled" value="mercedez">Mercedez</option>
                            <option value="aston-martin">Aston Martin</option>
                            <option value="hyundai">Hyundai</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 form-label">Search Select-3:</label>
                    <div class="col-md-12">
                        <select multiple="multiple" onchange="console.log($(this).children(':selected').length)"
                            class="search-box">
                            <option selected value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option disabled="disabled" value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                            <option selected value="bmw">BMW</option>
                            <option value="porsche">Porche</option>
                            <option value="ferrari">Ferrari</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 form-label">Search Select-4:</label>
                    <div class="col-md-12">
                        <select multiple="multiple" class="SlectBox-grp-src">

                            <option selected value="saab">Saab</option>
                            <option value="opel">Opel</option>
                            <option disabled="disabled" value="mercedez">Mercedez</option>
                            <optgroup label="US Brands">
                                <option value="chrysler">Chrysler</option>
                                <option value="gm">General Motors</option>
                                <option value="ford">Ford</option>
                                <option disabled="disabled" value="plymouth">Plymouth
                                </option>
                            </optgroup>
                            <optgroup label="French Brands">
                                <option value="citroen">Citroën</option>
                                <option value="peugeot">Peugeot</option>
                                <option selected value="renault">Renault</option>
                                <option value="nissan">Nissan</option>
                            </optgroup>
                            <optgroup label="Italian brands">
                                <option value="fiat">Fiat</option>
                                <option value="alpha-Romeo">Alpha Romeo</option>
                                <option value="lamborghini">Lamborghini</option>
                            </optgroup>
                            <optgroup disabled="disabled" label="German brands">
                                <option value="audi">Audi</option>
                                <option value="bMW">BMW</option>
                                <option value="volkswagen">Volkswagen</option>
                            </optgroup>
                            <option value="aston-martin">Aston Martin</option>
                            <option value="hyundai">Hyundai</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">TA</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary d-flex justify-content-end" value="1" type="button"
                            id="addButton" onclick="hide_data(this.value);array_data(this.value);"
                            style="height: 50px; display: flex; align-items: center; justify-content: center;">
                            +Add
                        </button>
                        <input type="hidden" value="1" id="delete_id">
                    </div>
                </div>
                <div class="row p-0 m-0">
                    {{-- <div class="col-xl-1 p-0">
                        <table id="table_no">
                            <th>
                                <tr>S.No.</tr>
                            </th>
                            <tbody class="mt-4">
                                <tr class="mt-4">
                                    <td id="s_no">1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}
                    <div class="col-xl-2">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Grade</span><span
                                    style="color:red">*</span><span style="font-size:14px; color:black">
                                    :</span></label>
                            <select class="form-select form-select-lg select2" id="inputGroupSelect012">
                                <option value="">Select</option>
                                {{-- @foreach ($grade_list as $item)
                                <option value="<?php $item->id ?>">{{ $item->grade_name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Travel
                                    Type</span><span style="color:red">*</span><span
                                    style="font-size:14px; color:black"> :</span></label>
                            <select class="form-select form-select-lg select2" id="travel"
                                onchange="travel_select(this)">
                                <option value="">Select Travel Type</option>
                                <option value="1">International</option>
                                <option value="2">National</option>
                                <option value="3">Local</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-2" id="limot_0">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Limit</span><span
                                    style="color:red">*</span><span style="font-size:14px; color:black">
                                    :</span></label>
                            <select class="form-select form-select-lg select2" id="limit" onchange="limit_amount(this)">
                                <option value="">Select </option>
                                <option value="1">Set Limit</option>
                                <option value="2">Amount</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Amount</span><span
                                    style="color:red">*</span><span style="font-size:14px; color:black">
                                    :</span></label>
                            <input class="form-control form-control-lg" placeholder="Amount" type="text">
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">Contry</span><span
                                    style="color:red">*</span><span style="font-size:14px; color:black">
                                    :</span></label>
                            <select class="form-select form-select-lg select2" id="inputGroupSelect012">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="form-group select2-lg">
                            <label for="field-3" class="form-label"><span style="font-size:15px;">State</span><span
                                    style="color:red">*</span><span style="font-size:14px; color:black">
                                    :</span></label>
                            <select class="form-select form-select-lg select2" id="inputGroupSelect012">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-1 p-0">
                        <div class="col-md-1"><button class="btn btn-danger" type="button"
                                id="removeButton_' + cloneCount + '" onclick="deleteRow(this)"
                                style="margin-top: 30px;">X</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
