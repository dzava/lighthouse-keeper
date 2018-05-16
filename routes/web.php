<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AuditsController@index')->name('audits');
Route::get('/reports/{report}', 'ReportsController@show')->name('reports.show');
Route::get('/runs/{run}', 'RunsController@show')->name('runs.show');
Route::resource('audits', 'AuditsController');
