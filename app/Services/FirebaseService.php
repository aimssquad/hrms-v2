<?php

namespace App\Services;
use Google\Client;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    
    
        protected $projectId = 'sponic-hr';

        public function send(
            $token,
            $title,
            $body,
            $data = []
        ) {
            $client = new Client();
    
            $client->setAuthConfig(
                storage_path('app/firebase/firebase.json')
            );
    
            $client->addScope(
                'https://www.googleapis.com/auth/firebase.messaging'
            );
    
            $accessToken = $client
                ->fetchAccessTokenWithAssertion()['access_token'];
    
            $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
    
            $payload = [
    
                "message" => [
    
                    "token" => $token,
    
                    "notification" => [
    
                        "title" => $title,
    
                        "body"  => $body
                    ]
                ]
            ];
    
            /*
            |--------------------------------------------------------------------------
            | OPTIONAL DATA PAYLOAD
            |--------------------------------------------------------------------------
            */
    
            if (!empty($data)) {
    
                $payload["message"]["data"] = array_map(
    
                    fn($value) => (string) $value,
    
                    $data
                );
            }
    
            $response = Http::withToken($accessToken)
    
                ->post($url, $payload);
    
            return $response->json();
        }

}
