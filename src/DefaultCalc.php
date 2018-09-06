<?php
/**
 * Created by PhpStorm.
 * User: komarov
 * Date: 06.09.2018
 * Time: 11:00
 */

namespace Zergbz1988\Calc;

use Zergbz1988\Calc\Contracts\Calc;

/**
 * Class DefaultCalc
 * @package Zergbz1988\Calc
 */
class DefaultCalc implements Calc
{
    private $calcResult;
    /**
     * DefaultCalc constructor.
     */
    public function __construct()
    {
        $this->calcResult = new CalcResult();
    }

    /**
     * @param string $input
     * @return CalcResult
     */
    public function getCalcResult(string $input): CalcResult
    {
        $calcArray = preg_split('/([+-\/()]{1})/', $input, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        foreach ($calcArray as $word) {
            if ($this->isOperator($word)) {

            } elseif ($this->isRoundBrackets($word)) {

            } elseif (is_numeric($word)) {

            } else {
                $this->calcResult->setErrorStatus();
                $this->calcResult->setMessage('Передан неправильный аргумент для вычисления!');

                return $this->calcResult;
            };
        }

        $this->calcResult->setOkStatus();
        $this->calcResult->setMessage('Результат');

        return $this->calcResult;
    }

    /**
     * @param string $word
     * @return bool
     */
    private function isOperator(string $word) : bool
    {
        return in_array($word, ['+', '-', '*', '/']);
    }

    /**
     * @param string $word
     * @return bool
     */
    private function isRoundBrackets(string $word) : bool
    {
        return in_array($word, ['(', ')']);
    }
}