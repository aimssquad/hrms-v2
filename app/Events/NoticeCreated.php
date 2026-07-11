<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;

class NoticeCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct(Notification $notification)
    {
        // This will be sent to React + Flutter
        $this->notification = $notification;
    }


    // public function broadcastOn()
    // {
    //     return new Channel('notice-channel.' . $this->notification->employee_id);
    // }

    public function broadcastOn()
    {
        $emid = $this->notification->emid;
        $employeeId = $this->notification->employee_id;

        // If notification is for all employees in the organization
        if ($employeeId === 'all') {
            return new Channel("notice-channel.$emid.all");
        }

        // If notification is for one specific employee
        return new Channel("notice-channel.$emid.$employeeId");
    }



    public function broadcastAs()
    {
        // Event name
        return 'notice-live';
    }
}
