<?php

namespace Helldar\Sentry\Exceptions;

use Throwable;

final class UnknownMethodException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
