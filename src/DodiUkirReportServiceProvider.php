<?php

namespace Krishnawijaya\DodiUkirReport;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Krishnawijaya\DodiUkirReport\Facades\DodiUkirReportFacade;

class DodiUkirReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('DodiUkirReport', DodiUkirReportFacade::class);

        $this->app->singleton('dodiukirreport', function () {
            return new DodiUkirReport();
        });
    }

    public function boot()
    {
        $this->loadMigrationsFrom(realpath(__DIR__ . '../migrations'));
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dodiukirreport');

        $this->publishes([__DIR__ . '/../publishable/js' => public_path('vendor/dodiukirreport/js')]);
    }
}
