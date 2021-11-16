<?php

namespace DragonCode\Sentry\Facades;

use DragonCode\Sentry\Exceptions\UnknownMethodException;
use DragonCode\Sentry\Supports\Sha as Instance;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string path()
 * @method static string|null get()
 */
class Sha extends Facade
{
    protected static $instance;

    /**
     * @param  string  $method
     * @param  array  $arguments
     *
     * @throws \DragonCode\Sentry\Exceptions\UnknownMethodException
     *
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if (self::methodExist($method)) {
            return self::callMethod($method);
        }

        throw new UnknownMethodException();
    }

    protected static function resolve(): Instance
    {
        if (is_null(self::$instance)) {
            self::$instance = Instance::make();
        }

        return self::$instance;
    }

    protected static function callMethod(string $method)
    {
        return self::resolve()->{$method}();
    }

    protected static function methodExist(string $method): bool
    {
        return method_exists(self::resolve(), $method);
    }
}
