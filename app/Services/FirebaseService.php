<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseService
{
    public static function send($tokens, $title, $body, $data = [])
    {
        if (empty($tokens)) {
            return;
        }

        $response = Http::withHeaders([
            'Authorization' => 'key=' . env('FCM_SERVER_KEY'),
            'Content-Type'  => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'registration_ids' => is_array($tokens) ? $tokens : [$tokens],

            'notification' => [
                'title' => $title,
                'body'  => $body,
                'sound' => 'custom_sound', // 🔔 ringtone name
            ],

            'data' => $data,
            'priority' => 'high',
        ]);

        return $response->json();
    }
}
