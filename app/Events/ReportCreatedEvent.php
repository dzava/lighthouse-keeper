<?php

namespace App\Events;

use App\Report;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportCreatedEvent
{
    use Dispatchable, SerializesModels;

    /** @var Report */
    public $report;

    /**
     * Create a new event instance.
     *
     * @param Report $report
     */
    public function __construct($report)
    {
        $this->report = $report;
    }
}
