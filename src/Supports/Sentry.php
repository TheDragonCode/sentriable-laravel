<?php

namespace DragonCode\Sentry\Supports;

use Sentry\Laravel\Integration;
use Sentry\State\Hub;
use Sentry\State\HubInterface;
use Throwable;

class Sentry
{
    /** @var \Sentry\State\Hub */
    protected static $instance;

    public function isEnabled(): bool
    {
        return app()->bound(HubInterface::class) && ! empty($this->dsn());
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

        return $this->getInstance();
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
        $this->getInstance()->addBreadcrumb(
            Breadcrumb::make($category, $message, $data, $status_code)->get()
        );
    }

    protected function getInstance(): Hub
    {
        if (is_null(self::$instance)) {
            self::$instance = app(HubInterface::class);
        }

        return self::$instance;
    }
}
