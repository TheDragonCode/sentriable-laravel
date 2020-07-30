<?php

namespace Helldar\Sentry\Facades;

use Helldar\Sentry\Exceptions\UnknownMethodException;
use Helldar\Sentry\Supports\Sha as Instance;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string path()
 * @method static string|null get()
 */
final class Sha extends Facade
{
    protected static $instance;

    /**
     * @param  string  $method
     * @param  array  $arguments
     *
     * @throws \Helldar\Sentry\Exceptions\UnknownMethodException
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
