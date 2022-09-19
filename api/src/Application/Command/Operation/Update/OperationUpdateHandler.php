<?php

namespace App\Application\Command\Operation\Update;

use App\Domain\Contract\Factory\OperationFactoryInterface;
use App\Domain\Contract\Repository\OperationRepositoryInterface;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OperationUpdateHandler implements MessageHandlerInterface
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
    public function __invoke(OperationUpdateCommand $command): ResponseInterface
    {
        $entity = $this->operationRepository->findByOne($command->getId());

        $this->operationRepository->update(
            $this->operationFactory->fillEntity($entity, $command),
        );

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
