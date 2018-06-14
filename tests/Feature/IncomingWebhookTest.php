<?php

namespace Tests\Feature;

use App\Audit;
use App\Jobs\RunAudit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class IncomingWebhookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_matching_audit_is_run()
    {
        Queue::fake();
        $audit = factory(Audit::class)->create([
            'webhook_enabled' => true,
            'webhook_branch' => 'master',
            'webhook_delay' => 69,
        ]);

        $this->post(route('webhooks', $audit->id), $this->webhookPayload())
            ->assertSuccessful();

        Queue::assertPushed(RunAudit::class, function ($job) use ($audit) {
            return $job->audit->is($audit) && $job->delay == 69;
        });
    }

    /** @test */
    public function the_audit_is_not_run_if_the_webhook_is_disabled()
    {
        Queue::fake();
        $audit = factory(Audit::class)->create([
            'webhook_enabled' => false,
            'webhook_branch' => 'master',
        ]);

        $this->post(route('webhooks', $audit->id), $this->webhookPayload())
            ->assertSuccessful();

        Queue::assertNotPushed(RunAudit::class);
    }

    /** @test */
    public function the_audit_is_not_run_if_the_branch_does_not_match()
    {
        Queue::fake();
        $audit = factory(Audit::class)->create([
            'webhook_enabled' => true,
            'webhook_branch' => 'master',
            'webhook_delay' => 69,
        ]);

        $this->post(route('webhooks', $audit->id), $this->webhookPayload('not-master'))
            ->assertSuccessful();

        Queue::assertNotPushed(RunAudit::class);
    }

    /** @test */
    public function the_audit_is_always_run_when_the_branch_is_empty()
    {
        Queue::fake();
        $audit = factory(Audit::class)->create([
            'webhook_enabled' => true,
            'webhook_branch' => null,
            'webhook_delay' => 69,
        ]);

        $this->post(route('webhooks', $audit->id), $this->webhookPayload('not-master'))
            ->assertSuccessful();

        Queue::assertPushed(RunAudit::class, function ($job) use ($audit) {
            return $job->audit->is($audit) && $job->delay == 69;
        });
    }

    protected function webhookPayload($branch = 'master')
    {
        return [
            'ref' => "refs/head/$branch",
        ];
    }
}
