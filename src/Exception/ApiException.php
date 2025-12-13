<?php

namespace App\Exception;

abstract class ApiException extends \RuntimeException
{
    protected int $statusCode = 500;
    protected string $errorCode = 'internal_error';
    protected array $details = [];

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
