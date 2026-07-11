<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseRealtimeService
{
    public function pushMessage($workItemId, $data)
    {
        return Http::post(

            env('FIREBASE_DATABASE_URL')

            . '/work_item_chat/'

            . $workItemId

            . '.json',

            $data
        );
    }
}