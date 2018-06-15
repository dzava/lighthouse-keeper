<?php

namespace App\Notifications;

use App\Run;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RunFinished extends Notification
{
    use Queueable;

    /** @var Run */
    public $run;

    /**
     * Create a new notification instance.
     *
     * @param Run $run
     */
    public function __construct($run)
    {
        $this->run = $run;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $data = [
            'run' => $this->run,
            'audit' => $this->run->audit,
            'failedReports' => $this->run->failedReports()->count(),
            'successfulReports' => $this->run->successfulReports()->count(),
            'totalReports' => $this->run->reports()->count(),
        ];

        return (new MailMessage)
            ->subject('New audit for ' . $this->run->audit->name)
            ->markdown('mail.audits.finished', $data);
    }
}
