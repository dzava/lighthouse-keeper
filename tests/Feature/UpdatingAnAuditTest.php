<?php

namespace Tests\Feature;

use App\Audit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatingAnAuditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_be_updated()
    {
        $audit = factory(Audit::class)->create([
            'name' => 'Test audit',
            'urls' => ['http://example.com'],
            'accessibility' => false,
            'best_practices' => false,
            'performance' => false,
            'pwa' => false,
            'seo' => false,
            'timeout' => 60,
        ]);

        $response = $this->put(route('audits.update', $audit), [
            'name' => 'Updated audit',
            'urls' => ["http://example.com", "http://example.com/2"],
            'audits' => ['accessibility', 'best_practices', 'performance', 'pwa', 'seo'],
            'timeout' => 10,
            'headers' => [['name' => 'Authorization', 'value' => 'bearer: tok']],
            'notify_emails' => ['john@example.com', 'jane@example.com'],
        ]);

        $response->assertRedirect(route('audits.edit', $audit));

        $audit = Audit::first();
        $this->assertNotNull($audit);
        $this->assertEquals('Updated audit', $audit->name);
        $this->assertEquals(['http://example.com', 'http://example.com/2'], $audit->urls);
        $this->assertTrue($audit->accessibility);
        $this->assertTrue($audit->best_practices);
        $this->assertTrue($audit->performance);
        $this->assertTrue($audit->pwa);
        $this->assertTrue($audit->seo);
        $this->assertEquals(10, $audit->timeout);
        $this->assertEquals([
            ['name' => 'Authorization', 'value' => 'bearer: tok'],
        ], $audit->headers);
        $this->assertEquals(['john@example.com', 'jane@example.com'], $audit->notify_emails);
    }

    /** @test */
    public function headers_can_be_removed()
    {
        $audit = factory(Audit::class)->create([
            'headers' => [['name' => 'Authorization', 'value' => 'bearer: tok']],
        ]);
        $this->assertNotEmpty($audit->headers);

        $response = $this->put(route('audits.update', $audit), [
            // Headers are not sent
        ]);

        $response->assertRedirect(route('audits.edit', $audit));

        $audit = Audit::first();
        $this->assertNotNull($audit);
        $this->assertEmpty($audit->headers);
    }

    /** @test */
    public function updating_webhook_settings()
    {
        $audit = factory(Audit::class)->create([
            'webhook_enabled' => false,
            'webhook_branch' => 'master',
            'webhook_delay' => 0,
        ]);

        $response = $this->put(route('audits.update', $audit), [
            'webhook_enabled' => true,
            'webhook_branch' => 'releases',
            'webhook_delay' => 123,
        ]);

        $response->assertRedirect(route('audits.edit', $audit));
        $audit = Audit::first();
        $this->assertTrue($audit->webhook_enabled);
        $this->assertEquals('releases', $audit->webhook_branch);
        $this->assertEquals(123, $audit->webhook_delay);
    }

    /** @test */
    public function removing_notified_emails()
    {
        $audit = factory(Audit::class)->create([
            'name' => 'Test audit',
            'urls' => ['http://example.com'],
            'accessibility' => false,
            'best_practices' => false,
            'performance' => false,
            'pwa' => false,
            'seo' => false,
            'timeout' => 60,
            'notify_emails' => ['john@example.com']
        ]);

        $response = $this->put(route('audits.update', $audit), [
            // notify_emails is missing,
        ]);

        $response->assertRedirect(route('audits.edit', $audit));

        $audit = Audit::first();
        $this->assertNotNull($audit);
        $this->assertEmpty($audit->notify_emails);
    }
}
