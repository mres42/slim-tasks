<?php

namespace App\Exception;

class DatabaseException extends ApiException
{
    protected int $statusCode = 500;
    protected string $errorCode = 'database_error';

    public function __construct(string $message = 'Database error', array $details = [])
    {
        parent::__construct($message);
        $this->details = $details;
    }
}
