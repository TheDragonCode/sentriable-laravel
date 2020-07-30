<?php

namespace Helldar\Sentry\Facades;

use Helldar\Sentry\Supports\Sha as Instance;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string path()
 * @method static string|null get()
 */
final class Sha extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Instance::class;
    }
}
