<?php

namespace App\Http\Controllers\paymentGateway;

use Razorpay\Api\Api;
// use Session;
use Exception;
use App\Http\Controllers\Controller;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Alert;
use Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Encryption\Encrypter;
use App\Models\BusinessDetailsList;
use App\Models\Subscription;
use App\Models\SubscriptionModel;

class PhonepeController extends Controller
{
    // Fully Set Customized By Jayant
    // protected $MERCHANT_ID;
    // protected $MERCHANT_USER_ID;
    // protected $MERCHANT_Transaction_ID;
    // protected $SALT_KEY;
    // protected $SALT_INDEX;
    // protected $PhonepePaymentURL;
    // protected $PhonepePaymentStatus;
    // protected $HeadersSupport;
    // protected $AmountStandard;
    public function __construct()
    {
        // $PHONEPE_MERCHANT_ID = env('PHONEPE_MERCHANT_ID');
        // $PHONEPE_MERCHANT_USER_ID = env('PHONEPE_MERCHANT_USER_ID');
        // $PHONEPE_MERCHANT_Transaction_ID = uniqid();
        // $PHONEPE_SALT_KEY = env('PHONEPE_SALT_KEY');
        // $PHONEPE_SALT_INDEX = env('PHONEPE_SALT_INDEX');
        // $PHONEPE_Submit_Payment = "https://api.phonepe.com/apis/hermes/pg/v1/pay";
        // $PHONEPE_Status_Payment = "https://api.phonepe.com/apis/hermes/pg/v1/status/";
        // $PHONEPE_MERCHANT_ID = 'PGTESTPAYUAT'; // env('PHONEPE_MERCHANT_ID');
        // $PHONEPE_MERCHANT_USER_ID = 'PGTESTPAYUAT'; //env('PHONEPE_MERCHANT_USER_ID');
        // $PHONEPE_MERCHANT_Transaction_ID = uniqid();
        // $PHONEPE_SALT_KEY = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399'; // env('PHONEPE_SALT_KEY');
        // $PHONEPE_SALT_INDEX = 1; // env('PHONEPE_SALT_INDEX');
        // $PHONEPE_Submit_Payment = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";
        // $PHONEPE_Status_Payment = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/";
        // $PHONEPE_HEADER_Use = [
        //     'Content-Type:application/json',
        //     'accept:application/json'
        // ];

        // $PHONEPE_MERCHANT_ID = 'M1USSWJDI3JJ'; // env('PHONEPE_MERCHANT_ID');
        // $PHONEPE_MERCHANT_USER_ID = 'M1USSWJDI3JJ'; //env('PHONEPE_MERCHANT_USER_ID');
        // $PHONEPE_MERCHANT_Transaction_ID = uniqid();
        // $PHONEPE_SALT_KEY = '9df39854-1c4b-46cd-876e-8e34014a5f10'; // env('PHONEPE_SALT_KEY');
        // $PHONEPE_SALT_INDEX = 1; // env('PHONEPE_SALT_INDEX');
        // $PHONEPE_Submit_Payment = "https://api.phonepe.com/apis/hermes/pg/v1/pay";
        // $PHONEPE_Status_Payment = "https://api.phonepe.com/apis/hermes/pg/v1/status/";
        // $PHONEPE_HEADER_Use = [
        //     'Content-Type:application/json',
        //     'accept:application/json'
        // ];

        // // variable assign process
        // $this->MERCHANT_Transaction_ID = $PHONEPE_MERCHANT_Transaction_ID;
        // $this->MERCHANT_ID = $PHONEPE_MERCHANT_ID;
        // $this->MERCHANT_USER_ID = $PHONEPE_MERCHANT_USER_ID;
        // $this->SALT_KEY = $PHONEPE_SALT_KEY;
        // $this->SALT_INDEX = $PHONEPE_SALT_INDEX;
        // $this->PhonepePaymentURL = $PHONEPE_Submit_Payment; // MODE Payment Submit Data
        // $this->PhonepePaymentStatus = $PHONEPE_Status_Payment;
        // $this->HeadersSupport = $PHONEPE_HEADER_Use;
        // $this->AmountStandard = 100;

        //    dd($PHONEPE_MERCHANT_ID);
    }
    public function PP(Request $request)
    {

    }
    public function razorpayIndex()
    {
        return view('razorpayView');
    }
    public function nodeMode()
    {

        $data = array(
            'merchantId' => 'M1USSWJDI3JJ',
            'merchantTransactionId' => uniqid(),
            'merchantUserId' => 'MUID123',
            'amount' => 10,
            'redirectUrl' => route('response'),
            'redirectMode' => 'POST',
            'callbackUrl' => route('response'),
            'mobileNumber' => '9999999999',
            'paymentInstrument' =>
                array(
                    'type' => 'PAY_PAGE',
                ),

        );

        $encode = base64_encode(json_encode($data));

        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);

