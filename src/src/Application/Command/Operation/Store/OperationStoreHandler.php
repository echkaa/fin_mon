<?php

namespace App\Application\Command\Operation\Store;

use App\Domain\Contract\Factory\OperationFactoryInterface;
use App\Domain\Contract\Repository\OperationRepositoryInterface;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OperationStoreHandler implements MessageHandlerInterface
{
    public function __construct(
        private OperationFactoryInterface $operationFactory,
        private OperationRepositoryInterface $operationRepository,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(OperationStoreCommand $command): ResponseInterface
    {
        $entity = $this->operationFactory->getInstance();

        $this->operationRepository->store(
            $this->operationFactory->fillEntity($entity, $command),
        );

        return new HttpResponse(
            status: Response::HTTP_CREATED,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
