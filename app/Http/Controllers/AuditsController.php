<?php

namespace App\Http\Controllers;

use App\Audit;
use App\Chart;
use App\Jobs\RunAudit;

class AuditsController extends Controller
{
    public function index()
    {
        $audits = Audit::join('runs', 'audits.id', '=', 'runs.audit_id')
            ->distinct()
            ->latest('runs.created_at')
            ->groupBy('audit_id')
            ->select('audits.*')
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
            'name', 'urls', 'accessibility', 'best_practices', 'performance', 'pwa', 'seo', 'headers', 'timeout',
        ]));

        dispatch(new RunAudit($audit));

        return redirect('/');
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
