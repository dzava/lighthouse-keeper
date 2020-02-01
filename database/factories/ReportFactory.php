<?php

namespace Database\Factories;

use App\Report;
use App\Run;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition()
    {
        return [
            'run_id' => function () {
                return Run::factory();
            },
            'url' => 'http://example.com/',
            'json_report' => base_path('tests/fixtures/temp/report.json'),
            'html_report' => base_path('tests/fixtures/temp/report.html'),
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Factories\Factory */
    public function failed()
    {
        return $this->state([
            'failure_reason' => 'Factory failed',
        ]);
    }

    /** @return \Illuminate\Database\Eloquent\Factories\Factory */
    public function completed()
    {
        return $this->state(['failure_reason' => null,
                'accessibility_score' => 89,
                'best_practices_score' => 93,
                'performance_score' => 99,
                'pwa_score' => null,
                'seo_score' => 89,
            ]
        );
    }
}
