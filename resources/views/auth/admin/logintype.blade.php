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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection
@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
@endsection
@section('contentes')

    <body id="my-view">

        <div class="card col-md-12 col-lg-12 p-5">
            <div class="row align-items-center ">
                <h3>Welcome to FixHR</h3>
                <p>Please provide details as asked below for a unique account creation</p>

                @foreach ($checking as $index => $item)
                    <?php
                    // dd($checking);
                    $login = DB::table('login_admin')
                        ->where('email', $item->business_id)
                        ->get();
                    Session::put('business_id', $item->business_id);
                    $branchID = DB::table('branch_list')
                        ->where('business_id', $item->business_id)
                        ->get();
                    
                    // $node = DB::table('roles')
                    //     ->where('business_id', $item->business_id)
                    //     ->get();
                    // dd($checking);
                    if ($item->user == '0') {
                        $cardType = 'owner';
                        $cardBusinessID = (string) $item->business_id;
                        $cardBrandID = (string) $item->branch_id;
                    } elseif ($item->user == '1') {
                        $cardType = 'admin';
                        $cardBusinessID = (string) $item->business_id;
                        $cardBrandID = (string) $item->branch_id;
                    } elseif ($item->user == '2') {
                        $cardType = 'superadmin';
                        $cardBusinessID = (string) $item->business_id;
                        $cardBrandID = (string) $item->branch_id;
                    } elseif ($item->user == '3') {
                        //hold
                        $cardType = 'employee';
                        $cardBusinessID = (string) $item->business_id;
                        $cardBrandID = (string) $item->branch_id;
                    }
                    //  = $item->user == '0' ? 'owner' : 'admin';
                    // $cardBusinessID = $item->user == '0' ? (string) $item->business_id : (string) $item->business_id;
                    // $cardBrandID = $item->user == '0' ? (string) $item->branch_id : (string) $item->branch_id;
                    $cardId = "card-{$index}"; // Generate a unique ID for each card
                    ?>
                    <div class="col-md-12 col-sm-6 col-lg-12 checking-root p-0" id="{{ $cardId }}">
                        <form action="{{ route('admin.handleCard') }}" method="post">
                            @csrf
                            <div class="offer offer-radius offer-primary">
                                <div class="shape">
                                    <div class="shape-text">{{ $cardType }}</div>
                                    <div class="shape-id" hidden>{{ $cardBusinessID }}</div>
                                    {{-- <div class="shape-brandid" hidden>{{$item}}</div> --}}

                                </div>
                                <div class="offer-content">
                                    <h3 class="lead font-weight-semibold"><b>{{ $item->business_name }}</b></h3>
                                    <p>
                                        @if ($item->user == '0')
                                            To record attendance details of my employee
                                        @else
                                            To access attendance details of the company
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            $('.checking-root').on('click', function(event) {
                event.preventDefault();
                var cardType = $(this).find('.shape-text').text().toLowerCase();
                var business_id = $(this).find('.shape-id').text();
                var brandid = $(this).find('.shape-brandid').text();
                // Make the AJAX request
                $.ajax({
                    url: "{{ route('admin.handleCard') }}", // Replace with the actual route name
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        card_type: [cardType, business_id],
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Handle the response if needed
                        console.log(response.root);
                        if (response.root == 'owner') {
                            // Redirect to the owner page
                            window.location.href =
                                "{{ url('/') }}"; // Replace with your actual owner route
                        } else if (response.root == 'admin') {
                            // Redirect to the admin page
                            window.location.href =
                                "{{ url('/') }}"; // Replace with your actual admin route
                        } else if (response.root == "superadmin") {
                            window.location.href =
                                "{{ url('/') }}"; // Replace with your actual admin route
                            // other case hold
                        } else {
                            window.location.href =
                                "{{ url('/login') }}"; // Replace with your actual admin route
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        </script>
    </body>
@endsection
