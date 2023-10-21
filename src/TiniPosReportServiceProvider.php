<?php

namespace KrishnaWijaya\TiniPosReport;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\AliasLoader;
use KrishnaWijaya\TiniPosReport\Facades\TiniPosReportFacade;
use KrishnaWijaya\TiniPosReport\Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class TiniPosReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('TiniPosReport', TiniPosReportFacade::class);

        $this->app->singleton('tiniposreport', function () {
            return new TiniPosReport();
        });

        $this->registerConsoleCommands();
        $this->registerPublishableResources();
    }

    public function boot()
    {
        $this->registerNewPermissions();

        $this->loadMigrationsFrom(realpath(__DIR__ . '../migrations'));
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'tiniposreport');
    }

    private function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__) . '/publishable';
        $destinationPath = 'vendor/tiniposreport';

        $publishable = [
            'tiniposreport-assets' => [
                "{$publishablePath}/js/" => public_path("{$destinationPath}/js/"),
                "{$publishablePath}/css/" => public_path("{$destinationPath}/css/"),
                "{$publishablePath}/fonts/" => public_path("fonts"),
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

    public function registerNewPermissions()
    {
        foreach (PermissionSeeder::PERMISSIONS as $permissions) {
            foreach ($permissions as $key) {
                Gate::define($key, function ($user) use ($key) {
                    return $user->hasPermission($key);
                });
            }
        }
    }
}
