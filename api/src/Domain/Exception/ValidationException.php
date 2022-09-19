<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
    public function __construct(ConstraintViolationListInterface $violation)
    {
        parent::__construct(
            statusCode: Response::HTTP_BAD_REQUEST,
            message: $violation->get(0)->getMessage() ?? ''
        );
    }
}
