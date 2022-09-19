<?php

namespace App\Presentation\Controller;

use App\Application\Command\Token\TokenCommand;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class TokenController extends AbstractController
{
    /**
     * @Route("/v1/token", name="get_token", methods={"POST"})
     * @OA\Get(summary="Get Token")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=TokenCommand::class))
     *     )
     * )
     * @throws ExceptionInterface
     */
    public function getTokenUser()
    {
        return $this->response($this->handle(TokenCommand::class));
    }
}
