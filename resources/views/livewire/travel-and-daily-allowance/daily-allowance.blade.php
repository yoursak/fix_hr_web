<div>
    {{-- Include jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class=" p-0 pt-2 pb-5">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/tadasettings') }}">Travel & Daily Allowance Settings</a></li>
            <li class="active"><span><b>Lodging Policy</b></span></li>
        </ol>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lodging Policy</h3>
            <div class="ms-auto">
                <button type="button" class="btn btn-sm btn-primary" wire:click.prevent="add">
                    <i class="fe fe-plus bold"></i></button>
            </div>
        </div>
        <div class="card-body">
            @foreach ($increase as $key => $value)
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-xl-2 col-xxl-2">
                        <div class="form-group">
                            <label class="form-label">Grade Category</label>
                            <select class="form-control" placeholder="Grade Category" required wire:model="gradeCategory.{{ $value }}">
                                <option value="{{ $gradeCategory[$value] ?? '' }}">L1</option>
                                <option value="2">L2</option>
                                <option value="3">L3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-2  col-xxl-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="form-label">Travel Type &nbsp;<i class="fa fa-info-circle" style="font-size:15px" data-bs-toggle="tooltip" data-bs-placement="top" title="Travel Type"></i></label>
                                <select class="form-control"  placeholder="Travel Type" wire:model="travel.{{$key}}"
                                    onchange="change_modes(this)" required>
                                    <option value="{{ $travel[$value] ?? '' }}">
                                        {{ $travel[$value] ?? '' }}</option>
                                    <option value="4">2</option>
                                    <option value="5">3</option>
                                    <option value="5">4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-2 col-xxl-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="form-label">Travel Category</label>
                                <select class="form-control"  placeholder="Travel Type" wire:model="travel_category.{{ $key }}"
                                    onchange="change_modes(this)" required>
                                    <option value="{{ $travel_category[$value] ?? '' }}">
                                        {{ $travel_category[$value] ?? '' }}</option>
                                    <option value="4">2</option>
                                    <option value="5">3</option>
                                    <option value="5">4</option>
                                </select>
                                {{-- <input type="text"  class="form-control" placeholder="Travel Category" value="{{ $selectedDesignations[$value] ?? '' }}" required> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-2 col-xxl-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="form-label">DA Limit</label>
                                <select class="form-control" wire:model="lodging_limit.{{ $key }}">
                                    <option value="">Select Limit</option>
                                    <option value="1">Yes</option>
                                    <option value="2">NO</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-xl-2 col-xxl-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="form-label">DA Amount</label>
                                <input type="text" class="form-control" placeholder="Singal Occupancy" wire:model="select_occupancy.{{ $value }}"
                                    value="{{ $select_occupancy[$value] ?? '' }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-12 col-md-4 col-xl-2 col-xxl-2 mb-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="form-label">Double Occupancy</label>
                                <input type="text" class="form-control" placeholder="Double Occupancy" wire:model = "double_occupancy.{{$value}}"
                                    value="{{ $double_occupancy[$value] ?? '' }}" required>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-sm-12 col-4 col-xl-1 col-xxl-1">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="form-label">Currency</label>
                                <select class="form-control"  placeholder="Currency" wire:model="currency.{{ $key }}"
                                    onchange="change_modes(this)" required>
                                    <option value="{{ $currency[$value] ?? '' }}" selected>{{ $currency[$value] ?? '' }}</option>
                                    <option value="4">R</option>
                                    <option value="5">$</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    <div
                        class="col-sm-12 col-12 col-xl-2 col-xxl-2 mt-3 mt-md-0 d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-sm btn-danger mt-1"
                            wire:click="remove({{ $key }})"><i class="feather feather-trash"></i></button>
                    </div>
                    {{-- <p class="mb-0 pb-0 text-muted fs-12 mt-3 mt-md-5">By continuing you agree to <a href="#" class="text-primary">Terms & Conditions</a></p> --}}

                </div>
            @endforeach
            <div class="row d-flex">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" wire:click.prevent="store()"  class="btn btn-primary">Save And Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
