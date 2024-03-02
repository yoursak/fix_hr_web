@extends('admin.pagelayout.master')
@section('title')
Travel Mode
@endsection
@section('css')
@endsection
@section('content')
<div class=" p-0 pt-2">
    <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
        <li><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/settings/tadasettings') }}">Travel & Daily Allowance Settings</a></li>
        <li class="active"><span><b>Travel Mode</b></span></li>
    </ol>
</div>
<div class="page-header d-md-flex d-block">
    <div class="page-leftheader">
        <div class="page-title">Travel Mode</div>
        <p class="text-muted">Create and activate your Mode of Travel</p>
    </div>
</div>
<form action="{{ route('admin.travelmode') }}" method="POST">
    @csrf
    @php

    @endphp
    <div class="row row-sm " id="AllContent">
        <div class="col-12" id="LateAllContet">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a class="font-weight-semibold fs-18 ms-3">By Air</a>
                            </div>
                            <div class="d-flex">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" name="byAir" id="byAirId" class="custom-switch-input" {{ isset($DATA->by_air_togglebtn) && $DATA->by_air_togglebtn == 1 ? 'checked' : '' }} onchange="document.getElementById('byAirContent').hidden = !this.checked">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You Can Define Rule for By Air</p>
                        <div class="my-3" id="byAirContent" {{ isset($DATA->by_air_togglebtn) && $DATA->by_air_togglebtn == 1 ? '' : 'hidden' }}>
                            <div class="d-flex my-1">
                                <div class="col-8">
                                    @foreach ($byAirStaticData as $item)
                                    @php
                                    // dd($item->id, json_decode($DATA->by_air_items))
                                    @endphp
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="byAirItems[]" id="byAirItemsID{{ $item->id }}" value="{{ $item->id }}" {{ !is_null($DATA) && !is_null($DATA->by_air_items) && in_array($item->id, (array) json_decode($DATA->by_air_items)) ? 'checked' : '' }}>
                                        <span class="custom-control-label"></span>
                                        <label class="form-label mx-1">{{ $item->name }}</label>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12" id="LateAllContet">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a class="font-weight-semibold fs-18 ms-3">By Train</a>
                            </div>
                            <div class="d-flex">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" name="byTrain" id="byTrainId" class="custom-switch-input" {{ isset($DATA->by_train_togglebtn) && $DATA->by_train_togglebtn == 1 ? 'checked' : '' }} onchange="document.getElementById('byTrainContent').hidden = !this.checked">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You Can Define Rule for By Train</p>
                        <div class="my-3" id="byTrainContent" {{ isset($DATA->by_train_togglebtn) && $DATA->by_train_togglebtn == 1 ? '' : 'hidden' }}>
                            <div class="d-flex my-1">
                                <div class="col-8">
                                    @foreach ($byTrainStaticData as $item)
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="byTrainItems[]" id="byTrainItmesID{{ $item->id }}" value="{{ $item->id }}" {{ !is_null($DATA) && !is_null($DATA->by_train_items) && in_array($item->id, (array) json_decode($DATA->by_train_items)) ? 'checked' : '' }}>
                                        <span class="custom-control-label"></span>
                                        <label class="form-label mx-1">{{ $item->name }}</label>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12" id="LateAllContet">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="my-auto">
                                <a class="font-weight-semibold fs-18 ms-3">By Road</a>
                            </div>
                            <div class="d-flex">
                                <label class="custom-switch ms-auto">
                                    <input type="checkbox" name="byRoad" id="byRoadId" class="custom-switch-input" {{ isset($DATA->by_road_togglebtn) && $DATA->by_road_togglebtn == 1 ? 'checked' : '' }} onchange="document.getElementById('byRoadContent').hidden = !this.checked">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <p class="mb-0 pb-0 text-muted fs-12 ms-3 mt-1">You Can Define Rule for By Road</p>
                        <div class="my-3" id="byRoadContent" {{ isset($DATA->by_road_togglebtn) && $DATA->by_road_togglebtn == 1 ? '' : 'hidden' }}>
                            <div class="d-flex my-1">
                                <div class="col-xl-6">
                                    @php
                                    $easy = 0;
                                    @endphp
                                    @foreach ($byRoadStaticData as $key => $item)
                                    <div class="d-flex">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="byRoadItems[]" id="byRoadItemsID{{ $item->id }}" value="{{ $item->id }}" {{ !is_null($DATA) && !is_null($DATA->by_road_items) && in_array($item->id, (array) json_decode($DATA->by_road_items)) ? 'checked' : '' }} onchange="toggleCategorySelectBox({{ $item->id }}, this)">
                                            <span class="custom-control-label"></span>
                                            <label class="form-label mx-1">{{ $item->name }}</label>
                                        </label>
                                        <div class="ms-auto d-flex">
                                            @if ($key < count($byRoadStaticData) - 1) @foreach ($travelModeCategoryStatic as $key1=> $category)
                                                @php
                                                // $hiddenCategoryValue = isset($DATA) && isset($DATA->by_road_items_category) ? json_decode($DATA->by_road_items_category)[$key * count($travelModeCategoryStatic) + $key1] : 0 ;

                                                $hiddenCategoryValue = isset($DATA) && isset($DATA->by_road_items_category) ? json_decode($DATA->by_road_items_category)[$key * count($travelModeCategoryStatic) + $key1] : 0;
                                                @endphp
                                                <label class="custom-control custom-checkbox categorySelectBox{{ $item->id }}" style="display: {{ !is_null($DATA) && !is_null($DATA->by_road_items) && in_array($item->id, (array) json_decode($DATA->by_road_items)) ? 'block' : 'none' }};">
                                                    <input type="hidden" name="hiddenCategory[]" value="{{ $hiddenCategoryValue }}">
                                                    <input type="checkbox" class="custom-control-input" name="byRoadCategories{{ $item->id }}[]" id="byRoadCategoriesID{{ $category->id }}" value="{{ $hiddenCategoryValue }}" {{ $hiddenCategoryValue == 1 ? 'checked' : '' }} onchange="updateHiddenValue(this)">
                                                    <span class="custom-control-label"></span>
                                                    <label class="form-label mx-1">{{ $category->name }}</label>
                                                </label>
                                                <script>
                                                    function updateHiddenValue(checkbox) {
                                                        var hiddenInput = checkbox.parentNode.querySelector('input[type="hidden"]');
                                                        hiddenInput.value = checkbox.checked ? '1' : '0';
                                                    }
                                                </script>
                                                <span>&nbsp; &nbsp;&nbsp;</span>
                                                @endforeach
                                                @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            // Execute toggleCategorySelectBox for each checked checkbox during page load
                                            document.querySelectorAll('input[name="byRoadItems[]"]:checked').forEach(function(checkbox) {
                                                toggleCategorySelectBox(checkbox.value);
                                            });
                                        });

                                        function toggleCategorySelectBox(itemId, checkbox) {
                                            var categorySelectBoxes = document.querySelectorAll('.categorySelectBox' + itemId);
                                            var displayValue = checkbox.checked ? 'block' : 'none';
                                            categorySelectBoxes.forEach(function(box) {
                                                box.style.display = displayValue;
                                                // If checkbox is unchecked, set value of child checkboxes to 0
                                                if (!checkbox.checked) {
                                                    var childCheckboxes = box.querySelectorAll('input[type="checkbox"]');
                                                    childCheckboxes.forEach(function(childCheckbox) {
                                                        childCheckbox.value = 0;
                                                        childCheckbox.checked = false;
                                                        var hiddenInput = childCheckbox.parentNode.querySelector('input[type="hidden"]');
                                                        hiddenInput.value = '0';
                                                    });
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex float-right">
        <button type="submit" class="btn btn-primary" id="submit_form_btn">Save & Update</button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    document.getElementById('submit_form_btn').addEventListener('click', function(event) {
        var isCheckedByAir = document.getElementById('byAirId').checked;
        var isCheckedByTrain = document.getElementById('byTrainId').checked;
        var isCheckedByRoad = document.getElementById('byRoadId').checked;

        if (!isCheckedByAir && !isCheckedByTrain && !isCheckedByRoad) {
            event.preventDefault(); // Prevent the default form submission
            Swal.fire({
                icon: 'info',
                text: 'Select at least one category to activate the travel mode by Air!',
            });
            return;
        }
        if (isCheckedByAir) {
            var checkboxes = document.querySelectorAll('input[name="byAirItems[]"]');
            var isAnyChecked = false;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    isAnyChecked = true;
                }
            });
            if (!isAnyChecked) {
                // No checkbox is checked, prevent form submission and show alert
                event.preventDefault(); // Prevent the default form submission
                Swal.fire({
                    icon: 'info',
                    text: 'Select at least one category to activate the travel mode by Air!',
                });
                return;
            }
        }
        if (isCheckedByTrain) {
            var checkboxes = document.querySelectorAll('input[name="byTrainItems[]"]');
            var isAnyChecked = false;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    isAnyChecked = true;
                }
            });
            if (!isAnyChecked) {
                // No checkbox is checked, prevent form submission and show alert
                event.preventDefault(); // Prevent the default form submission
                Swal.fire({
                    icon: 'info',
                    // title: 'Information',
                    text: 'Select at least one category to activate the travel mode by Train!',
                });
                return;

            }
        }
        if (isCheckedByRoad) {
            var checkboxes = document.querySelectorAll('input[name="byRoadItems[]"]');
            var isAnyChecked1 = false;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    isAnyChecked1 = true;

                    var isAnyCategoryChecked = false;
                    var subCheckboxes = document.querySelectorAll('input[name="byRoadCategories' +
                        checkbox.value + '[]"]');
                    subCheckboxes.forEach(function(subCheckbox) {
                        if (subCheckbox.checked) {
                            isAnyCategoryChecked = true;
                        }
                    });

                    if (!isAnyCategoryChecked) {
                        // No checkbox is checked, prevent form submission and show alert
                        event.preventDefault(); // Prevent the default form submission
                        Swal.fire({
                            icon: 'info',
                            text: 'Select at least one sub category for selected vehical type!',
                        });
                    }
                }
            });
            if (!isAnyChecked1) {
                // No checkbox is checked, prevent form submission and show alert
                event.preventDefault(); // Prevent the default form submission
                Swal.fire({
                    icon: 'info',
                    text: 'Select at least one category to activate the travel mode by Road!',
                });
            }
        }
    });
</script>
@endsection
