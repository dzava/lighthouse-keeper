<?php

use App\Audit;
use App\Run;
use Faker\Generator as Faker;

$factory->define(Run::class, function (Faker $faker) {
    return [
        'audit_id' => function () {
            return factory(Audit::class)->create()->id;
        },
    ];
});
