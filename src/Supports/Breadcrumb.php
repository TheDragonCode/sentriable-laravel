<?php

namespace Helldar\Sentry\Supports;

use Helldar\Sentry\Traits\Makeable;
use Sentry\Breadcrumb as Sentry;

class Breadcrumb
{
    use Makeable;

    protected $data;

    protected $category;

    protected $status_code;

    protected $message;

    public function __construct(string $category, string $message, array $data, int $status_code = 0)
    {
        $this->data        = $data;
        $this->category    = $category;
        $this->message     = $message;
        $this->status_code = $status_code;
    }

    public function get(): Sentry
    {
        return Sentry::fromArray(
            $this->toArray()
        );
    }

    public function toArray()
    {
        return [
            'level'    => $this->getLevel(),
            'category' => $this->getCategory(),
            'message'  => $this->getMessage(),
            'data'     => $this->getData(),
        ];
    }

    protected function getLevel(): string
    {
        $code = $this->status_code;

        switch (true) {
            case ! $code || $code >= 500:
                return Sentry::LEVEL_ERROR;
            case $code >= 400:
                return Sentry::LEVEL_WARNING;
            default:
                return Sentry::LEVEL_INFO;
        }
    }

    protected function getCategory(): string
    {
        return $this->category;
    }

    protected function getMessage(): string
    {
        return $this->message;
    }

    protected function getData(): array
    {
        return ['content' => $this->data];
    }
}
