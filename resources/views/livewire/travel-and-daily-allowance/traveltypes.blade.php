<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <h1>Hello</h1>
    <div class="p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/tadasettings') }}">Travel & Daily Allowance Settings</a></li>
            <li class="active"><span><b>Travel Type</b></span></li>
        </ol>
    </div>
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Travel Type</div>
            <p class="text-muted">Create and activate your Type of Travel</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex px-0">
            <div class="col">
                <h4 class="card-title"><span>Create Travel Type</span></h4>
            </div>
        </div>
        <form action="{{ route('admin.traveallowancetada') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="col d-flex international p-0">
                    <h5 class="card-title mb-4"><span>International</span></h5>
                    <div class="ms-auto">
                        <label class="custom-switch d-inline-block align-middle">
                            <input id="internationalCheckID" type="checkbox" name="custom_switch_checkbox_international" class="custom-switch-input" {{ $MainData != null ? ($MainData->international_id == 1 ? 'checked' : '') : '' }} onchange="toggleInternational(this)">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                </div>
                <div class="col d-flex international p-0">
                    <p class="text-muted">Create your category for international travel</p>
                    <div class="ms-auto">
                        <button type="button" style="display: {{ $MainData != null && $MainData->international_id == 1 ? 'inline' : 'none' }}" class="btn btn-sm btn-primary add_item_btn_international"><i class="fe fe-plus bold"></i></button>
                    </div>
                </div>

                <span id="internationalAllowances"></span>
            </div>
            <div class="card-body">
                <div class="col d-flex natioanal p-0">
                    <h5 class="card-title mb-4"><span>Outstation </span></h5>
                    <div class="ms-auto">
                        <label class="custom-switch d-inline-block align-middle">
                            <input id="outstationCheckId" type="checkbox" name="custom_switch_checkbox_national" class="custom-switch-input" {{ $MainData != null ? ($MainData->national_id == 1 ? 'checked' : '') : '' }} onchange="toggleNational(this)">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                </div>
                <div class="col d-flex international p-0">
                    <p class="text-muted">Create your category for outstation travel</p>
                    <div class="ms-auto">
                        <button type="button" style="display: {{ $MainData != null && $MainData->national_id == 1 ? 'inline' : 'none' }}" class="btn btn-sm btn-primary add_item_btn_national"><i class="fe fe-plus bold"></i></button>
                    </div>
                </div>
                <span id="nationalAllowances"></span>

            </div>
            <div class="card-body">
                <div class="col d-flex local p-0">
                    <h5 class="card-title mb-4"><span>Local</span></h5>
                    <div class="ms-auto">
                        <label class="custom-switch d-inline-block align-middle">
                            <input id="localCheckId" type="checkbox" name="custom_switch_checkbox_local" class="custom-switch-input" {{ isset($MainData) && $MainData->local_id == 1 ? 'checked' : '' }} onchange="toggleLocal(this)">
                            <span class="custom-switch-indicator"></span>
                        </label>

                    </div>
                </div>

                <div class="col d-flex local p-0">
                    <p class="text-muted">Create your category for local travel</p>
                    <div class="ms-auto">
                        <button type="button" style="display: {{ $MainData != null && $MainData->local_id == 1 ? 'inline' : 'none' }}" class="btn btn-sm btn-primary add_item_btn_local"><i class="fe fe-plus bold"></i></button>
                    </div>
                </div>
                <span id="localAllowances"></span>
                <div class="d-flex float-right">
                    <button type="sumbit" class="btn btn-primary" id="submit_form_btn">Save</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.getElementById('submit_form_btn').addEventListener('click', function(event) {
            var internationalCheckID = document.getElementById('internationalCheckID').checked;
            var outstationCheckId = document.getElementById('outstationCheckId').checked;
            var localCheckId = document.getElementById('localCheckId').checked;
            if (!internationalCheckID && !outstationCheckId && !localCheckId) {
                event.preventDefault(); // Prevent the default form submission
                Swal.fire({
                    icon: 'info',
                    text: 'Select at least one allowance to activate the allowance settings!',
                });
                return;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#internationId').hide();
            // $('.add_item_btn_international').hide();
            $('#nationalId').hide();
            $('#localId').hide();

        });

        function toggleInternational(checkbox) {
            if (checkbox.checked) {
                $('#internationalAllowances').find('.form-row').show();
                $('.add_item_btn_international').show();
                $('#internationId').show();
                $(document).ready(function() {
                    $(document).ready(function() {
                        window.sb = $('.SlectBox-grp-src').SumoSelect({
                            csvDispCount: 3,
                            search: true,
                            searchText: 'Enter here.',
                            selectAll: true,
                            placeholder: "Enter Select"
                        });
                    });
                    getUmeshCallRecursive();
                    if ($('#internationalAllowances').find('.form-row').length === 0) {
                        var uniqueICountrySB = "internationalCountrySelectBox0[]";
                        var uniqueICategorySB = "internationlCategorySelectBox[]";
                        var newItemHtml = `
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="categoryId1">Category</label>
                                        <input type="text" class="form-control" id="categoryId1" name="${uniqueICategorySB}" placeholder="Enter Category Name" required>
                                    </div>
                                    <div class="form-group col select2-lg travelType1">
                                        <label for="inputPassword4">Country</label>
                                        <select multiple="multiple" id="countryId1" class="SlectBox-grp-src" name="${uniqueICountrySB}" required>
                                            @foreach ($staticCountry as $key => $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col select2-lg ">
                                        <label for="inputPassword4">Currency</label>
                                        <select class="form-select" id="currency" name="currency" required style="height: 40px;">
                                            <option value="">Select Currency</option>
                                            @foreach ($currency as $key => $item)
                                                <option value="{{ $item->id }}"> {{ $item->currency }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-1 text-end mt-5">
                                        <button type="button" class="btn btn-sm btn-danger mt-1 remove_item_btn_international"><i class="feather feather-trash"></i></button>
                                    </div>
                                </div>`;
                        $('#internationalAllowances').append(newItemHtml);


                        // Dynamically remove allowance items
                        // $(document).on('click', '.remove_item_btn_international', function() {
                        //     // Check if there's only one row left
                        //     if ($('#internationalAllowances').children('.form-row').length === 1) {
                        //         // Show error message or perform appropriate action
                        //         // alert('At least one row must be present.');
                        //     } else {
                        //         // Remove the closest form-row element
                        //         $(this).closest('.form-row').remove();
                        //     }
                        // });
                    }
                });
            } else {
                $('#internationalAllowances').find('.form-row').hide();
                // $('.form-row').hide(); // Hide all form-row elements
                $('#internationId').hide();
                $('.add_item_btn_international').hide();

            }
        }

        $(document).ready(function() {
            var rowCounterInternational =
                <?php echo $lastIdInternational ?? 0; ?>; // Initialize rowCounterInternational with the last ID value, defaulting to 0 if it's not set
            $('.add_item_btn_international').on('click', function() {
                rowCounterInternational++;
                $(document).ready(function() {
                    window.sb = $('.SlectBox-grp-src').SumoSelect({
                        csvDispCount: 3,
                        search: true,
                        searchText: 'Enter here.',
                        selectAll: true,
                        placeholder: "Enter Select"
                    });
                });
                getUmeshCallRecursive();
                var uniqueICountrySB = "internationalCountrySelectBox" + -rowCounterInternational + "[]";
                var uniqueICategotySB = "internationlCategorySelectBox" + "[" + -rowCounterInternational +
                    "]";
                var newItemHtml = `
                        <div class="form-row">
                            <input type="number" value="${-rowCounterInternational}" name="updateItmeIdNameInternationl[-${rowCounterInternational}]" hidden>
                            <div class="form-group col">
                                <label for="categoryId1">Category</label>
                                <input type="text" class="form-control" id="categoryId1" name="${uniqueICategotySB}" placeholder="Enter Category Name" required>
                            </div>
                            <div class="form-group col select2-lg travelType1">
                                <label for="inputPassword4">Country</label>
                                <select multiple="multiple" id="countryId1" class="SlectBox-grp-src" name="${uniqueICountrySB}" required>
                                    @foreach ($staticCountry as $key => $item)
                                        <option value="{{ $item->id }}"> {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col select2-lg ">
                                <label for="inputPassword4">Currency</label>
                                <select class="form-select" id="currency" name="currency" required style="height: 40px;">
                                    <option value="">Select Currency</option>
                                    @foreach ($currency as $key => $item)
                                        <option value="{{ $item->id }}"> {{ $item->currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="categoryId1">K.M Limite</label>
                                <input type="text" class="form-control" id="categoryId1" name="km_liit" placeholder="K.M Limite" >
                            </div>
                            <div class="form-group col-sm-1 text-end mt-5">
                                <button type="button" class="btn btn-sm btn-danger mt-1  remove_item_btn_international"><i class="feather feather-trash"></i></button>
                            </div>
                        </div>`;
                $('#internationalAllowances').append(newItemHtml);
                rowCounterInternational++;
            });

            // Dynamically remove allowance items
            $(document).on('click', '.remove_item_btn_international', function() {
                // Check if there's only one row left
                if ($('#internationalAllowances').children('.form-row').length === 1) {
                    // Show error message or perform appropriate action
                    // alert('At least one row must be present.');
                } else {
                    // Remove the closest form-row element
                    $(this).closest('.form-row').remove();
                }
            });
        });

        function appendInternationlFormItem() {   //auto lode  selected contry
            var internationValue = <?php echo json_encode($internationlAllowanceData); ?>;
            var staticCountry = <?php echo json_encode($staticCountry); ?>;
            var updatePolicyAllowanceId = <?php echo json_encode($MainData); ?>;
            internationValue.forEach(function(item) {
                $(document).ready(function() {
                    window.sb = $('.SlectBox-grp-src').SumoSelect({
                        csvDispCount: 3,
                        search: true,
                        searchText: 'Enter here.',
                        selectAll: true,
                        placeholder: "Enter Select"
                    });
                });
                getUmeshCallRecursive();
                var rowCounterInternational = item.id;
                var uniqueICountrySB = "internationalCountrySelectBox" + rowCounterInternational + "[]";
                var uniqueICategotySB = "internationlCategorySelectBox" + "[" + rowCounterInternational + "]";
                var countryIds = JSON.parse(item.country_id);
                var newItemHtml = `<div class="form-row" id="rowInternational_${item.id}">
                        <input type="number" value="${item.id}" name="updateItmeIdNameInternationl[${item.id}]" hidden>
                        <input type="number" value="${updatePolicyAllowanceId.id}" name="updatePolicyAllowanceId" hidden>
                        <div class="form-group col">
                            <label for="category_${item.id}">Category</label>
                            <input type="text" class="form-control" name="${uniqueICategotySB}" placeholder="Enter Category Name" value="${item.category}" required>
                        </div>
                        <div class="form-group col select2-lg travelType1">
                            <label for="country_${item.id}">Country</label>
                            <select multiple="multiple" class="SlectBox-grp-src" name="${uniqueICountrySB}" required>`;
                staticCountry.forEach(function(country) {
                    // Check if the country's id exists in the parsed countryIds array
                    var isSelected = countryIds.includes(country.id.toString());

                    // Add the option to the newItemHtml string with the 'selected' attribute if isSelected is true
                    newItemHtml +=
                        `<option value="${country.id}" ${isSelected ? 'selected' : ''}>${country.name}</option>`;
                });
                newItemHtml += `</select>
                </div>
                <div class="form-group col select2-lg">
                    <label for="inputPassword4">Currency</label>
                    <select class="form-select" id="currency" name="currency" required style="height: 40px;">
                        <option value="">Select Currency</option>
                        @foreach ($currency as $key => $item)
                            <option value="{{ $item->id }}"> {{ $item->currency }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-1 text-end mt-5">
                    <button type="button" class="btn btn-sm btn-danger mt-1 remove_item_btn_international"><i class="feather feather-trash"></i></button>
                </div>
            </div>`;
                $('#internationalAllowances').append(newItemHtml);
                rowCounterInternational++;
            });
            $(document).on('click', '.remove_item_btn_international', function() {
                // Check if there's only one row left
                if ($('#internationalAllowances').children('.form-row').length === 1) {
                    // Show error message or perform appropriate action
                    console.log($('#internationalAllowances').children('.form-row').length);
                } else {
                    // Remove the closest form-row element
                    $(this).closest('.form-row').remove();
                }
            });
        }

        function toggleNational(checkbox) {
            if (checkbox.checked) {
                $('#nationalAllowances').find('.form-row').show();
                // $('#nationalAllowances').find('.form-row').show();
                // $('.form-row').show(); // Hide all form-row elements
                $('.add_item_btn_national').show();
                $('#nationlId').show();
                $(document).ready(function() {
                    $(document).ready(function() {
                        window.sb = $('.SlectBox-grp-src').SumoSelect({
                            csvDispCount: 3,
                            search: true,
                            searchText: 'Enter here.',
                            selectAll: true,
                            placeholder: "Enter Select"
                        });
                    });
                    getUmeshCallRecursive();
                    if ($('#nationalAllowances').find('.form-row').length === 0) {
                        var uniqueICategotySB = "nationalCategorySelectBox[]";
                        var uniqueICountrySB = "nationalCountrySelectBox[]";
                        var uniqueCitySB = "nationalCitySelectBox0[]";

                        var newItemHtml = `
                                    <div class="form-row">
                                        <input type="number" value="0" name="updateItmeIdNameNational[]" hidden>
                                        <div class="form-group col">
                                            <label for="categoryId1">Category</label>
                                            <input type="text" class="form-control" id="categoryId1" name="${uniqueICategotySB}" placeholder="Enter Category Name" required>
                                        </div>
                                        <div class="form-group col select2-lg travelType1">
                                            <label for="inputPassword4">Country</label>
                                            <select  id="countryId1" class="SlectBox-grp-src" name="${uniqueICountrySB}" onchange="countryFun(this)" required>
                                                @foreach ($staticCountry as $key => $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col travelType2 city-field" id="cityId">
                                            <label for="inputPassword4">City</label>
                                            <select multiple="multiple" id="cityId2" name="${uniqueCitySB}"
                                                class="SlectBox-grp-src form-control cityId" required>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-1 text-end mt-5">
                                            <button type="button" class="btn btn-sm btn-danger mt-1 remove_item_btn_national"><i class="feather feather-trash"></i></button>
                                        </div>
                                    </div>`;
                        $('#nationalAllowances').append(newItemHtml);
                        // Dynamically remove allowance items
                        // $(document).on('click', '.remove_item_btn', function() {
                        //     $(this).closest('.form-row').remove();
                        // });
                        // Dynamically remove allowance items
                        $(document).on('click', '.remove_item_btn_national', function() {
                            // Check if there's only one row left
                            if ($('#nationalAllowances').children('.form-row').length === 1) {
                                // Show error message or perform appropriate action
                                // alert('At least one row must be present.');
                            } else {
                                // Remove the closest form-row element
                                $(this).closest('.form-row').remove();
                            }
                        });
                    }
                });
            } else {
                $('#nationalAllowances').find('.form-row').hide();
                // $('.form-row').hide(); // Hide all form-row elements
                $('#nationlId').hide();
                $('.add_item_btn_national').hide();
            }
        }

        $(document).ready(function() {
            var rowCounterNational =
                <?php echo $lastIdNational ?? 0; ?>; // Initialize rowCounterNational with the last ID value, defaulting to 0 if it's not set
            $('.add_item_btn_national').on('click', function() {
                rowCounterNational++;
                $(document).ready(function() {
                    window.sb = $('.SlectBox-grp-src').SumoSelect({
                        csvDispCount: 3,
                        search: true,
                        searchText: 'Enter here.',
                        selectAll: true,
                        placeholder: "Enter Select"
                    });
                });
                getUmeshCallRecursive();
                var uniqueICategotySB = "nationalCategorySelectBox" + "[" + -rowCounterNational + "]";
                var uniqueICountrySB = "nationalCountrySelectBox" + "[" + -rowCounterNational + "]";
                var uniqueCitySB = "nationalCitySelectBox" + -rowCounterNational + "[]";
                var newItemHtml = `
                        <div class="form-row">
                            <input type="number" value="${-rowCounterNational}" name="updateItmeIdNameNational[-${rowCounterNational}]" hidden>
                            <div class="form-group col">
                                <label for="categoryId1">Category</label>
                                <input type="text" class="form-control" id="categoryId1" name="${uniqueICategotySB}" placeholder="Enter Category Name" required>
                            </div>
                            <div class="form-group col select2-lg travelType1">
                                <label for="inputPassword4">Country</label>
                                <select id="countryId1" class="SlectBox-grp-src" name="${uniqueICountrySB}" onchange="countryFun(this)" required>
                                    @foreach ($staticCountry as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col travelType2 city-field" id="">
                                <label for="inputPassword4">City</label>
                                <select multiple="multiple" id="cityId2" name="${uniqueCitySB}"
                                    class="SlectBox-grp-src form-control cityId" required>
                                </select>
                            </div>
                            <div class="form-group col-sm-1 text-end mt-5">
                                <button type="button" class="btn btn-sm btn-danger mt-1  remove_item_btn_national"><i class="feather feather-trash"></i></button>
                            </div>
                        </div>`;
                $('#nationalAllowances').append(newItemHtml);
                rowCounterNational++;
            });

            // Dynamically remove allowance items
            $(document).on('click', '.remove_item_btn_national', function() {
                // Check if there's only one row left
                if ($('#nationalAllowances').children('.form-row').length === 1) {
                    // Show error message or perform appropriate action
                    // alert('At least one row must be present.');
                } else {
                    // Remove the closest form-row element
                    $(this).closest('.form-row').remove();
                }
            });
        });

        function appendNationalFormItem() {
            var nationalValue = <?php echo json_encode($natioanlAllowanceData); ?>;
            var staticCountry = <?php echo json_encode($staticCountry); ?>;
            var updatePolicyAllowanceId = <?php echo json_encode($MainData); ?>;
            nationalValue.forEach(function(item) {
                $(document).ready(function() {
                    window.sb = $('.SlectBox-grp-src').SumoSelect({
                        csvDispCount: 3,
                        search: true,
                        searchText: 'Enter here.',
                        selectAll: true,
                        placeholder: "Enter Select"
                    });
                });
                getUmeshCallRecursive();
                var rowCounterNational = item.id;
                var uniqueICategotySB = "nationalCategorySelectBox" + "[" + rowCounterNational + "]";
                var uniqueICountrySB = "nationalCountrySelectBox" + "[" + rowCounterNational + "]";
                var uniqueCitySB = "nationalCitySelectBox" + rowCounterNational + "[]";

                var newItemHtml = `<div class="form-row" id="row_${item.id}">
                        <input type="number" value="${item.id}" name="updateItmeIdNameNational[${item.id}]" hidden>
                        <input type="number" value="${updatePolicyAllowanceId.id}" name="updatePolicyAllowanceId" hidden>
                        <div class="form-group col">
                            <label for="category_${item.id}">Category</label>
                            <input type="text" class="form-control" name="${uniqueICategotySB}" placeholder="Enter Category Name" value="${item.category}" required>
                        </div>
                        <div class="form-group col select2-lg travelType1">
                            <label for="inputPassword4">Country</label>
                            <select id="countryId_${rowCounterNational}" class="SlectBox-grp-src" name="${uniqueICountrySB}" onchange="countryFun(this)" required>
                                <?php foreach ($staticCountry as $key => $country) : ?>
                                    <?php $selected = property_exists($item, 'country_id') && $item->country_id == $country->id ? 'selected' : ''; ?>
                                    <option value="<?php echo $country->id; ?>" <?php echo $selected; ?>><?php echo $country->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col travelType2 city-field" id="cityId_${rowCounterNational}">
                            <label for="inputPassword4">City</label>
                            <select multiple="multiple" id="cityId2_${rowCounterNational}" name="${uniqueCitySB}" class="SlectBox-grp-src form-control cityId" required>
                                <!-- Populate cities based on country selection -->
                            </select>
                        </div>
                        <div class="form-group col-sm-1 text-end mt-5">
                            <button type="button" class="btn btn-sm btn-danger mt-1 remove_item_btn_national"><i class="feather feather-trash"></i></button>
                        </div>
                    </div>`;
                $('#nationalAllowances').append(newItemHtml);
                $('#countryId_' + rowCounterNational).val(item.country_id);
                // Call countryFun with the select element
                countryFunSelected($('#countryId_' + rowCounterNational)[0], item.city_id); // Pass the DOM e
                rowCounterNational++;
                $(document).on('click', '.remove_item_btn_national', function() {
                    // Check if there's only one row left
                    if ($('#nationalAllowances').children('.form-row').length === 1) {
                        // Show error message or perform appropriate action
                        // alert('At least one row must be present.');
                    } else {
                        // Remove the closest form-row element
                        $(this).closest('.form-row').remove();
                    }
                });
            });
        }

        function appendLocalFormItem() {
            var localValue = <?php echo json_encode($localAllowanceData); ?>;
            var updatePolicyAllowanceId = <?php echo json_encode($MainData); ?>;
            localValue.forEach(function(item) {
                $(document).ready(function() {
                    window.sb = $('.SlectBox-grp-src').SumoSelect({
                        csvDispCount: 3,
                        search: true,
                        searchText: 'Enter here.',
                        selectAll: true,
                        placeholder: "Enter Select"
                    });
                });
                getUmeshCallRecursive();
                var rowCounterLocal = item.id;
                var uniqueICategoty = "localCategory" + "[" + rowCounterLocal + "]";
                var uniqueKilometer = "localKilometer" + "[" + rowCounterLocal + "]";

                var newItemHtml = `<div class="form-row" id="rowLocal_${item.id}">
                        <input type="number" value="${item.id}" name="updateItmeIdNameLocal[${item.id}]" hidden>
                        <input type="number" value="${updatePolicyAllowanceId.id}" name="updatePolicyAllowanceId" hidden>
                        <div class="form-group col">
                            <label for="category_${item.id}">Category</label>
                            <input type="text" class="form-control" name="${uniqueICategoty}" placeholder="Enter Category Name" value="${item.category}" required>
                        </div>
                        <div class="form-group col">
                            <label for="categoryId1">Range in KM</label>
                            <input type="text" class="form-control" id="" value="${item.kilometer_value}" name="${uniqueKilometer}" placeholder="Enter KM "  oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        </div>
                        <div class="form-group col select2-lg ">
                            <label for="inputPassword4">Variation</label>
                            <select class="form-select" id="variation" name="variation" required style="height: 40px;">
                                <option value="">Select Variation</option>
                                @foreach ($variation as $key => $item)
                                    <option value="{{ $item->id }}"> {{ $item->variation_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col">
                                <label for="categoryId1">K.M Limite</label>
                                <input type="text" class="form-control" id="categoryId1" name="km_liit" placeholder="K.M Limite" >
                            </div>
                        <div class="form-group col-sm-1 text-end mt-5">
                            <button type="button" class="btn btn-sm btn-danger mt-1 remove_item_btn_local"><i class="feather feather-trash"></i></button>
                        </div>
                        </div>`;
                $('#localAllowances').append(newItemHtml);
                rowCounterLocal++;
            });
            $(document).on('click', '.remove_item_btn_local', function() {
                // Check if there's only one row left
                if ($('#localAllowances').children('.form-row').length === 1) {
                    // Show error message or perform appropriate action
                    // alert('At least one row must be present.');
                } else {
                    // Remove the closest form-row element
                    $(this).closest('.form-row').remove();
                }
            });
        }


        window.onload = function() {
            appendInternationlFormItem();
            appendNationalFormItem();
            appendLocalFormItem();
        };

        function countryFunSelected(context, cityIDs) {
            var id = $(context).val();
            var $row = $(context).closest('.form-row'); // Find the closest parent row
            $.ajax({
                url: "{{ url('/admin/settings/tadasettings/countrytocityfilter') }}",
                type: "POST",
                async: true,
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                dataType: 'json',
                cache: true,
                success: function(result) {
                    var $citySelect = $row.find('.cityId'); // Find the city select element within the row
                    var selectSumo = $citySelect[0].sumo;
                    selectSumo.unSelectAll(); // Clear previous selections
                    $citySelect.empty();
                    $.each(result.static_cities, function(key, value) {
                        var selected = (cityIDs.includes(value.id.toString())) ? 'selected' : '';
                        $citySelect.append('<option value="' + value.id + '" ' + selected + '>' + value
                            .name + '</option>');
                    });
                    // Refresh the SumoSelect to reflect changes
                    selectSumo.reload();

                    // Get the SumoSelect instance
                    var sumoSelectInstance = $citySelect.data('SumoSelect');

                    // Clear previous selections
                    // sumoSelectInstance.unSelectAll();

                    // Select each value from the cityIDs array
                    // cityIDs.forEach(function(cityID) {
                    //     sumoSelectInstance.selectItem(cityID);
                    // });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        function countryFun(context) {
            var id = $(context).val();
            var $row = $(context).closest('.form-row'); // Find the closest parent row
            $.ajax({
                url: "{{ url('/admin/settings/tadasettings/countrytocityfilter') }}",
                type: "POST",
                async: true,
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                dataType: 'json',
                cache: true,
                success: function(result) {
                    var $citySelect = $row.find('.cityId'); // Find the city select element within the row
                    var selectSumo = $citySelect[0].sumo;
                    selectSumo.unSelectAll(); // Clear previous selections
                    $citySelect.empty();
                    $.each(result.static_cities, function(key, value) {
                        $citySelect.append('<option value="' + value.id + '">' + value.name +
                            '</option>');
                    });

                    // Refresh the SumoSelect to reflect changes
                    selectSumo.reload();
                    // Select the first option
                    $citySelect.val($citySelect.find('option:first').val()).trigger(
                        'change'); // or any change event you have
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        function toggleLocal(checkbox) {
            if (checkbox.checked) {
                $('#localAllowances').find('.form-row').show();
                $('.add_item_btn_local').show();
                $('#localId').show();
                $(document).ready(function() {
                    $(document).ready(function() {
                        window.sb = $('.SlectBox-grp-src').SumoSelect({
                            csvDispCount: 3,
                            search: true,
                            searchText: 'Enter here.',
                            selectAll: true,
                            placeholder: "Enter Select"
                        });
                    });
                    getUmeshCallRecursive();
                    if ($('#localAllowances').find('.form-row').length === 0) {
                        var uniqueICategoty = "localCategory[]";
                        var uniqueKilometer = "localKilometer[]";
                        var uniqueICategorySB = "internationlCategorySelectBox[]";
                        var uniqueICountrySB = "lcoalCountrySelectBox[]";
                        var uniqueStateSB = "internationlStateSelectBox[]";
                        var uniqueCitiesSB = "internationlCitySelectBox0[]";
                        var newItemHtml = `<div class="form-row">
                                <input type = "number" value = "0" name = "updateItmeIdNameLocal[]" hidden>
                            </div>`
                        var newItemHtml = `<div class="form-row">
                            <input type="number" value="0" name="updateItmeIdNameLocal[]" hidden>
                            <div class="form-group col">
                                <label for="categoryId1">Category</label>
                                <input type="text" class="form-control" id="" name="${uniqueICategoty}" placeholder="Enter Category Name">
                            </div>
                            <div class="form-group col">
                                <label for="categoryId1">Range in KM</label>
                                <input type="text" class="form-control" id="categoryId1" name="${uniqueKilometer}" placeholder="Enter KM" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                            </div>
                            <div class="form-group col select2-lg ">
                                <label for="inputPassword4">Variation</label>
                                <select class="form-select" id="variation" name="variation" required style="height: 40px;">
                                    <option value="">Select Variation</option>
                                    @foreach ($variation as $key => $item)
                                        <option value="{{ $item->id }}"> {{ $item->variation_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="categoryId1">K.M Limite</label>
                                <input type="text" class="form-control" id="categoryId1" name="km_liit" placeholder="K.M Limite" >
                            </div>
                            <div class="form-group col-sm-1 text-end mt-5" >
                                <button type="button" class="btn btn-sm btn-danger mt-1 remove_item_btn_local"><i class="feather feather-trash"></i></button>
                            </div>
                        </div>`;

                        $('#localAllowances').append(newItemHtml);
                        // Dynamically remove allowance items
                        $(document).on('click', '.remove_item_btn_local', function() {
                            // Check if there's only one row left
                            if ($('#localAllowances').children('.form-row').length === 1) {
                                // Show error message or perform appropriate action
                                // alert('At least one row must be present.');
                            } else {
                                // Remove the closest form-row element
                                $(this).closest('.form-row').remove();
                            }
                        });
                    }
                });
            } else {
                $('#localAllowances').find('.form-row').hide();
                // $('.form-row').hide(); // Hide all form-row elements
                $('#local').hide();
                $('.add_item_btn_local').hide();

            }
        }
        $(document).ready(function() {
            var rowCounterLocal =
                <?php echo $lastIdLocal ?? 0; ?>; // Initialize rowCounterLocal with the last ID value, defaulting to 0 if it's not set
            $('.add_item_btn_local').on('click', function() {
                rowCounterLocal++;
                $(document).ready(function() {
                    window.sb = $('.SlectBox-grp-src').SumoSelect({
                        csvDispCount: 3,
                        search: true,
                        searchText: 'Enter here.',
                        selectAll: true,
                        placeholder: "Enter Select"
                    });
                });
                getUmeshCallRecursive();
                var uniqueICategoty = "localCategory" + "[" + -rowCounterLocal + "]";
                var uniqueKilometer = "localKilometer" + "[" + -rowCounterLocal + "]";
                var newItemHtml = `<div class="form-row">
                                        <input type="number" value="${-rowCounterLocal}" name="updateItmeIdNameLocal[-${rowCounterLocal}]" hidden>
                                        <div class="form-group col">
                                            <label for="categoryId1">Category</label>
                                            <input type="text" class="form-control" id="" name="${uniqueICategoty}" placeholder="Enter Category Name" required>
                                        </div>
                                        <div class="form-group col">
                                            <label for="categoryId1">Range in KM</label>
                                            <input type="text" class="form-control" id="" name="${uniqueKilometer}" placeholder="Enter KM "  oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                        </div>
                                        <div class="form-group col select2-lg ">
                                            <label for="inputPassword4">Variation</label>
                                            <select class="form-select" id="variation" name="variation" required style="height: 40px;">
                                                <option value="">Select Variation</option>
                                                @foreach ($variation as $key => $item)
                                                    <option value="{{ $item->id }}"> {{ $item->variation_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="categoryId1">K.M Limite</label>
                                            <input type="text" class="form-control" id="categoryId1" name="km_liit" placeholder="K.M Limite" >
                                        </div>
                                        <div class="form-group col-sm-1 text-end mt-5">
                                            <button type="button" class="btn btn-sm btn-danger mt-1 remove_item_btn_local"><i class="feather feather-trash"></i></button>
                                        </div>
                                    </div>`;
                $('#localAllowances').append(newItemHtml);
                rowCounterLocal++;
            });

            // Dynamically remove allowance items
            $(document).on('click', '.remove_item_btn_local', function() {
                // Check if there's only one row left
                if ($('#localAllowances').children('.form-row').length === 1) {
                    // Show error message or perform appropriate action
                    // alert('At least one row must be present.');
                } else {
                    // Remove the closest form-row element
                    $(this).closest('.form-row').remove();
                }
            });
        });
    </script>
</div>
