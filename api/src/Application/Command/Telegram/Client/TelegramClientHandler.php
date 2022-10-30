<?php

namespace App\Application\Command\Telegram\Client;

use App\Application\Service\TelegramService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TelegramClientHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private TelegramService $telegramService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(TelegramClientCommand $command): ResponseInterface
    {
        $this->telegramService->setHandlers();

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
