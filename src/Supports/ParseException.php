<?php

namespace DragonCode\Sentry\Supports;

use DragonCode\Sentry\Traits\Makeable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

class ParseException
{
    use Makeable;

    /** @var string[] */
    protected $allow = [ValidationException::class, RequestException::class];

    /** @var Throwable */
    protected $exception;

    public function __construct(Throwable $e)
    {
        $this->exception = $e;
    }

    public function isAllow(): bool
    {
        foreach ($this->allow as $needle) {
            if ($this->exception instanceof $needle || is_subclass_of($this->exception, $needle)) {
                return true;
            }
        }

        return false;
    }

    public function getCategory(): string
    {
        return class_basename($this->exception);
    }

    public function getMessage(): string
    {
        return $this->exception->getMessage();
    }

    public function getData(): array
    {
        if ($this->exception instanceof RequestException) {
            return $this->requestData($this->exception);
        }

        if ($this->exception instanceof ValidationException) {
            return $this->validationData($this->exception);
        }

        return [];
    }

    public function getStatusCode(): int
    {
        return method_exists($this->exception, 'getStatusCode')
            ? $this->exception->getStatusCode()
            : $this->exception->getCode();
    }

    protected function requestData(RequestException $e): array
    {
        return Arr::wrap(
            $e->response->json()
        );
    }

    protected function validationData(ValidationException $e): array
    {
        return $e->errors();
    }
}
