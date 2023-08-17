@extends('errors::minimal')
@section('message')
<div class="page responsive-log error-bg1">



    <div class="page-content m-0">
        <div class="container text-center relative">
            <div class="display-1 text-white mb-5 font-weight-semibold"> 5<i class="fa fa-frown-o"></i>3</div>
            <h1 class="h3  mb-3 font-weight-semibold text-white-80">Sorry, an error has occured, Serive Unavaliable </h1>
            <p class="h5 font-weight-normal mb-7 leading-normal text-white-50">You may have mistyped the address or the page may have moved.</p>
            <a class="btn btn-danger" href="index.html"><i class="fe fe-arrow-left-circle me-1"></i>Back to Home</a>
        </div>
    </div>
</div>
@endsection
