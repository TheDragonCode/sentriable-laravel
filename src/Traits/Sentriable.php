<?php

namespace DragonCode\Sentry\Traits;

use DragonCode\Sentry\Facades\Sentry;
use Throwable;

trait Sentriable
{
    protected function sentryException(Throwable $e): void
    {
        Sentry::exception($e);
    }

    protected function sentryFlush(): void
    {
        Sentry::flush();
    }
}
