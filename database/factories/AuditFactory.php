<?php

use Faker\Generator as Faker;

$factory->define(App\Audit::class, function (Faker $faker) {
    return [
        'name' => 'Test audit',
        'urls' => 'http://example.com',
        'accessibility' => true,
        'best_practices' => true,
        'performance' => true,
        'pwa' => true,
        'seo' => true,
    ];
});

$factory->state(App\Audit::class, 'multiple', [
    'urls' => "http://example.com\nhttp://example.com/with/a/path",
]);

$factory->state(App\Audit::class, 'invalid', [
    'urls' => "invalid-url",
]);
