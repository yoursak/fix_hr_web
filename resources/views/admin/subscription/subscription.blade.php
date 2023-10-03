@extends('admin.layout.master')
@section('title', 'Subscription')
@section('css')
    <style>
        .selected-plan {
            background-color: rgb(1, 33, 105);
            color: aqua;
            transition: 0.9ms
        }

        .selected-plan:hover {
            background-color: rgb(0, 221, 255);
        }
    </style>
@endsection
@section('contents')
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Subscription</div>
            <span class="fs-16 text-muted">Your registered Email Id is: <span class="text-primary"><i
                        class="fa fa-envelope mx-2"></i>mustangsteam@fixhr.com</span></span>
        </div>
        <div class="page-rightheader ms-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <a href="" type="button" class="btn btn-primary">Subscription</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="btns">
            <div class="row">
                <div class="d-flex justify-content-center my-5">
                    <ul class="d-flex bg-light p-2 rounded-pill">
                        <li id="monthlyBtn" class="btn rounded-pill selected-plan" onclick="monthlyBtnfunc()"><b>Monthly</b></li>
                        <li id="quaterlyBtn" class="btn rounded-pill" onclick="quaterlyBtnfunc()"><b>Quaterly</b></li>
                        <li id="halfBtn" class="btn rounded-pill" onclick="halfBtnfunc()"><b>Half Yerly</b></li>
                        <li id="annuallyBtn" class="btn rounded-pill" onclick="annuallyBtnfunc()"><b>Anually</b></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="contents">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="content my-5">
                        <div class="pricings" style="border-bottom: solid 1px grey">
                            <div class="d-flex justify-content-between">
                                <h5>Base Plan (for upto 10 Employees) : </h5>
                                <h5><i class="fa fa-inr mx-2"></i><span>500</span></h5>
                            </div>
                        </div>

                        <div class="additional-employee">
                            <div class="emp-content my-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <label class="custom-control custom-checkbox my-auto">
                                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" checked>
                                            <span class="custom-control-label"></span>
                                        </label>
                                        <h5 class="my-auto">Add Aditional Employee : </h5>
                                        <div class="add-employee">
                                            <ul class="bg-primary rounded-pill text-center mx-3">
                                                <li class="btn text-light" onclick="plusEmp()"><b><i class="fa fa-plus fs-15"></i></b></li>
                                                <li class="btn"><input id="empCount" value='0' class="fs-15 fw-bold text-center" type="text" style="width:3rem"></li>
                                                <li class="btn text-light" onclick="minusEmp()"><b><i class="fa fa-minus fs-15"></i></b></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="additionalAmount">
                                        <h5 class="my-auto"><i class="fa fa-inr mx-2"></i><span id="additionalAmmount">0</span> /-</h5>
                                        {{-- <span class="fs-14 text-muted">Per Employee <i class="fa fa-inr mx-2"></i> 50/month</span> --}}
                                    </div>
                                    <script>
                                        var empCount = document.getElementById('empCount');
                                        var additionalAmmount = document.getElementById('additionalAmmount');
                                        var i = 0;
                                        function plusEmp(){
                                            empCount.value = ++i;
                                            additionalAmmount.innerHTML = ''
                                            additionalAmmount.innerHTML = i*50 ;
                                        }
                                        function minusEmp(){
                                            empCount.value = --i;
                                            additionalAmmount.innerHTML = ''
                                            additionalAmmount.innerHTML = i*50 ;
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var monthlyBtn = document.getElementById('monthlyBtn');
        var quaterlyBtn = document.getElementById('quaterlyBtn');
        var halfBtn = document.getElementById('halfBtn');
        var annuallyBtn = document.getElementById('annuallyBtn');

        function monthlyBtnfunc() {
            // alert('monthlyBtn');
            monthlyBtn.classList.add('selected-plan');
            quaterlyBtn.classList.remove('selected-plan');
            halfBtn.classList.remove('selected-plan');
            annuallyBtn.classList.remove('selected-plan');
        }
        function quaterlyBtnfunc() {
            // alert('quaterlyBtn');
            quaterlyBtn.classList.add('selected-plan');
            monthlyBtn.classList.remove('selected-plan');
            halfBtn.classList.remove('selected-plan');
            annuallyBtn.classList.remove('selected-plan');
        }
        function halfBtnfunc() {
            // alert('halfBtn');
            halfBtn.classList.add('selected-plan');
            monthlyBtn.classList.remove('selected-plan');
            quaterlyBtn.classList.remove('selected-plan');
            annuallyBtn.classList.remove('selected-plan');
        }
        function annuallyBtnfunc() {
            // alert('annuallyBtn');
            annuallyBtn.classList.add('selected-plan');
            monthlyBtn.classList.remove('selected-plan');
            quaterlyBtn.classList.remove('selected-plan');
            halfBtn.classList.remove('selected-plan');
        }
    </script>
@endsection
