@extends('admin.setupLayout.master')
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
    </style>
@endsection
@section('content')
<div class="iniitial-header m-5">
    <h2><b>FixingDots Pvt.Ltd</b></h2>
    <span class="fs-16">
        <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Account Setting<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Business Setting<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Attendance Setting<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class=""><i class="fa fa-check-circle mx-2 text-primary"></i>Setup Activation<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class=""><i class="fa fa-circle mx-2 text-primary"></i>Subscription<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class="text-muted"><i class="fa fa-circle mx-2"></i>Add Employee<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
        <span class="text-muted"><i class="fa fa-circle mx-2"></i>Finish<i
                class="fa fa-angle-right my-auto mx-2"></i></span>
    </span>
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
                        <div class="">
                            <div class="card">
                                <div class="card-body">
                                    <div class="btns mb-5">
                                        <div class="row">
                                            <div class="text-center">
                                                <span class="fs-20 fw-bold">Activate Your FixHR Free Demo</span><br>
                                                <span class="fs-15 text-muted">Your registered Email Id is:<span
                                                        class="text-primary mx-1">mustangsteam@fixhr.com</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contents mt-5">
                                        <div class="" style="margin-top: 3rem">
                                            <div class="content my-5">
                                                <div class="pricings">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="text-start">
                                                            <span class="me-auto fs-16 fw-bold">Free Plan : </span>
                                                            <br><span class=" fs-12">For upto 5 Employee for 5 Days</span>
                                                        </div>
                                                        <h5 class=""><i class="fa fa-inr"></i><span>0</span></h5>
                                                    </div>
                                                </div>

                                                <div class="pricings freePlan mt-5">
                                                    <div class="d-flex justify-content-between py-2"
                                                        style="border-top: solid 1px rgb(222,226,230)">
                                                        <h5>Total Price :</h5>
                                                        <h5 class="text-end "><i
                                                                class="fa fa-inr mx-2"></i><span>0</span><br><span
                                                                class="text-muted fs-12 fw-light">(Inclusive of All
                                                                Texes)</span></h5>
                                                    </div>
                                                </div>
                                                <div class="text-start">
                                                    <span class="fs-12 text-danger">Note-Your free plan will get expire
                                                        after 5 days</span>
                                                </div>
                                                <div class="d-flex mt-5">
                                                    <a class="btn btn-primary mx-auto" style="width: 50%">Activate Demo</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="">
            <div class="card">
                <div class="card-body">
                    <div class="content mb-5">
                        <div class="btns my-5 ">
                            <div class="row">
                                <div class="text-center">
                                    <span class="fs-26 fw-bold">Customize Your FixHR Subscription</span><br>
                                    <span class="fs-16 text-muted">Your registered Email Id is:<span
                                            class="text-primary mx-1">mustangsteam@fixhr.com</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="contents">
                            <div class="row">
                                <div class="col-xl-6 mx-auto" style="border:rgb(222,226,230) solid 2px">
                                    <div class="d-flex justify-content-center my-5 pb-5">
                                        <ul class="d-flex border border-primary  rounded">
                                            <li id="monthlyBtn" class="btn rounded selected-plan" onclick="changePlan(1)">
                                                <b>Monthly</b>
                                            </li>
                                            <li id="quaterlyBtn" class="btn rounded " onclick="changePlan(3)">
                                                <b>Quaterly</b>
                                            </li>
                                            <li id="halfBtn" class="btn rounded " onclick="changePlan(6)"><b>Half
                                                    Yearly</b></li>
                                            <li id="annuallyBtn" class="btn rounded " onclick="changePlan(12)">
                                                <b>Anually</b>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="content my-5 mx-4">
                                        <div class="pricings" style="border-bottom: solid 1px rgb(222,226,230)">
                                            <div class="d-flex justify-content-between">
                                                <p>Base Plan (for upto 10 Employees) : </p>
                                                <h5 class=" text-end"><i class="fa fa-inr mx-2"></i><span class="ms-auto"
                                                        id="basePlan">500</span><br><span
                                                        class="text-muted fs-12 fw-light">For <span
                                                            class="forPlan">Montly</span></span></h5>
                                            </div>
                                        </div>

                                        <div class="additional-employee mb-5">
                                            <div class="emp-content my-3">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-block d-xl-flex">
                                                        <div class="d-flex">
                                                            <label class="custom-control custom-checkbox mt-3">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="example-checkbox1" value="option1" checked>
                                                                <span class="custom-control-label"></span>
                                                            </label>
                                                            <h5 class=" pt-4">Add Aditional Employee :</span>
                                                            </h5>
                                                        </div>
                                                        <div class="add-employee my-3">
                                                            <ul class="rounded text-center mx-5 d-flex"
                                                                style="width: 7rem">
                                                                <li class="text-primary border my-auto mx-1 "
                                                                    onclick="operateEmp('minus')">
                                                                    <b><i class="fa fa-minus fs-15"></i></b>
                                                                </li>
                                                                <li class=""><input id="empCount"
                                                                        onchange="operateEmp()" value='0'
                                                                        class="fs-15 fw-bold text-center border border-primary border-0 py-1"
                                                                        type="text" style="width:3rem"></li>
                                                                <li class="text-primary border border-5 my-auto mx-1 "
                                                                    onclick="operateEmp('plus')"><b><i
                                                                            class="fa fa-plus fs-15"></i></b></li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="additionalAmount mt-4 text-end">
                                                        <h5 class="my-auto"><i class="fa fa-inr mx-2"></i><span
                                                                id="additionalAmmount">0</span><br><span
                                                                class="text-muted fs-12 fw-light">Per Employee <i
                                                                    class="fa fa-inr"></i> <span
                                                                    id="perEmpPrice">50</span> / <span
                                                                    class="forPlan">Monthly</span></h5>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="pricings mt-5 totalPriceValue"
                                            style="border-bottom: solid 1px rgb(222,226,230);">
                                            <div class="d-flex justify-content-between">
                                                <h5>Total Price : <br><span class="text-muted fs-12 fw-light">For upto 10
                                                        Employee <span class="forPlan">Monthly</span> </span></h5>
                                                <h5 class="text-end"><i class="fa fa-inr mx-2"></i><span
                                                        id="totalPrice">500</span><br><span
                                                        class="text-muted fs-12 fw-light">(Inclusive of All Taxes)</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex my-5">
                                            <a href="{{url('setup/employee')}}" class="btn btn-primary mx-auto" style="width: 50%">Make Payment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div>
            <a href="{{ url('/setup/set-all-mode') }}" class="btn btn-primary">Previous</a>
        </div>

        <div class="">
            <a href="{{ url('/setup/employee') }}" class="btn btn-primary">save & continoue</a>
        </div>
    </div>

    <script>
        var monthlyBtn = document.getElementById('monthlyBtn');
        var quaterlyBtn = document.getElementById('quaterlyBtn');
        var halfBtn = document.getElementById('halfBtn');
        var annuallyBtn = document.getElementById('annuallyBtn');

        var basePlan = document.getElementById('basePlan');
        var forPlan = document.querySelectorAll(".forPlan");
        var perEmpPrice = document.getElementById("perEmpPrice");

        var empCount = document.getElementById('empCount');
        var additionalAmmount = document.getElementById('additionalAmmount');
        var additionalAmmount = document.getElementById('additionalAmmount');
        var totalPrice = document.getElementById('totalPrice');
        var i = 0;

        var BasePlan = 500;
        var ForPlan = 50;

        function changePlan(plan) {

            // console.log(forPlan);
            if (plan == 1) {
                monthlyBtn.classList.add('selected-plan');
                quaterlyBtn.classList.remove('selected-plan');
                halfBtn.classList.remove('selected-plan');
                annuallyBtn.classList.remove('selected-plan');
                basePlan.innerHTML = '';
                BasePlan = 500 * plan;
                ForPlan = 50 * plan;
                perEmpPrice.innerHTML = ForPlan;
                basePlan.innerHTML = BasePlan;

                forPlan.forEach(element => {
                    element.innerHTML = '';
                    element.innerHTML = 'Monthly';
                });
            } else if (plan == 3) {
                quaterlyBtn.classList.add('selected-plan');
                monthlyBtn.classList.remove('selected-plan');
                halfBtn.classList.remove('selected-plan');
                annuallyBtn.classList.remove('selected-plan');
                basePlan.innerHTML = '';
                BasePlan = 500 * plan;
                ForPlan = 50 * plan;
                perEmpPrice.innerHTML = ForPlan;
                basePlan.innerHTML = BasePlan;
                forPlan.forEach(element => {
                    element.innerHTML = '';
                    element.innerHTML = 'Quaterly';
                });
            } else if (plan == 6) {
                halfBtn.classList.add('selected-plan');
                monthlyBtn.classList.remove('selected-plan');
                quaterlyBtn.classList.remove('selected-plan');
                annuallyBtn.classList.remove('selected-plan');
                basePlan.innerHTML = '';
                BasePlan = 500 * plan;
                ForPlan = 50 * plan;
                perEmpPrice.innerHTML = ForPlan;
                basePlan.innerHTML = BasePlan;
                forPlan.forEach(element => {
                    element.innerHTML = '';
                    element.innerHTML = 'Half Yearly';
                });
            } else if (plan == 12) {
                annuallyBtn.classList.add('selected-plan');
                monthlyBtn.classList.remove('selected-plan');
                quaterlyBtn.classList.remove('selected-plan');
                halfBtn.classList.remove('selected-plan');
                basePlan.innerHTML = '';
                BasePlan = 500 * plan;
                ForPlan = 50 * plan;
                perEmpPrice.innerHTML = ForPlan;
                basePlan.innerHTML = BasePlan;
                forPlan.forEach(element => {
                    element.innerHTML = '';
                    element.innerHTML = 'Anually';
                });
            }
            operateEmp(basePlan)
        }



        function operateEmp(operation) {
            if (operation == 'plus') {
                empCount.value = ++i;
            }

            if (operation == 'minus') {
                if (i == 0) {
                    empCount.value = 0;
                } else {
                    empCount.value = --i;
                }
            }
            additionalAmmount.innerHTML = ''
            totalPrice.innerHTML = ''
            additionalAmmount.innerHTML = i * ForPlan;
            totalPrice.innerHTML = i * ForPlan + BasePlan;


        }
    </script>
@endsection
