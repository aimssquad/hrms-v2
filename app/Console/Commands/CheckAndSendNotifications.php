<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\EmpNotification;    
use App\Models\Employee;
use App\Models\EmpNotificationSetting;
use App\Models\EmpNotificationModule;


class CheckAndSendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:check';
    protected $description = 'Check and insert notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    // public function handle()
    // {
    //     $today = now()->toDateString();

    //     //HOLIDAY
    //     $holidays = DB::table('holiday')
    //         ->whereDate('from_date', '<=', $today)
    //         ->whereDate('to_date', '>=', $today)
    //         ->get();

    //    foreach ($holidays as $holiday) {

    //         $exists = EmpNotification::where([
    //             'type' => 'HOLIDAY',
    //             'reference_id' => $holiday->id,
    //             'reference_type' => 'holiday'
    //         ])->whereDate('start_date', $today)->exists();

    //         if (!$exists) {

    //             $title = 'Holiday Today';
    //             $message = $holiday->holiday_descripion;

    //             EmpNotification::create([
    //                 'emid'           => $holiday->emid ?? null,
    //                 'type'           => 'HOLIDAY',
    //                 'title'          => $title,
    //                 'description'    => $message,
    //                 'reference_id'   => $holiday->id,
    //                 'reference_type' => 'holiday',
    //                 'start_date'     => now(),
    //                 'status'         => 1,
    //             ]);

    //             if (EmpNotificationSetting::isMuted($job->emp_code, $moduleId)) {
    //                 continue;
    //             }

    //             //SEND TO ALL USERS OF THAT ORG
    //             $tokens = DB::table('users')
    //                 ->join('user_devices', 'user_devices.user_id', '=', 'users.id')
    //                 ->where('users.emid', $holiday->emid)
    //                 ->pluck('user_devices.fcm_token');

    //             foreach ($tokens as $token) {
    //                 app(\App\Services\FirebaseService::class)
    //                     ->send($token, $title, $message);
    //             }
    //         }
    //     }

    //     // BIRTHDAY
    //     $employees = Employee::whereMonth('emp_dob', now()->month)
    //         ->whereDay('emp_dob', now()->day)
    //         ->get();

    //     foreach ($employees as $emp) {

    //         $exists = EmpNotification::where([
    //             'type' => 'BIRTHDAY',
    //             'reference_id' => $emp->id,
    //             'reference_type' => 'employee'
    //         ])->whereDate('start_date', $today)->exists();

    //         if (!$exists) {

    //             $title = 'Happy Birthday';
    //             $message = 'Happy Birthday ' . $emp->emp_fname. ' ' . $emp->emp_mname. ' ' . $emp->emp_lname;

    //             EmpNotification::create([
    //                 'emid'           => $emp->emid,
    //                 'employee_id'    => $emp->emp_code ?? null,
    //                 'user_id'        => $emp->id,
    //                 'type'           => 'BIRTHDAY',
    //                 'title'          => $title,
    //                 'description'    => $message,
    //                 'reference_id'   => $emp->id,
    //                 'reference_type' => 'employee',
    //                 'start_date'     => now(),
    //                 'status'         => 1,
    //             ]);

    //             //SEND ONLY TO THIS EMPLOYEE
    //             if (EmpNotificationSetting::isMuted($job->emp_code, $moduleId)) {
    //                 continue;
    //             }

    //             $tokens = DB::table('user_devices')
    //                 ->join('users', 'users.id', '=', 'user_devices.user_id')
    //                 ->where('users.employee_id', $emp->emp_code)
    //                 ->pluck('user_devices.fcm_token');

    //             foreach ($tokens as $token) {
    //                 app(\App\Services\FirebaseService::class)
    //                     ->send($token, $title, $message);
    //             }
    //         }
    //     }

    //     $this->checkExpiry('visa_exp_date', 'VISA_EXPIRY');
    //     $this->checkExpiry('pass_exp_date', 'PASSPORT_EXPIRY');
    //     $this->checkExpiry('dbs_exp_date', 'DBS_EXPIRY');
    //     $this->checkExpiry('euss_exp_date', 'EUSS_EXPIRY');
    // }

 
    // private function checkExpiry($column, $type)
    // {
    //     $daysArray = [90, 60, 30];

    //     foreach ($daysArray as $days) {

    //         $targetDate = now()->addDays($days)->toDateString();

    //         $employees = DB::table('employee')
    //             ->whereDate($column, $targetDate)
    //             ->get();

    //         foreach ($employees as $job) {

    //             $title = "{$type} Reminder {$days} days";
    //             $message = "Your " . strtolower(str_replace('_EXPIRY', '', $type)) . " will expire in {$days} days.";

    //             $exists = EmpNotification::where([
    //                 'employee_id' => $job->emp_code,
    //                 'title' => $title
    //             ])->whereDate('start_date', now())->exists();

    //             if (!$exists) {

    //                 EmpNotification::create([
    //                     'emid'           => $job->emid,
    //                     'employee_id'    => $job->emp_code,
    //                     'type'           => $type,
    //                     'title'          => $title,
    //                     'description'    => $message,
    //                     'reference_id'   => $job->emp_code,
    //                     'reference_type' => 'employee',
    //                     'start_date'     => now(),
    //                     'end_date'       => $job->$column,
    //                     'status'         => 1,
    //                 ]);

    //                 if (EmpNotificationSetting::isMuted($job->emp_code, $moduleId)) {
    //                     continue;
    //                 }

    //                 // FIREBASE LOGIC
    //                 $tokens = DB::table('user_devices')
    //                     ->join('users', 'users.id', '=', 'user_devices.user_id')
    //                     ->where('users.employee_id', $job->emp_code)
    //                     ->pluck('user_devices.fcm_token');

    //                 foreach ($tokens as $token) {
    //                     app(\App\Services\FirebaseService::class)
    //                         ->send($token, $title, $message);
    //                 }
    //             }
    //         }
    //     }
    // }

    public function handle()
    {
        $today = now()->toDateString();
        
        //HOLIDAY
        $holidays = DB::table('holiday')
            ->whereDate('from_date', '<=', $today)
            ->whereDate('to_date', '>=', $today)
            ->get();
        
        foreach ($holidays as $holiday) {

            $title = 'Holiday Today';
            $message = $holiday->holiday_descripion;
           // dd($holiday);
            //  Get all employees of that org
            $users = DB::table('users')
                ->join('user_devices', 'user_devices.user_id', '=', 'users.id')
                ->where('users.emid', $holiday->emid)
                ->select('users.employee_id','users.id', 'user_devices.fcm_token')
                ->get();
            //dd($users);
            foreach ($users as $user) {

                // Check per employee
                $exists = EmpNotification::where([
                    'type' => 'HOLIDAY',
                    'reference_id' => $holiday->id,
                    'reference_type' => 'holiday',
                    'employee_id' => $user->employee_id
                ])->whereDate('start_date', $today)->exists();

                if (!$exists) {

                    // Create per employee
                    EmpNotification::create([
                        'emid'           => $holiday->emid ?? null,
                        'employee_id'    => $user->employee_id,
                        'user_id'        => $user->id,
                        'type'           => 'HOLIDAY',
                        'title'          => $title,
                        'description'    => $message,
                        'reference_id'   => $holiday->id,
                        'reference_type' => 'holiday',
                        'start_date'     => now(),
                        'status'         => 1,
                    ]);

                    // MUTE CHECK
                    if (EmpNotificationSetting::isMuted(
                        $user->employee_id,
                        EmpNotificationModule::HOLIDAY
                    )) {
                        continue;
                    }

                    // FIREBASE SEND
                    app(\App\Services\FirebaseService::class)
                        ->send($user->fcm_token, $title, $message);
                }
            }
        }

        // BIRTHDAY
        $employees = Employee::whereMonth('emp_dob', now()->month)
            ->whereDay('emp_dob', now()->day)
            ->get();

        foreach ($employees as $emp) {

            $exists = EmpNotification::where([
                'type' => 'BIRTHDAY',
                'reference_id' => $emp->id,
                'reference_type' => 'employee'
            ])->whereDate('start_date', $today)->exists();

            if (!$exists) {

                $title = 'Happy Birthday 🎉';
                $message = 'Happy Birthday ' . $emp->emp_fname . ' ' . $emp->emp_mname . ' ' . $emp->emp_lname;

                EmpNotification::create([
                    'emid'           => $emp->emid,
                    'employee_id'    => $emp->emp_code,
                    'user_id'        => $emp->id,
                    'type'           => 'BIRTHDAY',
                    'title'          => $title,
                    'description'    => $message,
                    'reference_id'   => $emp->id,
                    'reference_type' => 'employee',
                    'start_date'     => now(),
                    'status'         => 1,
                ]);

                //  MUTE CHECK
                if (EmpNotificationSetting::isMuted(
                    $emp->emp_code,
                    EmpNotificationModule::BIRTHDAY
                )) {
                    continue;
                }

                $tokens = DB::table('user_devices')
                    ->join('users', 'users.id', '=', 'user_devices.user_id')
                    ->where('users.employee_id', $emp->emp_code)
                    ->pluck('user_devices.fcm_token');

                foreach ($tokens as $token) {
                    app(\App\Services\FirebaseService::class)
                        ->send($token, $title, $message);
                }
            }
        }

        //EXPIRY
        $this->checkExpiry('visa_exp_date', 'VISA_EXPIRY', EmpNotificationModule::VISA_EXPIRY);
        $this->checkExpiry('pass_exp_date', 'PASSPORT_EXPIRY', EmpNotificationModule::PASSPORT_EXPIRY);
        $this->checkExpiry('dbs_exp_date', 'DBS_EXPIRY', EmpNotificationModule::DBS_EXPIRY);
        $this->checkExpiry('euss_exp_date', 'EUSS_EXPIRY', EmpNotificationModule::EUSS_EXPIRY);
    }

    private function checkExpiry($column, $type, $moduleId)
    {
        $daysArray = [90, 60, 30];

        foreach ($daysArray as $days) {

            $targetDate = now()->addDays($days)->toDateString();

            $employees = DB::table('employee')
                ->whereDate($column, $targetDate)
                ->get();

            foreach ($employees as $job) {

                $title = "{$type} Reminder {$days} days";
                $message = "Your " . strtolower(str_replace('_EXPIRY', '', $type)) . " will expire in {$days} days.";

                $exists = EmpNotification::where([
                    'employee_id' => $job->emp_code,
                    'title' => $title
                ])->whereDate('start_date', now())->exists();

                if (!$exists) {

                    EmpNotification::create([
                        'emid'           => $job->emid,
                        'employee_id'    => $job->emp_code,
                        'type'           => $type,
                        'title'          => $title,
                        'description'    => $message,
                        'reference_id'   => $job->id,
                        'reference_type' => 'employee',
                        'start_date'     => now(),
                        'end_date'       => $job->$column,
                        'status'         => 1,
                    ]);

                    // MUTE CHECK
                    if (EmpNotificationSetting::isMuted($job->emp_code, $moduleId)) {
                        continue;
                    }

                    $tokens = DB::table('user_devices')
                        ->join('users', 'users.id', '=', 'user_devices.user_id')
                        ->where('users.employee_id', $job->emp_code)
                        ->pluck('user_devices.fcm_token');

                    foreach ($tokens as $token) {
                        app(\App\Services\FirebaseService::class)
                            ->send($token, $title, $message);
                    }
                }
            }
        }
    }


}
