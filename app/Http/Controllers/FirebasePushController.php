<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Http\Models\User;
use DB;
use App\Models\LoginAdmin;
// protected $notification;/
class FirebasePushController extends Controller
{
    protected $notification;
    public function __construct()
    {
        $this->notification = Firebase::messaging();
    }
    public function setToken(Request $request)
    {
        $token = $request->input('fcm_token');
        $request->user()->update([
            'fcm_token' => $token
        ]); //Get the currrently logged in user and set their token
        return response()->json([
            'message' => 'Successfully Updated FCM Token'
        ]);
    }
    public function Notification()
    {
        return view('pushNotification');
    }
    public function sendNotification(Request $request)
    {
        $firebaseToken = DB::table('login_token_admin')->where('business_id', $request->busienss_id)->pluck('notification_token')->all(); // User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = "AAAAwE7hbKc:APA91bGar_i17wohzSnNUBSxN04GTu70zFn3Z63aozxL_VgysGJpfvtFDSueW652HD6DE_XLfGHzoUQEbJbbFtcNYKaCOoaPFeLUYrNwuTKHMhZ_O0RUMZCqxUUaJg0-5N8WfZxTyDN8"; //env('FCM_SERVER_KEY');
        // dd($firebaseToken);

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        // return back()->with('success', 'Notification send successfully.');
        return  response()->json(['result' => $response]);
    }
}
