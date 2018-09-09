<?php

namespace Zergbz1988\Calc;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class CalcServiceProvider
 * @package Zergbz1988\Calc
 */
class CalcServiceProvider extends ServiceProvider
{

    public static $publishes = [];

    public static $publishGroups = [];

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

        $this->publishes([__DIR__ . '/../config/calc.php' => base_path('config' . DIRECTORY_SEPARATOR . 'calc.php')]);

        $calcClass = Config::get('calc.calcClass');

        $this->app->bind(
            'Zergbz1988\Calc\Interfaces\Calc',
            $calcClass
        );

        $this->app->make('Zergbz1988\Calc\CalcController');
    }

    protected function loadRoutesFrom($path)
    {
        require $path;
    }

    protected function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set($key, array_merge(require $path, $config));
    }

    /**
     * Register paths to be published by the publish command.
     *
     * @param  array  $paths
     * @param  string  $group
     * @return void
     */
    protected function publishes(array $paths, $group = null)
    {
        $class = 'Zergbz1988\Calc\CalcServiceProvider';

        if (! array_key_exists($class, static::$publishes)) {
            static::$publishes[$class] = [];
        }

        static::$publishes[$class] = array_merge(static::$publishes[$class], $paths);

        if ($group) {
            if (! array_key_exists($group, static::$publishGroups)) {
                static::$publishGroups[$group] = [];
            }

            static::$publishGroups[$group] = array_merge(static::$publishGroups[$group], $paths);
        }
    }
}