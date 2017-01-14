<?php

namespace Controller;

use Utils\MessageCode;

class X extends \Exception
{
    protected $message = '';

    public function __construct(MessageCode $errorMsg)
    {
        $this->message = $errorMsg->getMessage();
    }

    public function getError()
    {
        return [
            'Status'    => 0,
            'Message'   => $this->message,
        ];
    }
}
