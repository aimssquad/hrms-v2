<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkItemReminderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $reminder;

    public function __construct($reminder)
    {
        $this->reminder = $reminder;
    }

    public function build()
    {
        return $this
            ->subject('Reminder Mail')
            ->view('email-template.work-item-reminder');
    }
}
