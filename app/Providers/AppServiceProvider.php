<?php

namespace App\Providers;

use App\Auditing\Auditor;
use App\Auditing\LighthouseAuditor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Auditor::class,
            LighthouseAuditor::class
        );
    }
}
