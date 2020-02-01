<?php

use App\Audit;
use App\Auditing\LighthouseAuditor;
use Illuminate\Support\Facades\Route;

Route::get('/', 'AuditsController@index')->name('audits');
Route::get('/reports/{report}', 'ReportsController@show')->name('reports.show');
Route::resource('runs', 'RunsController')->only(['show', 'store']);
Route::resource('audits', 'AuditsController');
Route::post('/webhooks/{audit}', 'WebhooksController')->name('webhooks');

Route::get('/test', function () {
    /** @var LighthouseAuditor $auditor*/
    $auditor = app(LighthouseAuditor::class);

    $auditor->configureForAudit(Audit::query()->first());

    $reportPaths = $auditor->audit('http://example.com/');

    dd($reportPaths);
});
