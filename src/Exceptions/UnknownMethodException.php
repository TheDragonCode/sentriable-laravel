<?php

namespace DragonCode\Sentry\Exceptions;

use Exception;

class UnknownMethodException extends Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
