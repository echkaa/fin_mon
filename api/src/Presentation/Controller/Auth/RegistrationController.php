<?php

namespace App\Presentation\Controller\Auth;

use App\Application\Command\Auth\Registration\RegistrationCommand;
use App\Presentation\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/v1/auth/registration", name="registration", methods={"POST"})
     * @OA\Get(summary="Register a new account")
     * @OA\Response(response=Response::HTTP_CREATED, description="Created")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=RegistrationCommand::class))
     *     )
     * )
     * @throws ExceptionInterface
     */
    public function registration()
    {
        return $this->response($this->handle(RegistrationCommand::class));
    }
}
