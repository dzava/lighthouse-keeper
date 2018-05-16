<?php

namespace Tests\Unit\Listeners;

use App\Events\RunFinishedEvent;
use App\Listeners\CalculateRunAverageScores;
use App\Report;
use App\Run;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculateRunAverageScoresTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_the_run_with_the_average_score_of_all_reports()
    {
        $run = factory(Run::class)->create();
        factory(Report::class)->states('completed')->create(['run_id' => $run->id, 'accessibility_score' => 100]);
        factory(Report::class)->states('completed')->create(['run_id' => $run->id, 'accessibility_score' => 50]);
        $this->assertNull($run->accessibility_score);
        $this->assertNull($run->best_practices_score);
        $this->assertNull($run->performance_score);
        $this->assertNull($run->pwa_score);
        $this->assertNull($run->seo_score);

        (new CalculateRunAverageScores())->handle(new RunFinishedEvent($run));

        $this->assertEquals(75, $run->accessibility_score);
        $this->assertEquals(82, $run->best_practices_score);
        $this->assertEquals(99, $run->performance_score);
        $this->assertNull($run->pwa_score);
        $this->assertEquals(89, $run->seo_score);
    }
}
