<?php

namespace DragonCode\Sentry\Console;

use DragonCode\Sentry\Facades\Sha;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class Version extends Command
{
    protected $signature = 'git:version';

    protected $description = 'Get the version of the current release';

    public function handle()
    {
        if (! $this->gitDirExist()) {
            $this->warn('.git directory not exist!');

            return;
        }

        $this->store();

        $this->info('Version was stored successfully.');
    }

    protected function store(): void
    {
        $hash = $this->getVersion() ?: $this->getSha();

        file_put_contents(
            Sha::path(),
            trim($hash)
        );
    }

    protected function log(string $format): string
    {
        return 'git --git-dir ' . $this->gitDir() . ' log --pretty="' . $format . '" -n1 HEAD';
    }

    protected function hashCommand(): string
    {
        return $this->log('%h');
    }

    protected function tagsCommand(): string
    {
        return $this->log('%d');
    }

    protected function getVersion(): ?string
    {
        $value = $this->read(
            $this->tagsCommand()
        );

        preg_match('/v\d+\.\d+\.\d+/', $value, $match);

        return Arr::first($match);
    }

    protected function getSha(): ?string
    {
        return $this->read(
            $this->hashCommand()
        );
    }

    protected function gitDirExist(): bool
    {
        if ($dir = $this->gitDir()) {
            return file_exists($dir);
        }

        return false;
    }

    protected function gitDir(): ?string
    {
        return realpath(base_path('.git'));
    }

    protected function read(string $command): ?string
    {
        return exec($command);
    }
}
