<?php
/**
 * Created by PhpStorm.
 * User: komarov
 * Date: 06.09.2018
 * Time: 11:00
 */

namespace Zergbz1988\Calc;

use Zergbz1988\Calc\Interfaces\Calc;

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
        $input = str_replace(' ', '', $input);
        $inputStack = preg_split('/([+\-\/*()\^]{1})/', $input, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        if (empty($inputStack)) {
            return $this->errorResult();
        }

        $out = $this->getExpression($inputStack);

        if (empty($out)) {
            return $this->errorResult();
        }

        $result = $this->counting($out);

        if (empty($result)) {
            return $this->errorResult();
        }

        $result = (string) reset($result);

        return $this->okResult($result);
    }

    /**
     * @param array $input
     * @return array
     */
    private function getExpression(array $input) : array
    {
        $out = [];
        $stack = [];

        while ($word = array_shift($input)) {
            if (is_numeric($word)) {
                array_push($out, $word);
            } elseif ($this->isRoundBrackets($word)) {
                if ($word === '(') {
                    array_push($stack, $word);
                } else {
                    if (!in_array('(', $stack)) {
                        return [];
                    }
                    while (($tmp = array_pop($stack)) !== '(') {
                        array_push($out, $tmp);
                    }
                }
            } elseif ($this->isOperator($word)) {
                for ($j = count($stack) - 1; $j >= 0; --$j) {
                    if ($this->getPriority($stack[$j]) < $this->getPriority($word)) {
                        break;
                    }
                    $out[] = $stack[$j];
                    unset($stack[$j]);
                }
                $stack = array_values($stack);
                array_push($stack, $word);
            } else {
                return [];
            };
        }

        if ($stack) {
            $out = array_merge($out, array_reverse($stack));
        }

        return $out;
    }

    /**
     * @param array $input
     * @return array
     */
    private function counting(array $input) : array
    {
        $out = [];

        while ($word = array_shift($input)) {
            if (is_numeric($word)) {
                array_push($out, $word);
            } else {
                $num1 = array_pop($out);
                $num2 = array_pop($out);

                if (!isset($num1) || !isset($num2)) {
                    return [];
                }

                switch ($word) {
                    case '+':
                        $tmp = $num2 + $num1;
                        break;
                    case '-':
                        $tmp = $num2 - $num1;
                        break;
                    case '*':
                        $tmp = $num2 * $num1;
                        break;
                    case '/':
                        $tmp = $num2 / $num1;
                        break;
                    case '^':
                        $tmp = pow($num2, $num1);
                        break;
                    default:
                        $tmp = $num2 + $num1;
                }
                array_push($out, $tmp);
            }
        }

        return $out;
    }

    /**
     * @param string $word
     * @return bool
     */
    private function isOperator(string $word): bool
    {
        return in_array($word, ['+', '-', '*', '/', '^']);
    }

    /**
     * @param string $word
     * @return bool
     */
    private function isRoundBrackets(string $word): bool
    {
        return in_array($word, ['(', ')']);
    }

    /**
     * @param string $operator
     * @return int
     */
    private function getPriority(string $operator) : int
    {
        switch ($operator) {
            case '(':
                return 0;
            case ')':
                return 1;
            case '+':
                return 2;
            case '-':
                return 3;
            case '*':
                return 4;
            case '/':
                return 4;
            case '^':
                return 5;
            default:
                return 6;
        }
    }

    /**
     * @param string $message
     * @return CalcResult
     */
    private function errorResult(string $message = 'Передан неправильный аргумент для вычисления!'): CalcResult
    {
        $this->calcResult->setErrorStatus();
        $this->calcResult->setMessage($message);
        return $this->calcResult;
    }

    /**
     * @param string $result
     * @return CalcResult
     */
    private function okResult(string $result): CalcResult
    {
        $this->calcResult->setOkStatus();
        $this->calcResult->setMessage($result);
        return $this->calcResult;
    }
}