<?php

namespace App\Auditing;

use App\Audit;

interface Auditor
{
    /**
     * @param Audit $audit
     * @return mixed
     */
    public function configureForAudit($audit);

    /**
     * @param string $url
     * @return array
     * @throws \Dzava\Lighthouse\Exceptions\AuditFailedException
     */
    public function audit($url);
}
