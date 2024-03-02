@extends('admin.setting.setting')
@section('subtitle')
Business
@endsection
@section('settings')
<div class="row row-sm">
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i class="nav-icon fa fa-sitemap"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Salary Settings </h5>
                            </a>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/payroll/salaryset') }}"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- earning --}}

    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i class="nav-icon fa fa-sitemap"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Earnings </h5>
                            </a>
                            <p class="my-auto">&nbsp;

                            </p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/payroll/earnings') }}"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- deduction --}}

    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i class="nav-icon fa fa-sitemap"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Deductions </h5>
                            </a>
                            <p class="my-auto">&nbsp;

                            </p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/payroll/deductions') }}"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- overtimer --}}

    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i class="nav-icon fa fa-sitemap"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Indirect Allowance </h5>
                            </a>
                            <p class="my-auto">&nbsp;

                            </p>
                        </div>
                        <div class="my-auto"> <a href="{{ url('admin/settings/payroll/indirect/allowance') }}"><i
                                    class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 my-auto">
                        <span class="settings-icon bg-primary-transparent text-primary border-primary"><i class="nav-icon fa fa-sitemap"></i></span>
                    </div>
                    <div class="col-10 d-flex justify-content-between">
                        <div class="my-auto"><a href="#">
                                <h5 class="my-auto text-dark">Salary Template</h5>
                            </a>
                            <p class="my-auto">&nbsp;

                            </p>
                        </div>
                        <div class="my-auto"> <a href="{{ route('salary-template') }}"><i class="fa fa-angle-double-right fs-20 my-auto"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
