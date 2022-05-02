<?php

namespace App\Application\Command\Operation\List;

use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OperationStoreHandler implements MessageHandlerInterface
{
    /**
     * @throws Exception
     */
    public function __invoke(OperationListCommand $command): ResponseInterface
    {
        return new HttpResponse(
            status: Response::HTTP_CREATED,
            body: json_encode([])
        );
    }
}
