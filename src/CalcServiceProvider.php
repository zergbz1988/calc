<?php

namespace Zergbz1988\Calc;

use Illuminate\Support\ServiceProvider;

class CalcServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/calc.php', 'calc');
    }
}