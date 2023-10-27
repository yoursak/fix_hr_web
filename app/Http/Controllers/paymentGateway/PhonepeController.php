<?php

namespace App\Http\Controllers\paymentGateway;

use App\Http\Controllers\Controller;
use App\Helpers\MasterRulesManagement\RulesManagement;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Alert;
use Session;

class PhonepeController extends Controller
{
    public function phonePe()
    {
        $data = array(
            'merchantId' => 'PGTESTPAYUAT',
            'merchantTransactionId' => uniqid(),
            'merchantUserId' => 'PGTESTPAYUAT',
            'business_id' => Session::get('business_id'),
            'user_type' => Session::get('user_type'),
            'amount' => 10000,
            'redirectUrl' => route('subscription'),
            'redirectMode' => 'POST',
            'callbackUrl' => route('subscription'),
            'mobileNumber' => '8462074453',
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

        $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";

        $response = Curl::to($url)
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();

        $rData = json_decode($response);

        return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
    }

    public function responseSubmit(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $finalXHeader = hash('sha256', '/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'] . $saltKey) . '###' . $saltIndex;

        $response = Curl::to('https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/' . $input['merchantId'] . '/' . $input['transactionId'])
            ->withHeader('Content-Type:application/json')
            ->withHeader('accept:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withHeader('X-MERCHANT-ID:' . $input['transactionId'])
            ->get();

        // return  json_decode($response);
        return redirec()->to('subscription');
    }
}
