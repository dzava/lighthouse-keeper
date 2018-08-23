<?php

namespace Tests\Unit\Listeners;

use App\Events\ReportCreatedEvent;
use App\Listeners\ProcessReport;
use App\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProcessReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        Storage::fake('public');
    }


    /** @test */
    public function it_marks_the_report_as_failed_when_the_json_report_is_not_generated()
    {
        $report = factory(Report::class)->create(['json_report' => '/not/a/valid/report']);
        $this->assertFalse($report->failed());

        (new ProcessReport())->handle(new ReportCreatedEvent($report));

        $this->assertTrue($report->failed());
    }

    /** @test */
    public function it_will_store_the_scores_from_the_json_report()
    {
        $this->copyReportsToTemp();
        $report = factory(Report::class)->create();

        $this->assertNull($report->accessibility_score);
        $this->assertNull($report->best_practices_score);
        $this->assertNull($report->performance_score);
        $this->assertNull($report->pwa_score);
        $this->assertNull($report->seo_score);

        (new ProcessReport())->handle(new ReportCreatedEvent($report));

        $this->assertEquals(88, $report->accessibility_score);
        $this->assertEquals(87, $report->best_practices_score);
        $this->assertEquals(100, $report->performance_score);
        $this->assertNull($report->pwa_score);
        $this->assertEquals(89, $report->seo_score);
    }

    /** @test */
    public function it_stores_the_reports()
    {
        $this->copyReportsToTemp();
        $report = factory(Report::class)->create();
        $this->assertFileExists($report->json_report);
        $this->assertFileExists($report->html_report);
        Storage::disk('public')->assertMissing($originalJsonReport = $report->json_report);
        Storage::disk('public')->assertMissing($originalHtmReport = $report->html_report);

        (new ProcessReport())->handle(new ReportCreatedEvent($report));

        $this->assertFileNotExists($originalJsonReport);
        $this->assertFileNotExists($originalHtmReport);
        $report->refresh();
        Storage::disk('public')->assertExists($report->json_report);
        Storage::disk('public')->assertExists($report->html_report);
    }
}
