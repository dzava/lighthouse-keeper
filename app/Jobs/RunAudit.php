<?php

namespace App\Jobs;

use App\Audit;
use App\Auditing\Auditor;
use App\Events\ReportCreatedEvent;
use App\Events\RunFinishedEvent;
use App\Run;
use Dzava\Lighthouse\Exceptions\AuditFailedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class RunAudit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Audit */
    public $audit;

    /**
     * Create a new job instance.
     *
     * @param Audit $audit
     */
    public function __construct($audit)
    {
        $this->audit = $audit;
    }

    /**
     * Execute the job.
     *
     * @param Auditor $auditor
     * @return void
     */
    public function handle(Auditor $auditor)
    {
        $run = Run::forAudit($this->audit);
        $auditor->configureForAudit($this->audit);

        collect($this->audit->urls)->each(function ($url) use ($auditor, $run) {
            $this->auditUrl($auditor, $url, $run);
        });

        event(new RunFinishedEvent($run));
    }

    /**
     * @param Auditor $auditor
     * @param string $url
     * @param Run $run
     */
    protected function auditUrl(Auditor $auditor, $url, $run): void
    {
        try {
            $reportPaths = $auditor->audit($url);

            $report = $run->addReport($url, ...$reportPaths);
        } catch (ProcessTimedOutException $e) {
            $report = $run->addFailedReport($url, 'Timed out');
        } catch (AuditFailedException $e) {
            $report = $run->addFailedReport($url, $e->getOutput());
        } catch (\Exception $e) {
            $report = $run->addFailedReport($url, $e->getMessage());
        }

        event(new ReportCreatedEvent($report));
    }
}
