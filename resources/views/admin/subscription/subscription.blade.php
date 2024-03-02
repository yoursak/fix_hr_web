@extends('admin.pagelayout.master2')
@section('title', 'Subscription')
@section('title')
    Subscription
@endsection
@section('css')
    <style>
        .selected-plan {
            background-color: rgb(0, 102, 253);
            color: #fff;
            transition: 0.9ms
        }

        .selected-plan:hover {
            color: #fff
        }

        .totalPriceValue {
            padding-top: 2rem;
        }

        .freePlan {
            padding-top: 2rem;
        }

        /* Replace with your desired button color */
        .razorpay-payment-button {
            padding: 5px;
            border-radius: 5px;
            background-color: #1877f2;
            border-color: #1877f2;
            border: none;
            color: white;
        }
    </style>
@endsection
@if (in_array('Subscription.All', $permissions) || in_array('Subscription.View', $permissions))


    @section('content')
        <div class=" p-0 pb-4">
            <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
                <li><a href="{{ url('/admin') }}">Dashboard</a></li>
                {{-- <li><a href="{{ url('/admin/requests/misspunch') }}">Request</a></li> --}}

                <li class="active"><span><b>Subscription</b></span></li>
            </ol>
        </div>

        <div class="modal fade" id="modaldemo8" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Free Demo</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            {{--
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Error!</strong> {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}"
                    role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Success!</strong> {{ $message }}
                </div>
            @endif --}}
            @livewire('admin.subscription')

        </div>
        @php

        @endphp
    @endsection
@endif
