<?php

namespace App\Providers;

use Dzava\Lighthouse\Lighthouse;
use Illuminate\Support\ServiceProvider;

class LighthouseServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(Lighthouse::class, function () {
            return (new Lighthouse())
                ->setChromePath(env('CHROME_PATH'))
                ->setLighthousePath(base_path(env('LIGHTHOUSE_PATH')));
        });
    }

    public function provides()
    {
        return [Lighthouse::class];
    }
}
