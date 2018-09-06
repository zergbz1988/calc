<?php
/**
 * Created by PhpStorm.
 * User: Marat
 * Date: 06.09.2018
 * Time: 22:23
 */

namespace Zergbz1988\Calc\Facades;


use Illuminate\Support\Facades\Facade;

class Calc extends Facade
{
    protected static function getFacadeAccessor() { return 'calc'; }
}