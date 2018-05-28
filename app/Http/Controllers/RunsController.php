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
        $audit = Audit::find(request('audit'));

        dispatch(new RunAudit($audit));

        return redirect()->route('audits.show', $audit);
    }
}
