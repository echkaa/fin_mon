<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthException extends HttpException
{
    public function __construct(
        string $message = '',
        ?int $statusCode = null
    ) {
        parent::__construct(
            statusCode: $statusCode ?? Response::HTTP_UNAUTHORIZED,
            message: $message,
        );
    }
}
