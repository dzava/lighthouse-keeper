<?php

namespace Tests\Unit\Auditing;

use Dzava\Lighthouse\Exceptions\AuditFailedException;

trait AuditorTests
{
    /** @test */
    public function returns_the_report_paths_when_an_audit_is_successful()
    {
        $auditor = $this->getAuditor();

        $paths = $auditor->audit('https://example.com');

        $this->assertCount(2, $paths);
        $this->assertFileExists($paths[0]);
        $this->assertFileExists($paths[1]);
    }

    /** @test */
    public function throws_an_exception_when_an_audit_fails()
    {
        $this->expectException(AuditFailedException::class);

        $auditor = $this->getAuditor();

        $auditor->audit('invalid-url');
    }
}
