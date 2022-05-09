<?php

namespace App\Application\Command\Operation\Store;

use App\Application\Service\OperationService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OperationStoreHandler implements MessageHandlerInterface
{
    public function __construct(
        private OperationService $operationService,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(OperationStoreCommand $command): ResponseInterface
    {
        $this->operationService->storeByCommand($command);

        return new HttpResponse(
            status: Response::HTTP_CREATED,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
