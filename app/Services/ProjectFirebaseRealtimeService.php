<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProjectFirebaseRealtimeService
{
    public function pushProjectMessage($projectId, $data)
    {
        return Http::post(

            env('FIREBASE_DATABASE_URL')

            . '/project_chat/'

            . $projectId

            . '.json',

            $data
        );
    }
    
    //Update project summary
    public function updateProjectSummary($projectId, $data)
    {
        return Http::put(
    
            env('FIREBASE_DATABASE_URL')
    
            . '/project_summary/'
    
            . $projectId
    
            . '.json',
    
            $data
        );
    }
    
    public function updateUnreadCount(
        $projectId,
        $employeeId,
        $count
    )
    {
        return Http::withBody(
            json_encode($count),
            'application/json'
        )->put(
    
            env('FIREBASE_DATABASE_URL')
    
            . "/project_summary/{$projectId}/unread/{$employeeId}.json"
        );
    }
}