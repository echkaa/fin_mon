<?php

namespace App\Presentation\Controller\Auth;

use App\Application\Command\Auth\Token\TokenCommand;
use App\Presentation\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class TokenController extends AbstractController
{
    /**
     * @Route("/v1/auth/token", name="get_token", methods={"POST"})
     * @OA\Get(summary="Get Token")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=TokenCommand::class))
     *     )
     * )
     * @throws ExceptionInterface
     */
    public function token()
    {
        return $this->response($this->handle(TokenCommand::class));
    }
}
