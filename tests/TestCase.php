<?php

namespace Tests;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    protected function copyReportsToTemp()
    {
        copy('tests/fixtures/report.json', 'tests/fixtures/temp/report.json');
        copy('tests/fixtures/report.html', 'tests/fixtures/temp/report.html');
    }
}
