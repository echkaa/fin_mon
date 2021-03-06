<?php

namespace App\Presentation\Controller;

use App\Application\Command\Statistic\Operation\StatisticOperationCommand;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class StatisticController extends AbstractController
{
    /**
     * @Route("/v1/statistic/operation", name="statistic_operation", methods={"GET"})
     * @OA\Post(summary="Get statistic by operation")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=StatisticOperationCommand::class))
     *     )
     * )
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function operation(): Response
    {
        return $this->response($this->handle(StatisticOperationCommand::class));
    }
}
