<?php

namespace App\Application\Command\Operation\Update;

use App\Application\Service\OperationService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OperationUpdateHandler implements MessageHandlerInterface
{
    public function __construct(
        private OperationService $operationService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(OperationUpdateCommand $command): ResponseInterface
    {
        $this->operationService->updateByCommand($command);

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: json_encode([])
        );
    }
}
