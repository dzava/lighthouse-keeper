<?php

use App\Report;
use App\Run;
use Faker\Generator as Faker;

$factory->define(Report::class, function (Faker $faker) {

    return [
        'run_id' => function () {
            return factory(Run::class)->create();
        },
        'url' => 'http://example.com/',
        'json_report' => 'tests/fixtures/temp/report.json',
        'html_report' => 'tests/fixtures/temp/report.html',
    ];
});

$factory->state(Report::class, 'failed', [
    'failure_reason' => 'Factory failed',
]);

$factory->state(Report::class, 'completed', [
    'failure_reason' => null,
    'accessibility_score' => 89,
    'best_practices_score' => 82,
    'performance_score' => 99,
    'pwa_score' => null,
    'seo_score' => 89,
]);
