{{-- <?php dd('Designation', $Designation, 'Grade', $Grade); ?> --}}
{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
<div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Your Livewire component Blade template -->


    <!-- Loop through validation errors for specific fields -->
    @foreach ($errors->all() as $error)
        @if (strpos($error, 'Category Name field') !== false)
            <!-- Display validation error for nameCategory -->
            <div class="alert alert-danger" hidden>{{ $error }}</div>
        @elseif (strpos($error, 'Grade field') !== false)
            <!-- Display validation error for gradeFilter -->
            <div class="alert alert-danger" hidden>{{ $error }}</div>
        @elseif (strpos($error, 'Designation field') !== false)
            <!-- Display validation error for selectedDesignations -->
            <div class="alert alert-danger" hidden>{{ $error }}</div>
        @endif
    @endforeach

    <div class=" p-0 pt-2">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/tadasettings') }}">Travel & Daily Allowance Settings</a></li>
            <li class="active"><span><b>Travel Grade</b></span></li>
        </ol>
    </div>
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Travel Grade</div>
            <p class="text-muted">Create and activate your Grade of Travel</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex">
            <div>
                <h4 class="card-title"><span>Create Travel Grade Category</span></h4>
            </div>
            <div class="ms-auto">
                <button class="btn text-white btn-info btn-sm" wire:click="add"><i class="fe fe-plus bold"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form>
                @foreach ($inputs as $key => $value)
                    <div class="add-input">
                        <div class="row">
                            <div class="col-md-6" wire:ignore>
                                <div class="form-group">
                                    <p class="form-label">Grade Category</p>
                                    <div class="form-group" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Category Name"
                                                name="grade_catgeory" wire:model="nameCategory.{{ $value }}">
                                        </div>
                                        @error('nameCategory.' . $value)
                                            <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5" wire:ignore>
                                <div class="form-group">
                                    <div class="form-group mb-3" x-data="{ isOpen: false }"
                                        x-on:click.away="isOpen = false">
                                        <div class="input-group">
                                            <p class="form-label">Grade Group</p>
                                            <select wire:model="gradeFilter.{{ $value }}"
                                                wire:change="getDesignation({{ $value }})" name="grade_id"
                                                class="form-control search_test" multiple="multiple"
                                                x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                                @foreach ($Grade as $key => $data)
                                                    <option value="{{ $data->id }}"
                                                        @if (!empty($selectedValues[$value]) && in_array($data->id, $selectedValues[$value])) selected @endif>
                                                        {{ $data->grade_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('gradeFilter.' . $value)
                                            <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.min.js') }}"></script>
                                    <script src="{{ asset('assets/jayant-sumoselect/jquery.sumoselect.js') }}"></script>

                                    <script>
                                        $('.search_test').SumoSelect({
                                            search: true,
                                            searchText: 'Enter here.',
                                            triggerChangeCombined: true,
                                            forceCustomRendering: true,
                                        });
                                    </script>
                                </div>
                            </div>

                            <div class="col-md-4" hidden>
                                <div class="form-group">
                                    <div class="form-group mb-3" wire:model="selectedDesignations.{{ $key }}"
                                        x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                                        <p class="form-label">Designation</p>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                value="{{ $selectedDesignations[$value] ?? '' }}" readonly>
                                        </div>
                                        @error('designation.' . $value)
                                            <span class="text-danger error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-1 text-end mt-5">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-danger mt-1 "
                                        wire:click="remove({{ $key }})"><i
                                            class="feather feather-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="justify-content-end d-flex ">
                        <button type="button" wire:click="store()" class="btn btn-primary">Save &
                            Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
