<?php

namespace Helldar\Sentry\Supports;

use Helldar\Sentry\Traits\Makeable;

final class Sha
{
    use Makeable;

    public const FILENAME = 'version.json';

    public static function path(): string
    {
        return storage_path('app' . DIRECTORY_SEPARATOR . static::FILENAME);
    }

    public function get(): ?string
    {
        return $this->fileExist()
            ? trim($this->read())
            : null;
    }

    protected function read(): string
    {
        return file_get_contents(static::path());
    }

    protected function fileExist(): bool
    {
        return file_exists(static::path());
    }
}
