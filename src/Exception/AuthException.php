<?php

namespace App\Exception;

class AuthException extends ApiException
{
    protected int $statusCode = 500;
    protected string $errorCode = 'database_error';

    public function __construct(string $message = 'Authetication error', array $details = [])
    {
        parent::__construct($message);
        $this->details = $details;
    }
}
