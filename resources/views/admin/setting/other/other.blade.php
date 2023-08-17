@extends('admin.setting.setting')
@section('subtitle')
Others
@endsection
@section('settings')
<div class="row row-sm">
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span class="settings-icon bg-primary-transparent text-primary border-primary"><i
                                    class="fe fe-settings"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Chanel Partners ID (optional)</h5>
                        </a>
                        <p>Add Optional chanel partners ID</p>
                        <a href="#" data-bs-target="#cpid" data-bs-toggle="modal">Change Settings <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="mt-2 mb-4">
                            <span
                                class="settings-icon bg-secondary-transparent text-secondary border-secondary"><i
                                    class="fe fe-log-out"></i></span>
                        </div>
                    </div>
                    <div class="col-10">
                        <a href="#">
                            <h5 class="mb-1 text-dark">Log Out</h5>
                        </a>
                        <p>forget session and go back.</p>
                        <a href="#">Log Out Now <i class="ion-chevron-right fs-10 ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add channel partners id --}}
<div class="modal fade" id="cpid">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header border-0">
                <h4 class="modal-title ms-2">Add Channel partners Id</h4><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg">
                    <p class="mb-0 pb-0 text-dark fs-13 mt-1 ">Add Optional chanel partners ID</p>
                    <input class="form-control" placeholder="Chanel Partner ID (optional)" type="text">
                    <p class="mb-0 pb-0 text-muted fs-12 mt-5 ">By continuing you agree to <a href="#"
                            class="text-primary">Terms & Conditions</a></p>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-outline-dark cancel" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success savebtn">Continue</button>
            </div>
        </div>
    </div>
</div>
@endsection
