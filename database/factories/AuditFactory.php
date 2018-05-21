<?php

use Faker\Generator as Faker;

$factory->define(App\Audit::class, function (Faker $faker) {
    return [
        'name' => 'Test audit',
        'url' => 'http://example.com',
        'accessibility' => true,
        'best_practices' => true,
        'performance' => true,
        'pwa' => true,
        'seo' => true,
    ];
});
