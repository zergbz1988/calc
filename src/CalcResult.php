<?php

namespace Zergbz1988\Calc;

/**
 * Class CalcResult
 * @package Zergbz1988\Calc
 */
class CalcResult
{
    const STATUS_OK = 'ok';
    const STATUS_ERROR = 'error';

    private $status;
    private $message;

    /**
     * @return string
     */
    public function getStatus() : string
    {
        return $this->status;
    }


    public function setOkStatus() : void
    {
        $this->status = self::STATUS_OK;
    }


    public function setErrorStatus() : void
    {
        $this->status = self::STATUS_ERROR;
    }


    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message) : void
    {
        $this->message = $message;
    }
}