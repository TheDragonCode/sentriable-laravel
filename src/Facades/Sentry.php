<?php

namespace Helldar\Sentry\Facades;

use Helldar\Sentry\Supports\Sentry as Instance;
use Illuminate\Support\Facades\Facade;
use Throwable;

/**
 * @method static bool isEnabled()
 * @method static void flush()
 * @method static void exception(Throwable $e)
 */
class Sentry extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Instance::class;
    }
}
