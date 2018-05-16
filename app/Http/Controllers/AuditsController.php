<?php

namespace App\Http\Controllers;

use App\Audit;
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

    public function store()
    {
        $audit = Audit::create(request([
            'url', 'accessibility', 'best_practices', 'performance', 'pwa', 'seo',
        ]));

        dispatch(new RunAudit($audit));

        return redirect('/');
    }

    public function show(Audit $audit)
    {
        return view('audits.show', compact('audit'));
    }

    public function destroy(Audit $audit)
    {
        $audit->delete();

        return redirect('/');
    }
}
