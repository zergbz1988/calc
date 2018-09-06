<?php

namespace Zergbz1988\Calc\Contracts;

use Zergbz1988\Calc\CalcResult;

/**
 * Interface Calc
 * @package Zergbz1988\Calc\Contracts
 */
interface Calc
{
    /**
     * @param string $input
     * @return mixed
     */
    public function getCalcResult(string $input) : CalcResult;
}