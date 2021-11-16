<?php

namespace Helldar\Sentry\Supports;

use Helldar\Sentry\Traits\Makeable;

class Sha
{
    use Makeable;

    public const FILENAME = 'version.json';

    public function path(): string
    {
        return storage_path('app' . DIRECTORY_SEPARATOR . self::FILENAME);
    }

    public function get(): ?string
    {
        return $this->fileExist()
            ? trim($this->read())
            : null;
    }

    protected function read(): string
    {
        return file_get_contents($this->path());
    }

    protected function fileExist(): bool
    {
        return file_exists($this->path());
    }
}
