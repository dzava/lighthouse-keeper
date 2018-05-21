<?php

namespace Tests\Feature;

use App\Audit;
use App\Auditing\Auditor;
use App\Auditing\FakeAuditor;
use App\Events\ReportCreatedEvent;
use App\Events\RunFinishedEvent;
use App\Jobs\RunAudit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RunningAnAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        Storage::fake('public');

        app()->instance(Auditor::class, new FakeAuditor());
    }

    /** @test */
    public function auditing_a_single_url()
    {
        $audit = factory(Audit::class)->create();
        Storage::disk('public')->assertMissing('audits/1/reports/report.json');
        Storage::disk('public')->assertMissing('audits/1/reports/report.html');

        dispatch(new RunAudit($audit));

        $this->assertCount(1, $audit->runs);
        $this->assertCount(1, ($run = $audit->runs->first())->reports);
        $report = $run->reports->first();
        $this->assertEquals('http://example.com', $report->url);
        $this->assertEquals('audits/1/reports/report.json', $report->json_report);
        $this->assertEquals('audits/1/reports/report.html', $report->html_report);
        $this->assertFalse($report->failed());
        Storage::disk('public')->assertExists($report->json_report);
        Storage::disk('public')->assertExists($report->html_report);
    }

    /** @test */
    public function auditing_multiple_urls()
    {
        $audit = factory(Audit::class)->states('multiple')->create();

        dispatch(new RunAudit($audit));

        $this->assertCount(1, $audit->runs);
        $this->assertCount(2, ($run = $audit->runs->first())->reports);
        [$report1, $report2] = $run->reports;
        $this->assertEquals('http://example.com', $report1->url);
        $this->assertNotNull($report1->json_report);
        $this->assertNotNull($report1->html_report);
        $this->assertFalse($report1->failed());
        $this->assertEquals('http://example.com/with/a/path', $report2->url);
        $this->assertNotNull($report2->json_report);
        $this->assertNotNull($report2->html_report);
        $this->assertFalse($report2->failed());
    }

    /** @test */
    public function records_a_failed_report()
    {
        $audit = factory(Audit::class)->states('invalid')->create();

        dispatch(new RunAudit($audit));

        $report = $audit->runs->first()->reports->first();
        $this->assertNotNull($report);
        $this->assertEquals('invalid-url', $report->url);
        $this->assertNotNull($report->failure_reason);
        $this->assertTrue($report->failed());
    }

    /** @test */
    public function an_event_is_emitted_when_a_run_is_finished()
    {
        Event::fake();

        $audit = factory(Audit::class)->create();

        dispatch(new RunAudit($audit));

        Event::assertDispatched(ReportCreatedEvent::class);
        Event::assertDispatched(RunFinishedEvent::class);
    }
}
