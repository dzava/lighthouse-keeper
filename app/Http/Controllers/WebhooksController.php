<?php

namespace App\Http\Controllers;

use App\Audit;
use App\Jobs\RunAudit;

class WebhooksController extends Controller
{
    public function __invoke($auditId)
    {
        $audit = Audit::find($auditId);

        if (!$this->shouldRun($audit)) {
            return;
        }

        $this->dispatch((new RunAudit($audit))->delay($audit->webhook_delay));
    }

    protected function shouldRun($audit)
    {
        if (!$audit) {
            return false;
        }

        if ($audit->webhook_enabled === false) {
            return false;
        }

        if (is_null($audit->webhook_branch)) {
            return true;
        }

        $ref = array_get(request(), 'ref', false);

        if ($ref === false) {
            return false;
        }

        $branch = array_last(preg_split('|/|', $ref));

        return $branch === $audit->webhook_branch;
    }
}
