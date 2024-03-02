<div>
    <div class="card" wire:ignore.self>
        {{-- Livewire --}}
        <div class="card-body">
            <form id='formId' action="{{ route('rozarpaymode') }}" method="POST">
                @csrf
                <div class="content mb-5">
                    <div class="btns my-5 ">
                        <div class="row">
                            <div class="text-center">
                                <span class="fs-26 fw-bold">Customize Your FixHR Subscription</span><br>
                                <span class="fs-16 text-muted">Your registered Email Id is:
                                    {{ $businessDetails->business_email }}
                                    <span class="text-primary mx-1"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="contents">

                        <div class="row">
                            <div class="col-xl-6 mx-auto" style="border:rgb(222,226,230) solid 2px">
                                <div class="d-flex justify-content-center my-5 pb-5">
                                    <ul class=" border border-primary  rounded">
                                        <input type="text" class="plans" name="plan_id" value="{{ $planType }}"
                                            hidden>
                                        <input type="text" class="base_plans" name="baseplans"
                                            value="{{ $planMothlyValue }}" hidden>
                                        <input type="text" class="" name="peremployee"
                                            value="{{ $perEmployeePrice }}" hidden>
                                        <input type="text" class="" name="peremployeeCount"
                                            value="{{ $perEmployeeCount }}" hidden>
                                        <input type="text" class="" name="totalamount"
                                            value="{{ $totalEmployeePrice }}" hidden>
                                        <input type="text" class="additional_mployee" name="additionalemployee"
                                            value="{{ $additionalEmployeePrice }}" hidden>
                                        <input type="text" class="count_mployee" name="countemployee"
                                            value="{{ $additionalEmployeeCount }}" hidden>

                                        <li id="monthlyBtn"
                                            class="btn rounded <?= $planType == 1 ? 'selected-plan' : '' ?>"
                                            value="1" wire:model="planType" wire:click="subscriptionchangePlan(1)">
                                            <b>Monthly</b>
                                        </li>
                                        <li id="quaterlyBtn"
                                            class="btn rounded <?= $planType == 3 ? 'selected-plan' : '' ?>"
                                            value="3" wire:model="planType" wire:click="subscriptionchangePlan(3)">
                                            <b>Quarterly</b>

                                        </li>
                                        <li id="halfBtn"
                                            class="btn rounded <?= $planType == 6 ? 'selected-plan' : '' ?>"
                                            value="6" wire:model="planType" wire:click="subscriptionchangePlan(6)">

                                            <b>Half Yearly</b>

                                        </li>
                                        <li id="annuallyBtn"
                                            class="btn rounded <?= $planType == 12 ? 'selected-plan' : '' ?>"
                                            value="12" wire:model="planType"
                                            wire:click="subscriptionchangePlan(12)">

                                            <b>Annually</b>
                                        </li>
                                    </ul>
                                </div>
                                <div class="content my-5 mx-4">
                                    <div class="pricings" style="border-bottom: solid 1px rgb(222,226,230)">
                                        <div class="d-flex justify-content-between">
                                            <p>Base Plan (for upto 10 Employees) : </p>
                                            <h5 class=" text-end"><i class="fa fa-inr mx-2"></i><span class="ms-auto"
                                                    id="basePlan">
                                                    {{ $planMothlyValue }} {{-- //500  Montly --}}
                                                </span><br><span class="text-muted fs-12 fw-light">For <span
                                                        class="forPlan">{{ $planTypeName }}</span></span></h5>
                                        </div>
                                    </div>

                                    <div class="additional-employee mb-5">
                                        <div class="emp-content my-3">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-block d-xl-flex">
                                                    <div class="d-flex">
                                                        <h5 class=" pt-4">Add Additional Employee :</span>
                                                        </h5>
                                                    </div>
                                                    <div class="add-employee my-3">
                                                        <ul class="rounded text-center mx-5 d-flex" style="width: 7rem">
                                                            <li class="text-primary border my-auto mx-1 "
                                                                wire:click="additionalAddMinus()">
                                                                <b><i class="fa fa-minus fs-15"></i></b>
                                                            </li>
                                                            <li class="">
                                                                {{-- <input type="text" name="tempEmployeeCount"
                                                                    value="{{ $additionalEmployeeCount }}"> --}}
                                                                <input id="exactEmpCount" name="tempEmployeeCount"
                                                                    wire:model="additionalEmployeeCount" value="0"
                                                                    class="fs-15 fw-bold text-center border border-primary border-0 py-1"
                                                                    type="text" style="width:3rem">
                                                            </li>
                                                            <li class="text-primary border border-5 my-auto mx-1 "
                                                                wire:click="additionalAddPlus()"><b><i
                                                                        class="fa fa-plus fs-15"></i></b></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="additionalAmount mt-4 text-end">
                                                    <h5 class="my-auto"><i
                                                            class="fa fa-inr mx-2"></i><span>{{ $additionalEmployeePrice }}
                                                            {{-- 0  id="additionalAmmount" --}}
                                                        </span><br><span class="text-muted fs-12 fw-light">Per Employee
                                                            <i class="fa fa-inr"></i> <span>{{ $perEmployeePrice }}
                                                                {{-- //50  id="perEmpPrice" --}}
                                                            </span>
                                                            / <span class="forPlan">{{ $planTypeName }}
                                                                {{-- Monthly --}}
                                                            </span></h5>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="pricings mt-5 totalPriceValue"
                                        style="border-bottom: solid 1px rgb(222,226,230);">
                                        <div class="d-flex justify-content-between">
                                            <h5>Total Price : <br><span class="text-muted fs-12 fw-light">For
                                                    upto
                                                    {{ $totalEmployeeCount }}
                                                    Employee <span class="forPlan">Monthly</span> </span></h5>
                                            <h5 class="text-end"><i
                                                    class="fa fa-inr mx-2"></i><span>{{ $totalEmployeePrice }}
                                                    {{-- 500 --}}
                                                </span><br><span class="text-muted fs-12 fw-light">(Inclusive of All
                                                    Taxes)</span>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6 offset-3 col-md-offset-6">
                                                <div class="card-default pt-5">

                                                    <div class="card-body text-center">

                                                        {{-- @if (in_array('Subscription.Create', $permissions)) --}}
                                                        <button type='submit' class="btn btn-primary"
                                                            id='customRazorpayButton'>
                                                            Make
                                                            Payment
                                                        </button>
                                                        {{-- @endif --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <b>{{ $totalEmployee }}</b> --}}
                                    <p><span style="color: red">Note</span>: Active Employee in Your Current
                                        Business Subscription Plan is <b>{{ $totalEmployee }}</b> . You cannot
                                        submit an
                                        amount below the last activated Subscription Plan.</p>
                                    <div class="d-flex my-5">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- {{ $totalEmployee }} --}}
                <input type="text" id="match_employee_runttime" value="{{ $totalEmployeeCount }}" hidden>
                <input name="razorpay_payment_id" id="razorpay_payment_id" hidden>
                <input name="total_employee" id="totalEmployee" value="{{ $totalEmployee }}" hidden>
                <input type="text" id="totalPrice" value="{{ $totalEmployeePrice }}" hidden>

            </form>


        </div>

        <div class="modal fade" id="pleaseWaitModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <p>Please wait while we process your payment...</p>
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="">

        <div class="card">

            <div class="card-header border-bottom-0">
                <div class="card-title">
                    Plan Transactions
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap  border-bottom ">
                        <thead>
                            <tr>
                                <th class="text-center border-bottom-0">Payment ID</th>
                                {{-- <th class="text-center border-bottom-0">User</th> --}}
                                <td class="text-center border-bottom-0">User Type</td>
                                <th class="text-center border-bottom-0">Total Employee</th>
                                <th class="text-center border-bottom-0">additional added </th>
                                <th class="text-center border-bottom-0">Plan</th>
                                <th class="text-center border-bottom-0">Payment Date</th>
                                <th class="text-center border-bottom-0">Start Date</th>
                                <th class="text-center border-bottom-0">End Date</th>
                                <th class="text-center border-bottom-0">Amount</th>
                                <th class="text-center border-bottom-0">Status</th>
                                <th class="text-center border-bottom-0 ">Upgrade Plan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptionTable as $item)
                                <tr>

                                    <td class="text-center border-bottom-0">{{ $item->payment_id }}</td>

                                    {{-- <td class="text-center border-bottom-0">{{ $item->name }}</td> --}}

                                    <td class="text-center border-bottom-0">{{ $item->user_type }}</td>
                                    <th class="text-center border-bottom-0">{{ $item->total_employee_checked }}</th>

                                    <th class="text-center border-bottom-0">{{ $item->additional_count }}</th>

                                    <td class="text-center border-bottom-0">{{ $item->planName }}</td>
                                    <td class="text-center border-bottom-0">
                                        {{ date('d-m-Y', strtotime($item->payment_date)) }}</td>
                                    <td class="text-center border-bottom-0">
                                        {{ date('d-m-Y', strtotime($item->cycle_starting)) }}</td>
                                    <td class="text-center border-bottom-0">
                                        {{ date('d-m-Y', strtotime($item->cycle_expairy)) }}</td>
                                    <td class="text-center border-bottom-0">{{ $item->amount }}</td>
                                    <td class="text-center border-bottom-0">
                                        <div class="tags">
                                            <span
                                                class="tag <?= $item->active_status == 1 ? 'tag-green' : 'tag-red' ?> ">{{ $item->order_status }}</span>
                                        </div>
                                    </td>


                                    <td class="text-center border-bottom-0"><button type="submit"
                                            wire:click="upgradePlan({{ $item->id }})"
                                            class="btn btn-sm btn-primary modal-effect">Upgrade</button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        {{-- <label for="perPage">Per Page:</label> --}}

                        <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                            <div class="input-group">
                                <select wire:model.debounce.350ms="perPage" class="form-control"
                                    x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i x-show="isOpen" class="fa fa-caret-up"></i>
                                        <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <select wire:model.debounce.350ms="perPage" id=""
                        class="form-control   custom-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select> --}}

                    </div>

                    <div>
                        {!! $subscriptionTable->links() !!}
                    </div>
                </div>
                <div class="rescalendar" id="my_calendar_en"></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        function validateForm() {
            var form = document.getElementById('formId');
            let exactEmpCount = $('#match_employee_runttime').val(); //$('#exactEmpCount').val();
            let totalEmployee = $('#totalEmployee').val();
            console.log(exactEmpCount);
            var isValid = true;
            console.log(totalEmployee, exactEmpCount);
            if (exactEmpCount == 0 || exactEmpCount == null) {
                isValid = false;
                Swal.fire({
                    timer: 5000,
                    text: 'Invailed Employee Count !',
                    timerProgressBar: true,
                    title: '',
                    icon: 'warning',
                    closeModal: true,

                })
            }
            if (exactEmpCount >= totalEmployee && exactEmpCount != 0 && exactEmpCount != null) {
                isValid = true;

                // alert(totalEmployee + 'Total Employee Count !');

            } else {
                Swal.fire({
                    timer: 5000,
                    text: "Number of employee can't be less then previous added employee count",
                    timerProgressBar: true,
                    title: '',
                    icon: 'warning',
                    closeModal: true,

                })
                isValid = false;
                console.log(exactEmpCount.innerHTML);

            }

            return isValid;
        }

        function showPleaseWaitModal() {
            $('#pleaseWaitModal').modal('show');
        }
        var options = {
            key: "rzp_test_dNhHfVpKhFIvFI", // Paste your API key here before clicking on the Pay Button.
            amount: 0, // Initialize amount with 0
            currency: 'INR',
            name: "FixHR",
            description: "Subscription Plan",
            image: "{{ asset('business_logo/' . session('login_business_image')) }}",
            prefill: {
                "name": "{{ session('login_name') }}",
                "email": "{{ session('email') }}"
            },
            theme: {
                "color": "#1877F2"
            },
            handler: function(response) {
                if (response.razorpay_payment_id) {
                    showPleaseWaitModal();
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    // document.getElementById('razorpay_per_employee').value = document.getElementById('exactEmpCount')
                    //     .innerHTML;
                    document.getElementById('formId').submit();
                } else {
                    alert('Something Went Wrong !! Try Again..');
                }
            },
            notes: {
                address: "India"
            }
        };

        var rzp1 = new Razorpay(options);
        document.getElementById('customRazorpayButton').addEventListener('click', function(e) {
            console.log("ASDfasdfasdfdsf");
            if (validateForm()) {
                var subTotalValue = $('#totalPrice').val();
                console.log(subTotalValue);
                var newAmount = subTotalValue * 100;
                if (rzp1) {
                    rzp1 = null;
                }
                // Create a new instance of Razorpay with the updated amount
                var rzpOptionsUpdated = {
                    ...options
                }; // Clone the original options object
                rzpOptionsUpdated.amount = newAmount;
                rzp1 = new Razorpay(rzpOptionsUpdated);

                rzp1.open();
            }
            e.preventDefault();
        });
        // Handle cancellation and reset rzp1 instance
        window.addEventListener('unload', function() {
            if (rzp1) {
                rzp1 = null;
            }
        });
    </script>

</div>
