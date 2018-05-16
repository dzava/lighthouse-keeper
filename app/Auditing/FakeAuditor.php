<?php

namespace App\Auditing;

use Dzava\Lighthouse\Exceptions\AuditFailedException;

class FakeAuditor implements Auditor
{
    public function configureForAudit($audit)
    {
        return $this;
    }

    public function audit($url)
    {
        if($url === 'invalid-url') {
            throw new AuditFailedException($url, '');
        }

        copy('tests/fixtures/report.json', 'tests/fixtures/temp/report.json');
        copy('tests/fixtures/report.html', 'tests/fixtures/temp/report.html');

        return ['tests/fixtures/temp/report.json', 'tests/fixtures/temp/report.html'];
    }
}
