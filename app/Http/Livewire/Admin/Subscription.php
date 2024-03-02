<?php

namespace App\Http\Livewire\Admin;

use App\Models\EmployeePersonalDetail;
use App\Models\BusinessDetailsList;
use Livewire\Component;
use Session;
use App\Models\OrdersPayment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Subscription as Subscriptions;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Alert;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Subscription extends Component
{
    use WithFileUploads, WithPagination;

    public $planType;
    protected $listeners = ['upgradePlan'], $tableShows;
    protected $paginationTheme = 'bootstrap';

    public $planTypeName = 'Monthly';
    public $planMothlyValue;

    public $defaultEmployeeCount;
    public $defaultEmployeePrice;

    public $perEmployeeCount;
    public $perEmployeePrice;

    public $additionalEmployeeCount;
    public $additionalEmployeePrice;

    public $totalEmployeeCount;
    public $totalEmployeePrice;

    public $totalEmployee;
    public $businessDetails;
    public $perPage;

    public function mount()
    {
        // default set
        $this->planType = 1;
        $this->planMothlyValue = 500;

        $this->perEmployeeCount = 10;
        $this->perEmployeePrice = 50;

        $this->totalEmployeeCount = 0 + $this->perEmployeeCount;
        $this->totalEmployeePrice = $this->planMothlyValue;

        //   query
        $this->businessDetails = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();
        $this->totalEmployee = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->count();

        $this->additionalEmployeeCount = 0;
        $this->additionalEmployeePrice = 0;
        $this->getData();
    }

    public function additionalAddPlus()
    {
        $this->additionalEmployeeCount++;
        $this->additionalEmployeePrice += 50;
        $this->totalEmployeeCount++;
        $this->totalEmployeePrice = $this->planMothlyValue + $this->additionalEmployeePrice;
    }
    public function additionalAddMinus()
    {
        $this->additionalEmployeeCount > 0 ? $this->additionalEmployeeCount-- : 0;
        $this->additionalEmployeePrice > 0 ? ($this->additionalEmployeePrice -= 50) : 0;

        $this->totalEmployeeCount > 0 ? $this->totalEmployeeCount-- : 0;
        $this->totalEmployeePrice = $this->planMothlyValue + $this->additionalEmployeePrice;
    }

    public function subscriptionchangePlan($value)
    {
        switch ($value) {
                //Monthly
            case 1:
                $this->planTypeName = 'Monthly';
                $this->planType = $value;
                $this->planMothlyValue = 500;
                $this->totalEmployeePrice = $this->planMothlyValue + $this->additionalEmployeePrice;

                break;
                // Quarterly
            case 3:
                $this->planType = $value;
                $this->planTypeName = 'Quarterly';
                $this->planMothlyValue = 500 * 3;

                $this->totalEmployeePrice = $this->planMothlyValue + $this->additionalEmployeePrice;
                break;
                // Half Yearly
            case 6:
                $this->planType = $value;
                $this->planTypeName = 'Half Yearly';
                $this->planMothlyValue = 500 * 6;
                $this->totalEmployeePrice = $this->planMothlyValue + $this->additionalEmployeePrice;

                break;
                //Annually
            case 12:
                $this->planType = $value;
                $this->planTypeName = 'Annually';
                $this->planMothlyValue = 500 * 12;
                $this->totalEmployeePrice = $this->planMothlyValue + $this->additionalEmployeePrice;

                break;
        }
    }

    public function RozaryPay(Request $request)
    {
        // dd($request->all());
        $input = $request->all();
        $api = new Api('rzp_test_dNhHfVpKhFIvFI', 'xvMJygi1384peNtmIIVMF6qc'); //local

        $paymentId = $input['razorpay_payment_id'];
        $payment = $api->payment->fetch($paymentId);
        if (count($input) && !empty($paymentId)) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);
                $node = RulesManagement::GetSubscriptionMode($request->plan_id);
                // $totalEmployee = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->count();
                $GetBusinessDetails = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();

                // dd($payment, $response,  $request->all(), $node[1]['start'], $node[1]['final'], $node[1]['reminder'], Session::all());

                $SubscriptionLevel = new Subscriptions();
                $SubscriptionLevel->order_id = 'FixHR_' . $response['order_id'];
                $SubscriptionLevel->payment_id = $response['id'];
                $SubscriptionLevel->name = $GetBusinessDetails->client_name; // $input['name'];
                $SubscriptionLevel->amount = $payment['amount'] / 100; //total amount
                $SubscriptionLevel->email = $GetBusinessDetails->business_email; // $payment['email'];
                $SubscriptionLevel->phone_no = $GetBusinessDetails->mobile_no; // $payment['contact'];
                $SubscriptionLevel->order_status = $response['status'];
                $SubscriptionLevel->role_id = Session::get('login_role'); //not required
                $SubscriptionLevel->user_type = Session::get('user_type');
                $SubscriptionLevel->business_id = Session::get('business_id'); //not required
                $SubscriptionLevel->total_employee_checked = $request->total_employee;
                $SubscriptionLevel->plan_id = $request->plan_id;
                $SubscriptionLevel->base_plan = $request->baseplans;
                $SubscriptionLevel->per_employee_value = $request->peremployeeCount;
                $SubscriptionLevel->additional_count = $request->countemployee;
                $SubscriptionLevel->additional_employee = $request->additionalemployee;
                $SubscriptionLevel->payment_date = date('Y-m-d'); //pay date
                $SubscriptionLevel->active_status = 1;
                $SubscriptionLevel->cycle_starting = $node[1]['start'];
                $SubscriptionLevel->cycle_expairy = $node[1]['final'];
                $SubscriptionLevel->cycle_remaining = $node[1]['reminder'];
                if ($SubscriptionLevel->save()) {
                    // Session::put('success', 'Payment successful');
                    // return redirect('thankyou/' . $response['id']);
                    Alert::success('', 'Your Payment has been Completed successfully')->persistent(true);

                    // return redirect()->back();
                }
            } catch (Exception $e) {
                Alert::warning('Payment Failed', $e->getMessage())->persistent(true);

                // Session::put('error', $e->getMessage());
            }
        }
        return redirect()->back();
    }

    public function upgradePlan($pID)
    {
        $SUBDATA = Subscriptions::where('business_id', Session::get('business_id'))->where('id', $pID)->first();
        $this->planType = $SUBDATA->plan_id;
        $this->planMothlyValue = $SUBDATA->base_plan;
        $this->additionalEmployeeCount = $SUBDATA->additional_count;
        $this->additionalEmployeePrice = $SUBDATA->additional_employee;
        $this->totalEmployeeCount = $SUBDATA->total_employee_checked;
        $this->totalEmployeePrice = $SUBDATA->amount;
        // $this->subscriptionchangePlan($this->planType);

        // dd($id);
    }
    public function getData()
    {
        $page = $this->perPage != null ? $this->perPage : 10;

        $this->tableShows =  Subscriptions::leftJoin('static_subscription_plan', 'subscription.plan_id', '=', 'static_subscription_plan.id')->where('business_id', Session::get('business_id'))->select('static_subscription_plan.plan_name as planName', 'subscription.*')
            ->paginate($page)
            ->withQueryString();
        return $this->tableShows;
    }
    public function render()
    {
        $subscriptionTable = $this->getData();
        $totalEmployee = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->count();

        // dd($accessPermission);
        $accDetail = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();

        return view('livewire.admin.subscription', compact('accDetail', 'totalEmployee', 'subscriptionTable'));
    }
}
