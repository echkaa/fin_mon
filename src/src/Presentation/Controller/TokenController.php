<?php

namespace App\Presentation\Controller;

use App\Application\Command\Token\TokenCommand;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

class TokenController extends AbstractController
{
    /**
     * @Route("/v1/token", name="get_token", methods={"GET"})
     * @OA\Get(summary="Get Token")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @throws ExceptionInterface
     */
    public function getTokenUser()
    {
        return $this->response($this->handle(TokenCommand::class));
    }
}
