<?php

namespace App\Presentation\Controller;

use App\Application\Command\Setting\Update\UpdateCommand;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class SettingController extends AbstractController
{
    /**
     * @Route("/v1/setting", name="setting_update", methods={"PUT"})
     * @OA\Put(summary="Update setting")
     * @OA\Response(response=Response::HTTP_OK, description="Update")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=SettingUpdateCommand::class))
     *     )
     * )
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function update(): Response
    {
        return $this->response($this->handle(UpdateCommand::class));
    }
}
