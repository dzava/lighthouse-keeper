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
            'urls' => 'http://example.com',
            'accessibility' => false,
            'best_practices' => false,
            'performance' => false,
            'pwa' => false,
            'seo' => false,
            'timeout' => 60,
        ]);

        $response = $this->put(route('audits.update', $audit), [
            'name' => 'Updated audit',
            'urls' => "http://example.com\nhttp://example.com/2",
            'audits' => ['accessibility', 'best_practices', 'performance', 'pwa', 'seo'],
            'timeout' => 10,
            'headers' => [['name' => 'Authorization', 'value' => 'bearer: tok']],
        ]);

        $response->assertRedirect(route('audits.edit', $audit));

        $audit = Audit::first();
        $this->assertNotNull($audit);
        $this->assertEquals('Updated audit', $audit->name);
        $this->assertEquals(['http://example.com', 'http://example.com/2'], $audit->urls->toArray());
        $this->assertTrue($audit->accessibility);
        $this->assertTrue($audit->best_practices);
        $this->assertTrue($audit->performance);
        $this->assertTrue($audit->pwa);
        $this->assertTrue($audit->seo);
        $this->assertEquals(10, $audit->timeout);
        $this->assertEquals([
            ['name' => 'Authorization', 'value' => 'bearer: tok'],
        ], $audit->headers);
    }

    /** @test */
    public function headers_can_be_removed()
    {
        $audit = factory(Audit::class)->create([
            'headers' => [['name' => 'Authorization', 'value' => 'bearer: tok']],
        ]);
        $this->assertNotEmpty($audit->headers);

        $response = $this->put(route('audits.update', $audit), [
            // Headers a re not sent
        ]);

        $response->assertRedirect(route('audits.edit', $audit));

        $audit = Audit::first();
        $this->assertNotNull($audit);
        $this->assertEmpty($audit->headers);
    }
}
