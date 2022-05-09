<?php

namespace App\Application\Command\Operation\Update;

use App\Application\Service\OperationService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OperationUpdateHandler implements MessageHandlerInterface
{
    public function __construct(
        private OperationService $operationService,
        private SerializerInterface $serializer,
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
            body: $this->serializer->serialize([], 'json')
        );
    }
}
