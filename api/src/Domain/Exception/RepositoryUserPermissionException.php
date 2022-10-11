<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RepositoryUserPermissionException extends HttpException
{
    public function __construct(?string $message = null)
    {
        parent::__construct(
            statusCode: Response::HTTP_BAD_REQUEST,
            message: $message ?? 'User permission denied',
        );
    }
}
