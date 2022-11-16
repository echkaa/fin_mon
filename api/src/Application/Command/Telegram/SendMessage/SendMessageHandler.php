<?php

namespace App\Application\Command\Telegram\SendMessage;

use App\Infrastructure\Adapter\TelegramAdapter;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SendMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private TelegramAdapter $telegramAdapter,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(SendMessageCommand $command): ResponseInterface
    {
        $this->telegramAdapter->sendMessage(
            $command->getTelegramChatId(),
            $command->getMessage(),
        );

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
