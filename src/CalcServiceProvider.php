<?php

namespace Zergbz1988\Calc;

use Illuminate\Support\ServiceProvider;

/**
 * Class CalcServiceProvider
 * @package Zergbz1988\Calc
 */
class CalcServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                'Zergbz1988\Calc\Console\CalcCommand',
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/calc.php', 'calc'
        );

        $this->publishes([__DIR__ . '/../config/calc.php' => config_path('calc.php')]);

        $calcClass = config('calc.calcClass');

        $this->app->bind(
            'Zergbz1988\Calc\Interfaces\Calc',
            $calcClass
        );

        $this->app->make('Zergbz1988\Calc\CalcController');
    }

    protected function loadRoutesFrom($path)
    {
        if (! $this->app->routesAreCached()) {
            require $path;
        }
    }

}