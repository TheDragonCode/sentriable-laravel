<?php

namespace DragonCode\Sentry\Traits;

trait Makeable
{
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }
}
