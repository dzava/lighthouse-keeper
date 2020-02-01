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

        copy(base_path('tests/fixtures/report.json'), base_path('tests/fixtures/temp/report.json'));
        copy(base_path('tests/fixtures/report.html'), base_path('tests/fixtures/temp/report.html'));

        return [base_path('tests/fixtures/temp/report.json'), base_path('tests/fixtures/temp/report.html')];
    }
}
