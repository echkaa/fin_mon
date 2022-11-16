<?php

namespace App\Application\Command\User\Info;

use App\Application\Service\UserService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class InfoHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private UserService $userService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(InfoCommand $command): ResponseInterface
    {
        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: $this->userService->getCurrentUser(),
                format: 'json',
            )
        );
    }
}
