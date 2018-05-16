<?php

namespace Tests\Unit\Auditing;

use App\Auditing\FakeAuditor;
use Tests\TestCase;

class FakeAuditorTest extends TestCase
{
    use AuditorTests;

    public function getAuditor()
    {
        return new FakeAuditor();
    }
}
