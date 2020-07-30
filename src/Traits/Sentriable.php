<?php

namespace Helldar\Sentry\Traits;

use Helldar\Sentry\Facades\Sentry;

trait Sentriable
{
    protected function sentryException(\Throwable $e): void
    {
        Sentry::exception($e);
    }

    protected function sentryFlush(): void
    {
        Sentry::flush();
    }
}
