<?php

namespace Tests\Feature;

use App\Audit;
use App\Jobs\RunAudit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CreatingAnAuditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_an_audit()
    {
        Queue::fake();

        $response = $this->post(route('audits.store'), $this->validParams());

        $audit = Audit::first();
        $response->assertRedirect(route('audits.edit', $audit));
        $this->assertNotNull($audit);
        $this->assertEquals('Test audit', $audit->name);
        $this->assertEquals(['http://example.com'], $audit->urls);
        $this->assertTrue($audit->accessibility);
        $this->assertTrue($audit->best_practices);
        $this->assertTrue($audit->performance);
        $this->assertTrue($audit->pwa);
        $this->assertTrue($audit->seo);
        Queue::assertPushed(RunAudit::class, function ($job) use ($audit) {
            return $job->audit->id === $audit->id;
        });
    }

    protected function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Test audit',
            'urls' => ['http://example.com'],
            'audits' => ['accessibility', 'best_practices', 'performance', 'pwa', 'seo'],
        ], $overrides);
    }
}
