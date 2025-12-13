<?php

namespace App\Exception;

class ValidationException extends ApiException
{
    protected int $statusCode = 400;
    protected string $errorCode = 'validation_error';

    public function __construct(string $message = 'Invalid request', array $details = [])
    {
        parent::__construct($message);
        $this->details = $details;
    }
}
