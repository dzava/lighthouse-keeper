<?php

namespace Database\Factories;

use App\Audit;
use App\Run;
use Illuminate\Database\Eloquent\Factories\Factory;

class RunFactory extends Factory
{
    protected $model = Run::class;

    public function definition()
    {
        return [
            'audit_id' => function () {
                return Audit::factory();
            },
        ];
    }
}
