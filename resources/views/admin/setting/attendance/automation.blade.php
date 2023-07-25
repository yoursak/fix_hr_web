@extends('admin.setting.setting')
@section('subtitle')
    Attendance / Automation Rule
@endsection
@section('settings')
<div class="row row-sm">
    <div class="col-lg-8">
        <div class="card">
            <div class="tab-menu-heading p-0 border-0">
                <div class="tabs-menu1 px-3">
                    <ul class="nav">
                        <li><a href="#tab-7" class="active" data-bs-toggle="tab">Rules</a></li>
                        <li><a href="#tab-8" class="text-muted">Staff Selection</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body d-flex border-top">
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mg-b-20 card--events">
            <div class="card-body p-0">
                <div class="">
                    <ul class="list-group mb-0">
                        <li class="list-group-item d-flex border-start-0 border-end-0">
                            <h6 class="">1. </h6>
                            <div>
                                <h6 class="">Create Your First Rule</h6>
                                <p class="mb-0 text-muted fs-12">You can define rule by selecting any of the checkboxes.</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex border-start-0 border-end-0">
                            <h6 class="text-muted">2. </h6>
                            <div>
                                <h6 class="text-muted">Set A Rule Value</h6>
                                <p class="mb-0 text-muted fs-12">Set a value for your rule.</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex border-start-0 border-end-0">
                            <h6 class="text-muted">3. </h6>
                            <div>
                                <h6 class="text-muted">Assign Employee</h6>
                                <p class="mb-0 text-muted fs-12">Select Employee that you want the rule to be assigned to.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
