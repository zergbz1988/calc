<?php

use Orchestra\Testbench\TestCase;
use Zergbz1988\Calc\Interfaces\Calc;

/**
 * Class CalcTest
 * @property Calc $calc
 *
 */
class CalcTest54 extends TestCase
{
    protected $calc = null;

    protected function getPackageProviders()
    {
        return ['Zergbz1988\Calc\CalcServiceProvider'];
    }

    /**
     *  зададим значение Zergbz1988\Calc\Interfaces\Calc $calc
     */
    public function setUp()
    {
        parent::setUp();
        $this->calc = app()->make('Zergbz1988\Calc\Interfaces\Calc');
    }

    /**** UNIT TESTS ****/

    /**
     * Проверка пустого значения
     */
    public function testEmptyInput()
    {
        $this->assertEquals(
            [
                'status' => 'error',
                'message' => 'Необходимо указать строковое значение поля input'
            ],
            $this->calc->getCalcResult('')->toArray()
        );
    }

    /**
     * Проверка неправильного значения
     */
    public function testInvalidInput()
    {
        $this->assertEquals(
            [
                'status' => 'error',
                'message' => 'Передан неправильный аргумент для вычисления!'
            ],
            $this->calc->getCalcResult('7*20+3)')->toArray()
        );
    }

    /**
     * Проверка сложения
     */
    public function testAdd()
    {
        $this->assertEquals(
            [
                'status' => 'ok',
                'message' => '5'
            ],
            $this->calc->getCalcResult('3+2')->toArray()
        );
    }

    /**
     * Проверка вычитания
     */
    public function testSub()
    {
        $this->assertEquals(
            [
                'status' => 'ok',
                'message' => '1'
            ],
            $this->calc->getCalcResult('3-2')->toArray()
        );
    }

    /**
     * Проверка умножения
     */
    public function testMulti()
    {
        $this->assertEquals(
            [
                'status' => 'ok',
                'message' => '6'
            ],
            $this->calc->getCalcResult('3*2')->toArray()
        );
    }

    /**
     * Проверка деления
     */
    public function testDiv()
    {
        $this->assertEquals(
            [
                'status' => 'ok',
                'message' => '1.5'
            ],
            $this->calc->getCalcResult('3/2')->toArray()
        );
    }

    /**
     * Проверка возведения в степень
     */
    public function testPow()
    {
        $this->assertEquals(
            [
                'status' => 'ok',
                'message' => '9'
            ],
            $this->calc->getCalcResult('3^2')->toArray()
        );
    }

    /**
     * Проверка приоритетности выполнения операций
     */
    public function testPriority()
    {
        $this->assertEquals(
            [
                'status' => 'ok',
                'message' => '35'
            ],
            $this->calc->getCalcResult('3+2*4^2')->toArray()
        );
    }

    /**
     * Проверка круглых скобок
     */
    public function testBrackets()
    {
        $this->assertEquals(
            [
                'status' => 'ok',
                'message' => '80'
            ],
            $this->calc->getCalcResult('(3+2)*4^2')->toArray()
        );
    }
}