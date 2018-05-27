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

        $this->post(route('audits.store'), $this->validParams())
            ->assertRedirect('/');

        $audit = Audit::first();
        $this->assertNotNull($audit);
        $this->assertEquals('Test audit', $audit->name);
        $this->assertEquals(['http://example.com'], $audit->urls->toArray());
        $this->assertTrue($audit->accessibility);
        $this->assertTrue($audit->best_practices);
        $this->assertTrue($audit->performance);
        $this->assertTrue($audit->pwa);
        $this->assertTrue($audit->seo);
        $this->assertEquals(10, $audit->timeout);
        $this->assertEquals([
            ['name' => 'Authorization', 'value' => 'bearer: abc123'],
            ['name' => 'Cookie', 'value' => 'monster=blue'],
        ], $audit->headers);
        Queue::assertPushed(RunAudit::class, function ($job) use ($audit) {
            return $job->audit->id === $audit->id;
        });
    }

    protected function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Test audit',
            'urls' => 'http://example.com',
            'accessibility' => true,
            'best_practices' => true,
            'performance' => true,
            'pwa' => true,
            'seo' => true,
            'headers' => [
                ['name' => 'Authorization', 'value' => 'bearer: abc123'],
                ['name' => 'Cookie', 'value' => 'monster=blue'],
            ],
            'timeout' => 10,
        ], $overrides);
    }
}
