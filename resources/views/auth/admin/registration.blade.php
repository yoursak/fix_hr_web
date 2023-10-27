@extends('auth/admin/authlayout.master')
@section('title', 'Sign Up')
@section('content')
<div class="card">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="card-body">
                <img src="{{ asset('assets/logo/FixHR.png') }}" alt="logo" class="img-fluid mb-4">
                <h1 class="h3  mb-3">Welcome to <span style="color: black"><b>Fix<span
                                style="color: #1877F2">HR</span></b></span></h1>
                <p class="h5 font-weight-normal mb-4 leading-normal">Make Your Human Resource Online</p>
                <h4 class="mb-3 f-w-400" ><b> Sign Up</b></h4>
                <form method="POST" action="{{ route('businessVerify')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Enter Your Email ID" required>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary mb-4 rounded"
                        style="background-color:#1877F2">Send OTP</button>
                </form>
                <p class="mb-0 text-muted">Already have an account? <a href="{{url('/login')}}" class="f-w-400" style="color:#1877F2">Sign
                        In</a></p>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <div class="saprator my-2"><span>OR</span></div>
    <button class="btn text-white bg-facebook mb-2 mr-2  wid-40 px-0 hei-40 rounded-circle"><i
            class="fab fa-facebook-f"></i></button>
    <button class="btn text-white bg-googleplus mb-2 mr-2 wid-40 px-0 hei-40 rounded-circle"><i
            class="fab fa-google-plus-g"></i></button>
    <button class="btn text-white bg-twitter mb-2  wid-40 px-0 hei-40 rounded-circle"><i
            class="fab fa-twitter"></i></button>
</div>


@endsection