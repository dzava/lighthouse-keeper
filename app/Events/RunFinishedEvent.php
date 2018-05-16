<?php

namespace App\Events;

use App\Run;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RunFinishedEvent
{
    use Dispatchable, SerializesModels;

    /** @var Run */
    public $run;

    /**
     * Create a new event instance.
     *
     * @param Run $run
     */
    public function __construct($run)
    {
        $this->run = $run;
    }
}
