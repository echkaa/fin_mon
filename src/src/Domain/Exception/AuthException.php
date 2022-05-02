<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthException extends HttpException
{
    public function __construct(
        string $message = '',
    ) {
        parent::__construct(
            statusCode: Response::HTTP_UNAUTHORIZED,
            message: $message,
        );
    }
}
