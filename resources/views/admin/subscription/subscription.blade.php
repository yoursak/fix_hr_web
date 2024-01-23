@extends('admin.layout.master')
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
@section('contents')
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
                    <div class="">
                        <div class="card">
                            <div class="card-body">
                                <div class="btns mb-5">
                                    <div class="row">
                                        <div class="text-center">
                                            <span class="fs-20 fw-bold">Activate Your FixHR Free Demo</span><br>
                                            <span class="fs-15 text-muted">Your registered Email Id is:<span
                                                    class="text-primary mx-1">{{ $accDetail->business_email
                                                    }}</span></span>
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
                {!! Form::open([
                'url' => route('phonepemode'),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'class' => 'container',
                ]) !!}
                <div class="content mb-5">
                    <div class="btns my-5 ">
                        <div class="row">
                            <div class="text-center">
                                <span class="fs-26 fw-bold">Customize Your FixHR Subscription</span><br>
                                <span class="fs-16 text-muted">Your registered Email Id is:<span
                                        class="text-primary mx-1">{{ $accDetail->business_email }}</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="contents">
                        {{--
                        <a href="javascript:void(0);" class="btn btn-danger btn-icon btn-sm" data-bs-toggle="modal"
                            onclick="openPhonePe(this)" data-id="" data-bs-target="#phonePe">
                            <i class="feather feather-trash-2" data-bs-toggle="tooltip" data-original-title="View"></i>
                        </a> --}}
                        <div class="row">
                            <div class="col-xl-6 mx-auto" style="border:rgb(222,226,230) solid 2px">
                                <div class="d-flex justify-content-center my-5 pb-5">
                                    <ul class="d-flex border border-primary  rounded">
                                        <input type="text" class="plans" name="plan_id" value="1" hidden>
                                        <input type="text" class="base_plans" name="baseplans" value="500" hidden>
                                        <input type="text" class="per_mployee" name="peremployee" value="0" hidden>
                                        <input type="text" class="" name="totalamount" value="0" hidden>

                                        <input type="text" class="additional_mployee" name="additionalemployee"
                                            value="0" hidden>
                                        <input type="text" class="count_mployee" name="countemployee" value="0" hidden>

                                        <li id="monthlyBtn" class="btn rounded selected-plan" value="1"
                                            onclick="changePlan(1)">
                                            <b>Monthly</b>
                                        </li>
                                        <li id="quaterlyBtn" class="btn rounded " value="3" name="quertly"
                                            onclick="changePlan(3)">
                                            <b>Quaterly</b>

                                        </li>
                                        <li id="halfBtn" class="btn rounded " value="6" onclick="changePlan(6)">

                                            <b>Half
                                                Yearly</b>

                                        </li>
                                        <li id="annuallyBtn" class="btn rounded " value="12" onclick="changePlan(12)">

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
                                                                name="addemployeecheck" value="option1" checked>
                                                            <span class="custom-control-label"></span>
                                                        </label>
                                                        <h5 class=" pt-4">Add Aditional Employee :</span>
                                                        </h5>
                                                    </div>
                                                    <div class="add-employee my-3">
                                                        <ul class="rounded text-center mx-5 d-flex" style="width: 7rem">
                                                            <li class="text-primary border my-auto mx-1 "
                                                                onclick="operateEmp('minus')">
                                                                <b><i class="fa fa-minus fs-15"></i></b>
                                                            </li>
                                                            <li class=""><input id="empCount" onchange="operateEmp()"
                                                                    value='0'
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
                                                                class="fa fa-inr"></i> <span id="perEmpPrice">50</span>
                                                            / <span class="forPlan">Monthly</span></h5>
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
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6 offset-3 col-md-offset-6">
                                                <div class="card-default pt-5">
                                                    {{-- <div class="card-header">
                                                        Laravel 8- Razorpay Payment Gateway Integration
                                                    </div> --}}
                                                    <div class="card-body text-center">
                                                        {{-- <a class="btn btn-primary mx-auto" target="_blank">Make
                                                            Payment</a> --}}
                                                        {{-- <form action="/submit_payment" method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="razorpay-payment-button">Submit</button>
                                                            <a href="{{route('phonepemode')}}">Click</a>

                                                        </form> --}}
                                                        <button type="submit" onclick="operateEmp()"
                                                            class="btn btn-primary">Make
                                                            Payment</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex my-5">

                                        {{-- <a class="btn btn-primary mx-auto" href="javascript:void(0);"
                                            style="width: 50%"
                                            onclick="openFloatingWindow('{{ route('phonepe') }}', 500, 900);">Make
                                            Payment</a> --}}

                                        {{-- <a class="btn btn-primary mx-auto" target="_blank"
                                            href="{{ route('phonepe') }}" style="width: 50%">Make Payment</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="card-header border-bottom-0">
                <div class="card-title">
                    Plan Transactions
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap table-striped" id="hr-attendance1">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center border-bottom-0 ">Plan</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">User</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Plan Duration</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Start Date</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">End Date</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Amount</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Upgrade Plan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Free Trial</td>
                                <td>5</td>
                                <td>5 Days</td>
                                <td class="text-center">02-04-2023</td>
                                <td class="text-center">07-04-2023</td>
                                <td class="text-center"><i class="fa fa-inr mx-1"></i>0</td>
                                <td class="text-center"><a href="#" class="btn btn-sm btn-success">Change
                                        Plan</a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="rescalendar" id="my_calendar_en"></div>
            </div>
        </div>
    </div>
</div>

{{-- PhonePe --}}
<div class="modal fade" id="phonePe" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-top  modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <form action="{{ url('response') }}" method="POST">
                @csrf
                <input type="hidden" id="" name="merchantId" value="PGTESTPAYUAT">
                <input type="hidden" id="" name="transactionId" value="JAYANTHEMANTANIKET">
                <div class="modal-body">
                    <iframe id="iframeModalWindow" height="900" width="80%" src="" name="iframe_modal"></iframe>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>

                    <button class="btn btn-primary" type="submit">Ok</button>

                </div>
            </form>
        </div>
    </div>
</div>
{{-- PhonePe --}}

<script>
    function openFloatingWindow(url, width, height) {
            var left = (screen.width - width) / 2;
            var top = (screen.height - height) / 2;
            window.open(url, 'FloatingWindow', 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top);
        }


        var monthlyBtn = document.getElementById('monthlyBtn');
        var quaterlyBtn = document.getElementById('quaterlyBtn');
        var halfBtn = document.getElementById('halfBtn');
        var annuallyBtn = document.getElementById('annuallyBtn');

        var basePlan = document.getElementById('basePlan');
        var forPlan = document.querySelectorAll(".forPlan");
        var perEmpPrice = document.getElementById("perEmpPrice");

        var empCount = document.getElementById('empCount');
        var additionalAmmount = document.getElementById('additionalAmmount');
        var totalPrice = document.getElementById('totalPrice');
        var i = 0;

        var BasePlan = 500;
        var ForPlan = 50;

        function changePlan(plan) {

            $('input[name="plan_id"]').val(plan);
            $('input[name="baseplans"]').val(BasePlan);
            $('input[name="additionalemployee"]').val(empCount);
            $('input[name="countemployee"]').val(i);
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
                $('input[name="halfBtn"]').val('6');

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
                $('input[name="annuallyBtn"]').val('12');

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


        empCount.value=0;
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
            $('input[name="baseplans"]').val(BasePlan);
            $('input[name="countemployee"]').val(i);
            $('input[name="peremployee"]').val(ForPlan);
            $('input[name="additionalemployee"]').val(additionalAmmount.innerHTML);
            $('input[name="totalamount"]').val(totalPrice.innerHTML);

        }

      
</script>
@endsection