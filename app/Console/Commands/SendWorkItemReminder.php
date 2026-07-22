<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\WorkItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkItemReminderMail;

class SendWorkItemReminder extends Command
{
    protected $signature = 'workitem:reminder';

    protected $description = 'Send Work Item Reminder Emails';

    public function handle()
    {
        $today = Carbon::today();

        $reminders = DB::table('work_item_reminders as wr')

            ->join('work_items as wi', 'wi.id', '=', 'wr.work_item_id')

            ->join('projects as p', 'p.id', '=', 'wi.project_id')

            ->join('users as u', function ($join) {

                $join->on('u.employee_id', '=', 'wr.employee_id')
                     ->on('u.emid', '=', 'wi.emid');

            })

            ->where('wr.status',0)

            ->select(
                'wr.id as reminder_id',
                'wr.days_before',
                'wr.reminder_type',

                'u.name',
                'u.email',

                'p.title as project_title',

                'wi.title',
                'wi.description',
                'wi.end_date',
                'wi.id as work_item_id'
            )

            ->get();

        foreach ($reminders as $reminder) {

            $send = false;

            switch ($reminder->reminder_type) {

                case 'before_due':

                    if (
                        Carbon::parse($reminder->end_date)
                            ->subDays($reminder->days_before)
                            ->isSameDay($today)
                    ) {
                        $send = true;
                    }

                break;

                case 'due_today':

                    if (
                        Carbon::parse($reminder->end_date)
                            ->isSameDay($today)
                    ) {
                        $send = true;
                    }

                break;

                case 'overdue':

                    if (
                        Carbon::parse($reminder->end_date)
                            ->lt($today)
                    ) {
                        $send = true;
                    }

                break;
            }

            if (!$send) {
                continue;
            }

            Mail::to($reminder->email)
                ->send(new WorkItemReminderMail($reminder));

            DB::table('work_item_reminders')

                ->where('id',$reminder->reminder_id)

                ->update([

                    'status'=>1,

                    'sent_at'=>now()

                ]);

            $this->info($reminder->email." Sent");
        }

        return Command::SUCCESS;
    }
}