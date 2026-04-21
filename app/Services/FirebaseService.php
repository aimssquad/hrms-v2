<?php

namespace App\Services;
use Google\Client;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    protected $projectId = 'sponic-hr';

    public function send($token, $title, $body)
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/firebase/firebase.json'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $response = Http::withToken($accessToken)->post($url, [
            "message" => [
                "token" => $token,
                "notification" => [
                    "title" => $title,
                    "body" => $body
                ]
            ]
        ]);

        return $response->json();
    }

    // public static function send($tokens, $title, $body, $data = [])
    // {
    //     if (empty($tokens)) {
    //         return;
    //     }

    //     $response = Http::withHeaders([
    //         'Authorization' => 'key=' . env('FCM_SERVER_KEY'),
    //         'Content-Type'  => 'application/json',
    //     ])->post('https://fcm.googleapis.com/fcm/send', [
    //         'registration_ids' => is_array($tokens) ? $tokens : [$tokens],

    //         'notification' => [
    //             'title' => $title,
    //             'body'  => $body,
    //             'sound' => 'custom_sound', // ringtone name
    //         ],

    //         'data' => $data,
    //         'priority' => 'high',
    //     ]);

    //     return $response->json();
    // }
}