        $finalXHeader = $sha256 . '###' . $saltIndex;

        $url = " https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";

        $response = Curl::to($url)
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();

        $rData = json_decode($response);

        return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);

    }
    // Request Make Payment
    public function phonePe(Request $request)
    {
        $data = array(
            'merchantId' => 'PGTESTPAYUAT',
            'merchantTransactionId' => uniqid(),
            'merchantUserId' => 'MUID123',
            'amount' => 10,
            'redirectUrl' => route('response'),
            'redirectMode' => 'POST',
            'callbackUrl' => route('response'),
            'mobileNumber' => '9999999999',
            'paymentInstrument' =>
                array(
                    'type' => 'PAY_PAGE',
                ),
        );

        $encode = base64_encode(json_encode($data));

        $saltKey = '9df39854-1c4b-46cd-876e-8e34014a5f10';
        $saltIndex = 1;

        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);

        $finalXHeader = $sha256 . '###' . $saltIndex;

        $url = "https://api.phonepe.com/apis/hermes/pg/v1/pay";

        $response = Curl::to($url)
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();

        $rData = json_decode($response);

        return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
    }

    public function response(Request $request)
    {
        $input = $request->all();
        dd($input);

        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $finalXHeader = hash('sha256', '/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'] . $saltKey) . '###' . $saltIndex;

        $response = Curl::to(' https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'])
            ->withHeader('Content-Type:application/json')
            ->withHeader('accept:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withHeader('X-MERCHANT-ID:' . $input['transactionId'])
            ->get();

        dd(json_decode($response));
    }
    // public function phonePe(Request $request)
    // {
    //     $planID = $request->plan_id;
    //     $basePlans = $request->baseplans;
    //     $perEmployee = $request->peremployee;
    //     $additionalEmployee = $request->additionalemployee;
    //     $countEmployee = $request->countemployee;
    //     $totalAmount = $request->totalamount;

    //     // if ($planID != null && $basePlans != null && $perEmployee != null && $additionalEmployee != null && $countEmployee != null && Session::get('business_id') != null) {
    //     //     $Collections = ['user_type' => Session::get('user_type'), 'business_id' => Session::get('business_id'), 'branch_id' => Session::get('branch_id'), 'model_id' => Session::get('model_id'), 'login_role' => Session::get('login_role'), 'login_name' => Session::get('login_name'), 'login_email' => Session::get('login_email'), 'login_business_image' => Session::get('login_business_image'), 'login_emp_id' => Session::get('login_emp_id')];
    //     //     $Package = ['plan_id' => $planID, 'base_plan' => $basePlans, 'additional_employee' => $additionalEmployee, 'additional_count' => $countEmployee];
    //     //     $GetBusinessDetails = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();


    //     //     $LogInCollectionEncrypted1List = Crypt::encryptString(json_encode($Collections));
    //     //     $LoginCollectionEncrypted2List = Crypt::encryptString(json_encode($Package));

    //     $data = array(
    //         'merchantId' => 'M1USSWJDI3JJ',
    //         'merchantTransactionId' => uniqid(),
    //         'merchantUserId' => 'MUID123',
    //         'amount' => 10,
    //         'redirectUrl' => route('response'),
    //         'redirectMode' => 'POST',
    //         'callbackUrl' => route('response'),
    //         'mobileNumber' => '9999999999',
    //         'paymentInstrument' =>
    //             array(
    //                 'type' => 'PAY_PAGE',
    //             ),
    //     );
    //     $encode = base64_encode(json_encode($data));

    //     $saltKey = '9df39854-1c4b-46cd-876e-8e34014a5f10';
    //     $saltIndex = 1;

    //     $string = $encode . '/pg/v1/pay' . $saltKey;
    //     $sha256 = hash('sha256', $string);

    //     $finalXHeader = $sha256 . '###' . $saltIndex;

    //     $url = "https://api.phonepe.com/apis/hermes/pg/v1/pay";

    //     $response = Curl::to($url)
    //         ->withHeader('Content-Type:application/json')
    //         ->withHeader('X-VERIFY:' . $finalXHeader)
    //         ->withData(json_encode(['request' => $encode]))
    //         ->post();

    //     $rData = json_decode($response);

    //     return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
    //     // }
    // }

    // // Response Handler
    // public function responseSubmit(Request $request)
    // {
    //     $input = $request->all();
    //     dd($input);

    //     $saltKey = $this->SALT_KEY; // '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
    //     $saltIndex = $this->SALT_INDEX; //1
    //     $decrypted1List = Crypt::decryptString($request->collection);
    //     $decrypted2List = Crypt::decryptString($request->package);

    //     $finalXHeader = hash('sha256', '/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'] . $saltKey) . '###' . $saltIndex;
    //     $Response = Curl::to('https://api.phonepe.com/apis/hermes/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'])
    //         ->withHeader('Content-Type:application/json')
    //         ->withHeader('accept:application/json')
    //         ->withHeader('X-VERIFY:' . $finalXHeader)
    //         ->withHeader('X-MERCHANT-ID:' . $input['transactionId'])
    //         ->get();
    //     $GetResponse = json_decode($Response);
    //     $modeLoad1 = RulesManagement::callReloadStep1SessionData($decrypted1List); //return value
    //     $modeLoad2 = json_decode($decrypted2List);
    //     $SelfStore = RulesManagement::callReloadStep2SessionData();
    //     $GetBusinessDetails = BusinessDetailsList::where('business_id', $modeLoad1['business_id'])->first();

    //     if ($GetResponse != null && $decrypted2List != null && $decrypted1List != null) {

    //         // Success Payment
    //         if ($GetResponse->success != false) {
    //             // dd($GetResponse->code);
    //             // dd($modeLoad2);
    //             // dd($GetResponse->data->merchantId);
    //             // dd($GetResponse->data->merchantTransactionId);
    //             // dd($GetResponse->data->transactionId);
    //             // dd($GetResponse->data->amount/$this->AmountStandard);
    //             // dd($GetResponse->data->state);
    //             // dd($GetResponse->data->responseCode);
    //             // dd($GetResponse->data->paymentInstrument);
    //             // dd($GetResponse->data->paymentInstrument->type);

    //             // 'login_role' => $modeLoad1['login_role'],
    //             // 'login_emp_id' => $modeLoad1['login_emp_id'],

    //             $node = RulesManagement::GetSubscriptionMode($modeLoad2->plan_id);
    //             $store = [
    //                 'business_id' => $GetBusinessDetails->business_id,
    //                 'user_type' => $modeLoad1['user_type'],
    //                 'model_id' => $modeLoad1['model_id'],
    //                 'name' => $GetBusinessDetails->client_name,
    //                 'email' => $GetBusinessDetails->business_email,
    //                 'phone_no' => $GetBusinessDetails->mobile_no,
    //                 'plan_id' => $modeLoad2->plan_id,
    //                 'base_plan' => $modeLoad2->base_plan,
    //                 'additional_employee' => $modeLoad2->additional_employee,
    //                 'additional_count' => $modeLoad2->additional_count,
    //                 'payment_code' => $GetResponse->code,
    //                 'payment_merchant_id' => $GetResponse->data->merchantId,
    //                 'payment_merchant_transaction' => $GetResponse->data->merchantTransactionId,
    //                 'payment_transaction_id' => $GetResponse->data->transactionId,
    //                 'payment_amount' => ($GetResponse->data->amount / $this->AmountStandard), //amount
    //                 'payment_state' => $GetResponse->data->state,
    //                 'payment_response_code' => $GetResponse->data->responseCode,
    //                 'payment_instrument_type' => $GetResponse->data->paymentInstrument->type,
    //                 'payment_instrument' => json_encode($GetResponse->data->paymentInstrument),
    //                 'payment_date' => date('Y-m-d'), //pay date
    //                 'active_status' => 1, //maintenances
    //                 'cycle_start_date' => $node[1]['start'],
    //                 'cycle_end_date' => $node[1]['final'],
    //                 'cycle_remaining_date' => $node[1]['reminder']
    //             ];
    //             // dd($store);
    //             $loadFormate = Subscription::insert($store);
    //             if (isset($loadFormate)) {

    //                 Alert::success('', 'Your plan is Activate  SuccessFully Payment');
    //             }
    //             // dd($store);
    //         } else {
    //             Alert::success('', 'failed process Not Payment!');
    //         }
    //         // dd($request->all(), $modeLoad1, $modeLoad1['user_type'], $GetResponse);
    //     }

    //     return redirect('subscription');
    // }
}
