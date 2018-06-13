<?php

namespace App\Http\Controllers;

use App\Audit;
use App\Jobs\RunAudit;
use App\Run;

class RunsController extends Controller
{
    public function show(Run $run)
    {
        return view('runs.show', compact('run'));
    }

    public function store()
    {
        $audit = Audit::findOrFail(request('audit'));

        dispatch(new RunAudit($audit));

        success("Scheduled audit '{$audit->name}' to be run");

        return redirect()->route('audits.show', $audit);
    }
}
