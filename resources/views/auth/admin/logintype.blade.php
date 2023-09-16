@extends('auth/admin/authlayout.master')
@section('title', 'Login')
@section('css')
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ asset('assets/css/style.css?V=1.2') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" />

    <!-- ANIMATE CSS -->
    <link href="{{ asset('assets/css/animated.css') }}" rel="stylesheet" />

    <!---ICONS CSS -->
    <link href="{{ asset('assets/plugins/icons/icons.css') }}" rel="stylesheet" />

    <!-- INTERNAL SWITCHER CSS -->
    <link href="{{ asset('assets/switcher/css/switcher.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/switcher/demo.css') }}" rel="stylesheet" />


@endsection
@section('js')

@endsection
@section('contentes')
    <div class="card col-md-12 col-lg-12 p-5">
        <div class="row align-items-center  ">
            <h3>Welcome to FixHR</h3>
            <p>Please provide details us asked below for unique account creation</p>
            {{-- {{$businessIDtoName['business_name']}} --}}
            @foreach ($checking as $item)
                <?php
                // dd($checking);
            // admin
            if($item->user=="0") {?>

                <a href="{{ url('/') }}" name="submit" class="col-md-12 col-sm-6 col-lg-12  ">
                    {{-- $businessID = "ef4ae3f5e5c70b8454cf90498eae61d9"; --}}
                    <?php Session::put('business_id', $item->business_id); ?>

                    <div class="offer offer-radius offer-primary">
                        <div class="shape">
                            <div class="shape-text">
                                owner
                            </div>
                        </div>
                        <div class="offer-content">
                            <h3 class="lead font-weight-semibold">
                                {{-- {{ $item->user }} --}}
                                <b> {{ $item->business_name }}</b>
                            </h3>
                            <p class=" ">
                                To record attendance details
                                of my employee
                            </p>
                        </div>

                    </div>
                </a>
                <?php }else {?>
                <a href="{{ url('/') }}" name="submit" class="col-md-12 col-sm-6 col-lg-12 pt-3 ">
                    <?php
                    $login = DB::table('login_admin')
                        ->where('email', $item->business_id)
                        ->get();
                    
                    Session::put('business_id', $item->business_id);
                    $branchID = DB::table('branch_list')
                        ->where('business_id', $item->business_id)
                        ->get();
                    Session::put('brand_id', $branchID);
                    //  Session::put('branch_id', ($item->branch_id) ? $item->branch_id : '');
                    ?>

                    <div class="offer offer-radius offer-primary">
                        <div class="shape">
                            <div class="shape-text">

                                admin

                            </div>
                        </div>
                        <div class="offer-content">
                            <h3 class="lead font-weight-semibold">
                                {{-- {{ $item->user }} --}}
                                {{-- <b> {{ $businessIDtoName->business_name }}</b> --}}

                            </h3>
                            <p class=" ">


                                To access attendance details of the company

                            </p>
                        </div>

                    </div>
                </a>

                <?php }?>
            @endforeach

        </div>
    </div>

@endsection
