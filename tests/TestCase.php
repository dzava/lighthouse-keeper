<?php

namespace Tests;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    protected function copyReportsToTemp()
    {
        copy(base_path('tests/fixtures/report.json'), base_path('tests/fixtures/temp/report.json'));
        copy(base_path('tests/fixtures/report.html'), base_path('tests/fixtures/temp/report.html'));
    }
}
