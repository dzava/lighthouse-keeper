<?php

namespace App\Listeners;

use App\Events\RunFinishedEvent;

class CalculateRunAverageScores
{
    /**
     * Handle the event.
     *
     * @param  RunFinishedEvent $event
     * @return void
     */
    public function handle(RunFinishedEvent $event)
    {
        $run = $event->run;

        $scores = [
            'accessibility_score' => $run->reports()->avg("accessibility_score"),
            'best_practices_score' => $run->reports()->avg("best_practices_score"),
            'performance_score' => $run->reports()->avg("performance_score"),
            'seo_score' => $run->reports()->avg("seo_score"),
            'pwa_score' => $run->reports()->avg("pwa_score"),
        ];

        $run->update($scores);
    }
}
