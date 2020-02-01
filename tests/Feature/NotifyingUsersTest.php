<?php

namespace Tests\Feature;

use App\Audit;
use App\Events\RunFinishedEvent;
use App\Notifications\RunFinished;
use App\Run;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyingUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function notifications_are_send_when_an_audit_run_finishes()
    {
        Notification::fake();
        $audit = Audit::factory()->create(['notify_emails' => ['john@example.com', 'jane@example.com']]);
        $run = Run::factory()->create(['audit_id' => $audit->id]);

        event(new RunFinishedEvent($run));

        $this->assertNotificationSentTo('john@example.com', function ($notification) use ($run) {
            return $run->is($notification->run);
        })->assertNotificationSentTo('jane@example.com', function ($notification) use ($run) {
            return $run->is($notification->run);
        });
    }

    protected function assertNotificationSentTo($mail, $callback)
    {
        Notification::assertSentTo(
            new AnonymousNotifiable(),
            RunFinished::class,
            function ($notification, $channels, $notifiable) use ($callback, $mail) {
                return $notifiable->routes['mail'] == $mail && call_user_func($callback, $notification, $channels, $notifiable);
            }
        );

        return $this;
    }
}
