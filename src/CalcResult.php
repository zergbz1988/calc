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

    const DEFAULT_MESSAGE = 'Пустой результат';

    private $status;
    private $message;

    /**
     * @return string
     */
    public function getStatus()
    {
        return isset($this->status) ? $this->status : self::STATUS_ERROR;
    }


    public function setOkStatus()
    {
        $this->status = self::STATUS_OK;
    }


    public function setErrorStatus()
    {
        $this->status = self::STATUS_ERROR;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return isset($this->message) ? $this->message : self::DEFAULT_MESSAGE;
    }

    /**
     * @param $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'status' => $this->getStatus(),
            'message' => $this->getMessage()
        ];
    }
}