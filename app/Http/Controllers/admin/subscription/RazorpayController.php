<?php

namespace App\Http\Controllers\admin\subscription;

use App\Http\Controllers\Controller;
use App\Models\OrdersPayment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Subscription;
use App\Models\BusinessDetailsList;
use Session;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\EmployeePersonalDetail;
use Illuminate\Contracts\Session\Session as SessionSession;

class RazorpayController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        $api = new Api('rzp_test_dNhHfVpKhFIvFI', 'xvMJygi1384peNtmIIVMF6qc'); //local

        $paymentId = $input['razorpay_payment_id'];
        $payment = $api->payment->fetch($paymentId);
        if (count($input) && !empty($paymentId)) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $node = RulesManagement::GetSubscriptionMode($request->plan_id);
                // $totalEmployee = EmployeePersonalDetail::where('business_id', Session::get('business_id'))->count();
                $GetBusinessDetails = BusinessDetailsList::where('business_id', Session::get('business_id'))->first();


                // dd($payment, $response,  $request->all(), $node[1]['start'], $node[1]['final'], $node[1]['reminder'], Session::all());

                $SubscriptionLevel = new Subscription();
                $SubscriptionLevel->order_id = 'FixHR_' . $response['order_id'];
                $SubscriptionLevel->payment_id = $response['id'];
                $SubscriptionLevel->name = $GetBusinessDetails->client_name; // $input['name'];
                $SubscriptionLevel->amount = $payment['amount'] / 100; //total amount
                $SubscriptionLevel->email = $GetBusinessDetails->business_email; // $payment['email'];
                $SubscriptionLevel->phone_no = $GetBusinessDetails->mobile_no; // $payment['contact'];
                $SubscriptionLevel->order_status = $response['status'];
                $SubscriptionLevel->role_id = Session::get('login_role'); //not required
                $SubscriptionLevel->user_type = Session::get('user_type');
                $SubscriptionLevel->business_id =  Session::get('business_id'); //not required
                $SubscriptionLevel->total_employee_checked= $request->total_employee;
                $SubscriptionLevel->plan_id = $request->plan_id;
                $SubscriptionLevel->base_plan = $request->baseplans;
                $SubscriptionLevel->per_employee_value = $request->tempEmployeeCount;
                $SubscriptionLevel->additional_count = $request->countemployee;
                $SubscriptionLevel->additional_employee = $request->additionalemployee;
                $SubscriptionLevel->payment_date  = date('Y-m-d'); //pay date
                $SubscriptionLevel->active_status  = 1;
                $SubscriptionLevel->cycle_starting  = $node[1]['start'];
                $SubscriptionLevel->cycle_expairy  = $node[1]['final'];
                $SubscriptionLevel->cycle_remaining  = $node[1]['reminder'];
                if ($SubscriptionLevel->save()) {
                    // $ticket->total_seat -= $input['countingValue'];
                    // $ticket->save();
                    Session::put('success', 'Payment successful');
                    // return redirect('thankyou/' . $response['id']);

                    return redirect()->back();
                }
            } catch (Exception $e) {
                return $e->getMessage();
                Session::put('error', $e->getMessage());
                return redirect()->back();
            }
        }
    }

    // {
    //     $input = $request->all();
    //     $totalAmounts = $request->totalamount;
    //     // $order = random_int(100000, 999999);
    //     $order = new subscription();
    //     $order->business_id = Session::get('business_id');
    //     $order->payment_amount = $totalAmounts;
    //     $order->plan_id = $request->plan_id;
    //     if ($order->save()) {
    //         // $api = new Api('rzp_live_cJn9rmPCbfBidZ', 'OFEkFtnIqdEWyVLOOfOP5WuL');//live
    //         $api = new Api('rzp_test_dNhHfVpKhFIvFI', 'xvMJygi1384peNtmIIVMF6qc'); //local


    //         // $rzdebitPay = $api->order->create(
    //         //     array(
    //         //         'receipt' => 'FixHr_ORD_' . $order->id,
    //         //         'amount' => 500 * 100,
    //         //         'currency' => 'INR',
    //         //         'notes' => array('key1' => 'value3', 'key2' => 'value2')
    //         //     )
    //         // );

    //         $payment = $api->payment->fetch($input['razorpay_payment_id']);

    //         if (count($input)  && !empty($input['razorpay_payment_id'])) {
    //             try {
    //                 $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
    //                 dd($response,$request->all());
    //             } catch (Exception $e) {
    //                 return  $e->getMessage();
    //                 Session::put('error', $e->getMessage());
    //                 return redirect()->back();
    //             }
    //         }

    //         Session::put('success', 'Payment successful');
    //         return redirect()->back();
    //         // $nord = OrdersPayment::find($order->id);
    //         // $nord->rzp_ordered_id = $rzdebitPay->id;
    //         // $nord->update();


    //         // return response()->json([
    //         //     'success' => true,
    //         //     'order_id' => $order->id,
    //         //     'amount' => $totalAmounts,
    //         //     'rzp_order' => $rzdebitPay->id
    //         // ]);
    //     }
    // }

    public function thankyou($id)
    {
        // $ty = OrderHistory::select()->where('payment_id', $id)->first();
        // return view('user.home.thank-you')->with('ty', $ty);
    }
    public function callPaymentMethod(Request $request)
    {
        // $api = new Api($key_id, $secret);
        $PlaneID = $request->plan_id;
        $OrderID = random_int(100000, 999999);
        $totalAmount = $request->totalamount;
        // $discount = $request->discount;
        // $gst = 0;
        // $gst = 0;
        // $plane = Subscription::find($PlaneID);
        // $amount = $request->totalamount;

        $api = new Api(env('RZP_API_KEY'), env('RZP_API_SECRET'));
        $rzdebitPay = $api->order->create(
            array(
                'receipt' => 'FixHr_ORD_' . $OrderID,
                'amount' => 100,
                'currency' => 'INR',
                'notes' => array('key1' => 'value3', 'key2' => 'value2')
            )
        );

        // $nord = OrdersPayment::find($OrderID);
        // $nord->rzp_ordered_id = $rzdebitPay->id;
        // $nord->update();
        // dd($request->all(), $rzdebitPay);
        // Store the order ID in your database or session
        $orderId = $rzdebitPay['id'];

        // return response()->json()
        // return view('subscription', compact('orderId'));    // return response()->json(['success' => true, 'order_id' => $OrderID, 'amount' => $totalAmount * 100, 'rzp_order' => $rzdebitPay->id]);

    }
}
