<?php

namespace App\Presentation\Controller;

use App\Application\Command\User\Info\InfoCommand;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class UserController extends AbstractController
{
    /**
     * @Route("/v1/user/info", name="user_info", methods={"GET"})
     * @OA\Get(summary="Get user info")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=InfoCommand::class))
     *     )
     * )
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function update(): Response
    {
        return $this->response($this->handle(InfoCommand::class));
    }
}
