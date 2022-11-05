<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EntityExistException extends HttpException
{
    public function __construct(
        string $message = 'Entity exist',
    ) {
        parent::__construct(
            statusCode: Response::HTTP_BAD_REQUEST,
            message: $message
        );
    }
}
