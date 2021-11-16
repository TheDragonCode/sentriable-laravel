<?php

namespace DragonCode\Sentry;

use DragonCode\Sentry\Console\Version;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            Version::class,
        ]);
    }
}
