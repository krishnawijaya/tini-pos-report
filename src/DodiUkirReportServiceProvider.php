<?php

namespace Krishnawijaya\DodiUkirReport;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Krishnawijaya\DodiUkirReport\Seed;
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

        $this->registerConsoleCommands();
        $this->registerPublishableResources();
    }

    public function boot()
    {
        $this->loadMigrationsFrom(realpath(__DIR__ . '../migrations'));
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'dodiukirreport');
    }

    private function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__) . '/publishable';
        $destinationPath = 'vendor/dodiukirreport';

        $publishable = [
            'dodiukirreport-assets' => [
                "{$publishablePath}/js/" => public_path("{$destinationPath}/js/"),
                "{$publishablePath}/css/" => public_path("{$destinationPath}/css/"),
                "{$publishablePath}/fonts/" => public_path("fonts"),
            ],
            'seeds' => [
                "{$publishablePath}/database/seeds/" => database_path(Seed::getFolderName()),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    private function registerConsoleCommands()
    {
        $this->commands(Commands\AdminCommand::class);
    }
}
