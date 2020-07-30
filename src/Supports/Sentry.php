<?php

namespace Helldar\Sentry\Supports;

use Sentry\Laravel\Integration;
use Sentry\State\Hub;
use Throwable;

final class Sentry
{
    /** @var \Sentry\State\Hub */
    protected static $instance;

    public function __construct()
    {
        self::$instance = app('sentry');
    }

    public function isEnabled(): bool
    {
        return app()->bound('sentry') && ! empty($this->dsn());
    }

    public function flush(): void
    {
        Integration::flushEvents();
    }

    /**
     * @param  \Throwable  $e
     */
    public function exception(Throwable $e): void
    {
        if (! $this->isEnabled()) {
            return;
        }

        $this->prepare($e)->captureException($e);
    }

    protected function prepare(Throwable $e): Hub
    {
        $this->addBreadcrumb($e);

        return self::$instance;
    }

    protected function dsn(): ?string
    {
        return config('sentry.dsn');
    }

    protected function addBreadcrumb(Throwable $e): void
    {
        $breadcrumb = ParseException::make($e);

        if ($breadcrumb->isAllow()) {
            $this->addAdditionalBreadcrumb(
                $breadcrumb->getCategory(),
                $breadcrumb->getMessage(),
                $breadcrumb->getData(),
                $breadcrumb->getStatusCode()
            );
        }
    }

    protected function addAdditionalBreadcrumb(string $category, string $message, array $data, int $status_code = 0): void
    {
        self::$instance->addBreadcrumb(
            Breadcrumb::make($category, $message, $data, $status_code)->get()
        );
    }
}
