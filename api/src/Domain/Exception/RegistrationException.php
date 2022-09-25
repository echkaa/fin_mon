<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class RegistrationException extends AuthException
{
    public function __construct(
        string $message,
        ?int $statusCode = null
    ) {
        parent::__construct(
            message: $message,
            statusCode: $statusCode ?? Response::HTTP_BAD_REQUEST
        );
    }
}
