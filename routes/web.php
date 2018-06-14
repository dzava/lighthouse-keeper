<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AuditsController@index')->name('audits');
Route::get('/reports/{report}', 'ReportsController@show')->name('reports.show');
Route::resource('runs', 'RunsController')->only(['show', 'store']);
Route::resource('audits', 'AuditsController');
Route::post('/webhooks/{audit}', 'WebhooksController')->name('webhooks');
