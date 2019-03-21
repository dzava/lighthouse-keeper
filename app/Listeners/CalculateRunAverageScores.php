<?php

namespace App\Listeners;

use App\Events\RunFinishedEvent;

class CalculateRunAverageScores
{
    protected $run;

    /**
     * Handle the event.
     *
     * @param  RunFinishedEvent $event
     * @return void
     */
    public function handle(RunFinishedEvent $event)
    {
        $this->run = $event->run;

        $scores = [
            'accessibility_score' => $this->calculateAverageScore("accessibility_score"),
            'best_practices_score' => $this->calculateAverageScore("best_practices_score"),
            'performance_score' => $this->calculateAverageScore("performance_score"),
            'seo_score' => $this->calculateAverageScore("seo_score"),
            'pwa_score' => $this->calculateAverageScore("pwa_score"),
        ];

        $this->run->update($scores);
    }

    protected function calculateAverageScore($column)
    {
        $avg = $this->run->reports()->avg($column);

        return is_null($avg) ? null : intval($avg);
    }
}
