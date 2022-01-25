<?php

namespace EllipticMarketing\Larasapien;

use Illuminate\Support\ServiceProvider;
use EllipticMarketing\Larasapien\Console\CheckCommand;
use EllipticMarketing\Larasapien\Contracts\MonitorContract;
use EllipticMarketing\Larasapien\Checkers\GeneralChecker;

class LarasapienServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/larasapien.php' => config_path('larasapien.php'),
        ], 'larasapien-config');

        if ($this->app->runningInConsole()) {
            $this->commands([CheckCommand::class]);
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/larasapien.php', 'larasapien'
        );

        $this->app->singleton(MonitorContract::class, function($app) {
            return (new LarasapienMonitor(config('larasapien.checkers')))
                ->checker(GeneralChecker::class);
        });
    }
}
