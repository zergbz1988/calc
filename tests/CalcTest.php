<?php

use Orchestra\Testbench\TestCase;

/**
 * Class CalcTest
 */
class CalcTest extends TestCase
{
    /**
     * Проверка пустого значения в браузере
     */
    public function testEmptyInputInBrowser()
    {
        $this->get('/calc', ['input' => ''])->assertExactJson([
            'status' => 'error',
            'message' => 'Необходимо указать строковое значение поля input'
        ]);
    }

    /**
     * Проверка неправильного значения в браузере
     */
    public function testInvalidInputInBrowser()
    {
        $this->get('/calc', ['input' => '7*20+3)'])->assertExactJson([
            'status' => 'error',
            'message' => 'Передан неправильный аргумент для вычисления!'
        ]);
    }

    /**
     * Проверка сложения в браузере
     */
    public function testAddInBrowser()
    {
        $this->get('/calc', ['input' => '3+2'])->assertExactJson([
            'status' => 'ok',
            'message' => '5'
        ]);
    }

    /**
     * Проверка вычитания в браузере
     */
    public function testSubInBrowser()
    {
        $this->get('/calc', ['input' => '3-2'])->assertExactJson([
            'status' => 'ok',
            'message' => '1'
        ]);
    }

    /**
     * Проверка умножения в браузере
     */
    public function testMultiInBrowser()
    {
        $this->get('/calc', ['input' => '3*2'])->assertExactJson([
            'status' => 'ok',
            'message' => '6'
        ]);
    }

    /**
     * Проверка деления в браузере
     */
    public function testDivInBrowser()
    {
        $this->get('/calc', ['input' => '3/2'])->assertExactJson([
            'status' => 'ok',
            'message' => '1.5'
        ]);
    }

    /**
     * Проверка возведения в степень в браузере
     */
    public function testPowInBrowser()
    {
        $this->get('/calc', ['input' => '3^2'])->assertExactJson([
            'status' => 'ok',
            'message' => '9'
        ]);
    }

    /**
     * Проверка приоритетности выполнения операций в браузере
     */
    public function testPriorityInBrowser()
    {
        $this->get('/calc', ['input' => '3+2*4^2'])->assertExactJson([
            'status' => 'ok',
            'message' => '35'
        ]);
    }

    /**
     * Проверка круглых скобок в браузере
     */
    public function testBracketsInBrowser()
    {
        $this->get('/calc', ['input' => '(3+2)*4^2'])->assertExactJson([
            'status' => 'ok',
            'message' => '80'
        ]);
    }

    /**
     * Проверка пустого значения в консоли
     */
    public function testEmptyInputInConsole()
    {
        $this->artisan('calc:run', ['input' => ''])->expectsOutput("\n\nNot enough arguments (missing: \"input\").\n\n\n");
    }

    /**
     * Проверка неправильного значения в консоли
     */
    public function testInvalidInputInConsole()
    {
        $this->artisan('calc:run', ['input' => '7*20+3)'])->expectsOutput("status: error\n
        message: Передан неправильный аргумент для вычисления!\n");
    }

    /**
     * Проверка сложения в консоли
     */
    public function testAddInConsole()
    {
        $this->artisan('calc:run', ['input' => '3+2'])->expectsOutput("status: ok\n
        message: 5\n");
    }

    /**
     * Проверка вычитания в консоли
     */
    public function testSubInConsole()
    {
        $this->artisan('calc:run', ['input' => '3-2'])->expectsOutput("status: ok\n
        message: 1\n");
    }

    /**
     * Проверка умножения в консоли
     */
    public function testMultiInConsole()
    {
        $this->artisan('calc:run', ['input' => '3*2'])->expectsOutput("status: ok\n
        message: 6\n");
    }

    /**
     * Проверка деления в консоли
     */
    public function testDivInConsole()
    {
        $this->artisan('calc:run', ['input' => '3/2'])->expectsOutput("status: ok\n
        message: 1.5\n");
    }

    /**
     * Проверка возведения в степень в консоли (приходится писать ^^ вместо ^)
     */
    public function testPowInConsole()
    {
        $this->artisan('calc:run', ['input' => '3^^2'])->expectsOutput("status: ok\n
        message: 9\n");
    }

    /**
     * Проверка приоритетности выполнения операций в консоли
     */
    public function testPriorityInConsole()
    {
        $this->artisan('calc:run', ['input' => '3+2*4^^2'])->expectsOutput("status: ok\n
        message: 35\n");
    }

    /**
     * Проверка круглых скобок в консоли
     */
    public function testBracketsInConsole()
    {
        $this->artisan('calc:run', ['input' => '(3+2)*4^^2'])->expectsOutput("status: ok\n
        message: 80\n");
    }
}