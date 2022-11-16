<?php

namespace App\Presentation\Controller;

use App\Application\Command\Telegram\Client\ClientCommand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class TelegramController extends AbstractController
{
    /**
     * @Route("/v1/telegram/client", name="telegram_client", methods={"POST"})
     * @OA\Post(summary="Telegram client")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=ClientCommand::class))
     *     )
     * )
     * @throws ExceptionInterface
     */
    public function setWebhook(): Response
    {
        return $this->response($this->handle(ClientCommand::class));
    }
}
