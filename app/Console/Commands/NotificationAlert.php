<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\AttendanceList;
use App\Helpers\MasterRulesManagement\RulesManagement;
use App\Models\LoginEmployee;
use App\Models\EmployeePersonalDetail;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Carbon\Carbon;

use Illuminate\Support\Facades\Config;

class NotificationAlert extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notificationAlert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification Daily Per time Send Message';

    /**
     * Execute the console command.
     *
     * @return int
     */
    // on model flow side structure
    public function handle()
    {
        $messageSend = [];
        // Userside Only
        $SERVER_API_KEY = "AAAAB9VqZPk:APA91bF8g1Uw0WUfMvjY2j3_pIWTZg6Mz56_coB5sFD8j5RwF8T35lSm98g3UUMC_txSErST1SotTOh0XfFsY2ZupP_8yTJPl5QocX-8Y420u8VbPVRgktd_moVqj9ejwzwGc1nXcUqX";

        \Log::info("Auto Notification Send all User execution!");

        $Load = EmployeePersonalDetail::where('active_emp', 1)
            ->leftJoin('login_employee', 'employee_personal_details.emp_id', '=', 'login_employee.emp_id')
            ->select('login_employee.notification_key', 'employee_personal_details.*')
            ->get();
        foreach ($Load as $user) {
            $firebaseToken = json_decode($user->notification_key);
            // Get the current time in 24-hour format
            $currentHour = now()->format('H:i');  // Assuming the current timezone is set correctly


            if (!empty($user->assign_shift_start_time)) {
                // Get the assign_shift_start_time as Carbon object
                $shiftStartTime = Carbon::parse($user->assign_shift_start_time);
                $shiftEndTime = Carbon::parse($user->assign_shift_end_time);

                // Calculate 5 minutes before the shift start time
                $notificationTime = $shiftStartTime->copy()->subMinutes(5);

                // ShiftStart Case TIME Alert
                // Check if the current time is equal to the calculated notification time
                if ($currentHour === $notificationTime->format('H:i')) {

                    if (!$firebaseToken) {
                        continue; // Skip users without a Firebase token
                    }

                    // Punch IN after 5 min
                    $messageSend = [
                        'registration_ids' => $firebaseToken,
                        // "to" => $firebaseToken,
                        "notification" => [
                            "title" => 'Fix HR Employee',
                            'body' => 'Shift Alert' . "\n" . 'Your shift time is going to start,please mark your Punch In on time.',
                        ]
                    ];
                    $dataString = json_encode($messageSend);

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

                    curl_close($ch);


                    // Log the result
                    $this->info('command:notificationAlert Auto Notification Sent to user ' . $user->emp_id . ' current time ' . $currentHour . '  Shift Time Start ' . $shiftStartTime->format('H:i') . ' 5 min before ' . $notificationTime->format('H:i'));
                }
                if ($currentHour === $shiftStartTime->format('H:i')) {

                    if (!$firebaseToken) {
                        continue; // Skip users without a Firebase token
                    }

                    // Punch IN after 5 min
                    $messageSend = [
                        'registration_ids' => $firebaseToken,
                        "notification" => [
                            "title" => 'Fix HR Employee',
                            'body' => 'Your shift time has been started,please mark your Punch In as soon as posible.',
                        ]
                    ];
                    $dataString = json_encode($messageSend);

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

                    curl_close($ch);

                    $this->info('command:notificationAlert Auto Notification Sent to user ' . $user->emp_id . ' current time ' . $currentHour . '  Shift Time Start ' . $shiftStartTime->format('H:i'));
                }
                $this->info('command:notificationAlert Auto Notification Sent to user ' . $user->emp_id . ' current time ' . $currentHour . '  Shift Time Start ' . $shiftStartTime->format('H:i'));
            }

            // ShiftEnd Case TIME Alert
            if (!empty($user->assign_shift_end_time)) {
                // Get the assign_shift_start_time as Carbon object
                // $shiftStartTime = Carbon::parse($user->assign_shift_start_time);
                $shiftEndTime = Carbon::parse($user->assign_shift_end_time);

                // Calculate 5 minutes before the shift start time
                $notificationTime = $shiftEndTime->copy()->subMinutes(5);

                // Check if the current time is equal to the calculated notification time
                if ($currentHour === $notificationTime->format('H:i')) {

                    if (!$firebaseToken) {
                        continue; // Skip users without a Firebase token
                    }

                    // Punch IN after 5 min
                    $messageSend = [
                        'registration_ids' => $firebaseToken,
                        "notification" => [
                            "title" => 'Fix HR Employee',
                            'body' => 'Shift Alert' . "\n" . 'Your shift time is going to end,please mark your Punch Out on time.',
                        ]
                    ];
                    $dataString = json_encode($messageSend);

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

                    curl_close($ch);


                    $this->info('command:notificationAlert Auto Notification Sent to user ' . $user->emp_id . ' current time ' . $currentHour . '  Shift Time Start ' . $shiftStartTime->format('H:i') . ' 5 min before ' . $notificationTime->format('H:i'));
                }
                if ($currentHour === $shiftEndTime->format('H:i')) {

                    if (!$firebaseToken) {
                        continue; // Skip users without a Firebase token
                    }

                    // Punch IN after 5 min
                    $messageSend = [
                        'registration_ids' => $firebaseToken,
                        "notification" => [
                            "title" => 'Fix HR Employee',
                            'body' => 'Your shift time has been end,please mark your Punch Out as soon as posible.',
                        ]
                    ];
                    $dataString = json_encode($messageSend);

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

                    curl_close($ch);


                    $this->info('command:notificationAlert Auto Notification Sent to user ' . $user->emp_id . ' current time ' . $currentHour . '  Shift Time End ' . $shiftEndTime->format('H:i'));
                }
                $this->info('command:notificationAlert Auto Notification Sent to user ' . $user->emp_id . ' current time ' . $currentHour . '  Shift Time End ' . $shiftEndTime->format('H:i'));
            }


            $this->info('command:notificationAlert Auto Notification Sent to user Response: ' . $response);
        }
        return Command::SUCCESS;
    }
}
