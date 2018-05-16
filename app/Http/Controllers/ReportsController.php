<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Support\Facades\Storage;

class ReportsController extends Controller
{
    public function show(Report $report)
    {
        return Storage::disk('public')->get($report->html_report);
    }
}
