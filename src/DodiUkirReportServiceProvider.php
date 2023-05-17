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

        $this->registerPublishableResources();
    }

    public function boot()
    {
        $this->loadMigrationsFrom(realpath(__DIR__ . '../migrations'));
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'dodiukirreport');

        $this->publishes([dirname(__DIR__) . '/publishable/js' => public_path('vendor/dodiukirreport/js')]);
    }

    private function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__) . '/publishable';

        $publishable = [
            'seeds' => [
                "{$publishablePath}/database/seeds/" => database_path(Seed::getFolderName()),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }
}
