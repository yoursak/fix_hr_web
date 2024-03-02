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
                <p>Please Provide Details as Asked Below for a Unique Account Creation</p>
                <?php
                $Helper = new App\Helpers\Central_unit();
                $RuleManagement = new App\Helpers\MasterRulesManagement\RulesManagement();
                $root = DB::table('business_details_list')->where('business_email', Session::get('email'))->first();

                $adminList = DB::table('employee_personal_details')->where('emp_email', Session::get('email'))->get();

                // dd($root);
                $index = 0;
                $cardId = "card-{$index}";

                $cardType = 'Owner'; // Generate a unique ID for each card
                ?>
                <div class="col-md-12 col-sm-6 col-lg-12  owner-card p-0" id="{{ $cardId }}">
                    <form action="{{ route('admin.handleCard') }}" method="post">
                        @csrf
                        <?php if ($root != null) {
                        $cardBusinessID = (string) $root->business_id;
                        $cardBusinessName = (string) $root->business_name;
                    ?>
                        <div class="offer offer-radius offer-primary">
                            <div class="shape">

                                <div class="shape-text"> {{ $cardType }}</div>
                                <div class="shape-id" hidden>{{ $cardBusinessID }}</div>
                            </div>
                            <div class="offer-content">
                                <h3 class="lead font-weight-semibold"><b>{{ $cardBusinessName }}</b></h3>
                                <p>
                                    To Record Attendance Details of My Employees

                                </p>
                            </div>
                        </div>
                        <?php }
                    ?>
                    </form>
                </div>
                <?php
            foreach ($adminList as $adminIndex => $adminItem) {
                if ($adminItem->business_id != null) {
                    $adminCardType = 'admin';

                    $adminRoleName=(string)$RuleManagement->roleIDToNameConvert($adminItem->role_id,$adminItem->business_id);

                    $adminBusinessID = (string) $adminItem->business_id;
                    $adminBranchID = (string) $adminItem->branch_id;
                    $adminDesignationID = (string) $adminItem->designation_id;
                    $adminBusinessName = $Helper->BusinessIdToName2($adminItem->business_id);
                    $adminCardId = "card-admin-{$adminIndex}";
            ?>
                <div class="col-md-12 col-sm-6 col-lg-12 p-0 admin-card" data-index="{{ $adminIndex }}"
                    id="{{ $adminCardId }}">
                    <form action="{{ route('admin.handleCard') }}" method="post">
                        @csrf
                        <div class="offer offer-radius offer-primary">
                            <div class="shape">
                                <div class="shape-text">{{ $adminRoleName }}</div>
                                <div class="shape-logintype" hidden>{{ $adminCardType }}</div>
                                <div class="shape-id" hidden>{{ $adminBusinessID }}</div>
                                <div class="shape-brandid" hidden>{{ $adminBranchID }}</div>
                                <div class="shape-designationid" hidden>{{ $adminDesignationID }}</div>
                            </div>
                            <div class="offer-content">
                                <h3 class="lead font-weight-semibold"><b>{{ $adminBusinessName }}</b></h3>
                                <p>To Access Attendance Details of The Company</p>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                }
            }
            ?>
            </div>
        </div>

        <script>
            // Handle click on owner card
            $('.owner-card').on('click', function(event) {
                event.preventDefault();
                var cardType = $(this).find('.shape-text').text().toLowerCase();
                var business_id = $(this).find('.shape-id').text();

                // Check if business_id is not empty or null
                if (business_id) {
                    $.ajax({
                        url: "{{ route('admin.handleCard') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            card_type1: [cardType, business_id],
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log(response.root);
                            if (response.root == 'owner') {
                                window.location.href = "{{ url('/dashboard') }}";
                            } else {
                                window.location.href = "{{ url('/login') }}";

                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    console.log("business_id is empty or null");
                }
            });

            // Handle click on admin cards
            $('.admin-card').on('click', function(event) {
                event.preventDefault();
                var cardType1 = $(this).find('.shape-logintype').text().toLowerCase();
                var business_id1 = $(this).find('.shape-id').text();
                var brandid1 = $(this).find('.shape-brandid').text();
                var designationid1 = $(this).find('.shape-designationid').text();
                var roleName = $(this).find('.shape-text').text();
                // Check if business_id1 is not empty or null
                if (business_id1) {
                    $.ajax({
                        url: "{{ route('admin.handleCard') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            card_type2: [cardType1, business_id1, brandid1, designationid1,roleName],
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log(response.root);
                            if (response.root == 'admin') {
                                window.location.href = "{{ url('/dashboard') }}";
                            } else {
                                window.location.href = "{{ url('/login') }}";

                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        </script>
    </body>
@endsection
