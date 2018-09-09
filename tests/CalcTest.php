<?php

use Orchestra\Testbench\TestCase;
use Zergbz1988\Calc\Interfaces\Calc;

/**
 * Class CalcTest
 * @property Calc $calc
 *
 */
class CalcTest extends TestCase
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

    /**** FUNCTIONAL TESTS ****/

    /**
     * Проверка пустого значения в консоли
     */
    public function testEmptyInputInConsole()
    {
        $this->setExpectedException('RuntimeException');
        $this->artisan('calc:run');
    }

    /**
     * Проверка неправильного значения в консоли
     */
    public function testInvalidInputInConsole()
    {
        $this->expectOutputString("status: error\nmessage: Передан неправильный аргумент для вычисления!\n");
        $this->artisan('calc:run', ['input' => '7*20+3)']);
    }

    /**
     * Проверка сложения в консоли
     */
    public function testAddInConsole()
    {
        $this->expectOutputString("status: ok\nmessage: 5\n");
        $this->artisan('calc:run', ['input' => '3+2']);
    }

    /**
     * Проверка вычитания в консоли
     */
    public function testSubInConsole()
    {
        $this->expectOutputString("status: ok\nmessage: 1\n");
        $this->artisan('calc:run', ['input' => '3-2']);
    }

    /**
     * Проверка умножения в консоли
     */
    public function testMultiInConsole()
    {
        $this->expectOutputString("status: ok\nmessage: 6\n");
        $this->artisan('calc:run', ['input' => '3*2']);
    }

    /**
     * Проверка деления в консоли
     */
    public function testDivInConsole()
    {
        $this->expectOutputString("status: ok\nmessage: 1.5\n");
        $this->artisan('calc:run', ['input' => '3/2']);
    }

    /**
     * Проверка возведения в степень в консоли
     */
    public function testPowInConsole()
    {
        $this->expectOutputString("status: ok\nmessage: 9\n");
        $this->artisan('calc:run', ['input' => '3^2']);
    }

    /**
     * Проверка приоритетности выполнения операций в консоли
     */
    public function testPriorityInConsole()
    {
        $this->expectOutputString("status: ok\nmessage: 35\n");
        $this->artisan('calc:run', ['input' => '3+2*4^2']);
    }

    /**
     * Проверка круглых скобок в консоли
     */
    public function testBracketsInConsole()
    {
        $this->expectOutputString("status: ok\nmessage: 80\n");
        $this->artisan('calc:run', ['input' => '(3+2)*4^2']);
    }

    /**
     * Проверка пустого значения в браузере
     */
    public function testEmptyInputInBrowser()
    {
        $this->get('/calc?input=')->assertJson(json_encode([
            'status' => 'error',
            'message' => 'Необходимо указать строковое значение поля input'
        ]));
    }

    /**
     * Проверка неправильного значения в браузере
     */
    public function testInvalidInputInBrowser()
    {
        $this->get('/calc?input=7*20+3)')->assertJson(json_encode([
            'status' => 'error',
            'message' => 'Передан неправильный аргумент для вычисления!'
        ]));
    }

    /**
     * Проверка сложения в браузере
     */
    public function testAddInBrowser()
    {
        $this->get('/calc?input=3+2')->assertJson(json_encode([
            'status' => 'ok',
            'message' => '5'
        ]));
    }

    /**
     * Проверка вычитания в браузере
     */
    public function testSubInBrowser()
    {
        $this->get('/calc?input=3-2')->assertJson(json_encode([
            'status' => 'ok',
            'message' => '1'
        ]));
    }

    /**
     * Проверка умножения в браузере
     */
    public function testMultiInBrowser()
    {
        $this->get('/calc?input=3*2')->assertJson(json_encode([
            'status' => 'ok',
            'message' => '6'
        ]));
    }

    /**
     * Проверка деления в браузере
     */
    public function testDivInBrowser()
    {
        $this->get('/calc?input=3/2')->assertJson(json_encode([
            'status' => 'ok',
            'message' => '1.5'
        ]));
    }

    /**
     * Проверка возведения в степень в браузере
     */
    public function testPowInBrowser()
    {
        $this->get('/calc?input=3^2')->assertJson(json_encode([
            'status' => 'ok',
            'message' => '9'
        ]));
    }

    /**
     * Проверка приоритетности выполнения операций в браузере
     */
    public function testPriorityInBrowser()
    {
        $this->get('/calc?input=3+2*4^2')->assertJson(json_encode([
            'status' => 'ok',
            'message' => '35'
        ]));
    }

    /**
     * Проверка круглых скобок в браузере
     */
    public function testBracketsInBrowser()
    {
        $this->get('/calc?input=(3+2)*4^2')->assertJson(json_encode([
            'status' => 'ok',
            'message' => '80'
        ]));
    }
}