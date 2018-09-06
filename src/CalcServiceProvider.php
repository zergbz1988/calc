<?php

namespace Zergbz1988\Calc;

use Illuminate\Support\ServiceProvider;
use Zergbz1988\Calc\Console\CalcCommand;

class CalcServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CalcCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/calc.php', 'calc'
        );

        $this->publishes([__DIR__ . '/../config/calc.php' => config_path('calc.php')]);

        $this->app->bind(
            'Zergbz1988\Calc\Interfaces\Calc',
            config('calc.calcClass')
        );
    }
}