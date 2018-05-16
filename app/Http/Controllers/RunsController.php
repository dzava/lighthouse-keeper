<?php

namespace App\Http\Controllers;

use App\Run;

class RunsController extends Controller
{
    public function show(Run $run)
    {
        return view('runs.show', compact('run'));
    }
}
