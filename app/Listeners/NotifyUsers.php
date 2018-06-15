<?php

namespace App\Listeners;

use App\Events\RunFinishedEvent;
use App\Notifications\RunFinished;
use Illuminate\Support\Facades\Notification;

class NotifyUsers
{
    /**
     * Handle the event.
     *
     * @param  RunFinishedEvent $event
     * @return void
     */
    public function handle(RunFinishedEvent $event)
    {
        $run = $event->run;
        $audit = $run->audit;

        collect($audit->notify_emails)->each(function ($mail) use ($run) {
            Notification::route('mail', $mail)
                ->notify(new RunFinished($run));
        });
    }
}
