<?php

namespace App\Application\Command\Operation\List;

use App\Application\Service\UserService;
use App\Domain\Contract\Repository\OperationRepositoryInterface;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OperationListHandler implements MessageHandlerInterface
{
    public function __construct(
        private OperationRepositoryInterface $operationRepository,
        private SerializerInterface $serializer,
        private UserService $userService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(OperationListCommand $command): ResponseInterface
    {
        $operations = $this->operationRepository->findBy([
            "user" => $this->userService->getCurrentUser()->getId(),
        ]);

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize($operations, 'json')
        );
    }
}
