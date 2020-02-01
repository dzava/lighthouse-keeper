<?php

namespace Database\Factories;

use App\Audit;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditFactory extends Factory
{
    protected $model = Audit::class;

    public function definition()
    {
        return [
            'name' => 'Test audit',
            'urls' => ['http://example.com'],
            'accessibility' => true,
            'best_practices' => true,
            'performance' => true,
            'pwa' => true,
            'seo' => true,
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Factories\Factory */
    public function multiple()
    {
        return $this->state([
            'urls' => ["http://example.com", "http://example.com/with/a/path"],
        ]);
    }

    /** @return \Illuminate\Database\Eloquent\Factories\Factory */
    public function invalid()
    {
        return $this->state([
            'urls' => ["invalid-url"],
        ]);
    }
}
