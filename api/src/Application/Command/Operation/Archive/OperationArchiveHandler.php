<?php

namespace App\Application\Command\Operation\Archive;

use App\Domain\Contract\Repository\OperationRepositoryInterface;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OperationArchiveHandler implements MessageHandlerInterface
{
    public function __construct(
        private OperationRepositoryInterface $operationRepository,
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(OperationArchiveCommand $command): ResponseInterface
    {
        $entity = $this->operationRepository->findByOne($command->getId());

        $this->operationRepository->update(
            $entity->setArchive(true),
        );

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
