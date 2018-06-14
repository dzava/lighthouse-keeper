<?php

namespace App\Http\Controllers;

use App\Audit;
use App\Chart;
use App\Jobs\RunAudit;

class AuditsController extends Controller
{
    public function index()
    {
        $audits = Audit::leftJoin('runs', 'audits.id', '=', 'runs.audit_id')
            ->distinct()
            ->latest('runs.created_at')
            ->groupBy('audits.id')
            ->select('audits.*')
            ->with('latestRun')
            ->get();

        return view('audits.index', compact('audits'));
    }

    public function create()
    {
        return view('audits.create');
    }

    public function store()
    {
        $audit = Audit::create(request([
            'name', 'urls', 'audits',
        ]));

        if (request('run_immediately')) {
            dispatch(new RunAudit($audit));
        }

        success("Audit '{$audit->name}' created successfully");

        return redirect()->route('audits.edit', $audit);
    }

    public function edit(Audit $audit)
    {
        return view('audits.edit', compact('audit'));
    }

    public function update(Audit $audit)
    {
        request()->merge([
            'headers' => request('headers', []),
            'webhook_enabled' => request('webhook_enabled', false),
        ]);

        $audit->update(request([
            'name', 'urls', 'audits', 'headers', 'timeout', 'webhook_enabled', 'webhook_branch', 'webhook_delay',
        ]));

        success("Audit '{$audit->name}' updated successfully");

        return redirect()->route('audits.edit', $audit);
    }

    public function show(Audit $audit)
    {
        $runs = $audit->runs()->latest()->take(20)->get()->reverse();

        $chart = new Chart($runs);

        return view('audits.show', compact('audit', 'chart'));
    }

    public function destroy(Audit $audit)
    {
        $audit->delete();

        return redirect('/');
    }
}
