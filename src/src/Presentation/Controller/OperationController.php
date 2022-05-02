<?php

namespace App\Presentation\Controller;

use App\Application\Command\Operation\List\OperationListCommand;
use App\Application\Command\Operation\Store\OperationStoreCommand;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class OperationController extends AbstractController
{
    /**
     * @Route("/v1/operation", name="operation_list", methods={"GET"})
     * @OA\Get(summary="List of Operations")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=OperationListCommand::class))
     *     )
     * )
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function list(): Response
    {
        return $this->response($this->handle(OperationListCommand::class));
    }

    /**
     * @Route("/v1/operation/store", name="operation_store", methods={"POST"})
     * @OA\Post(summary="Store operation")
     * @OA\Response(response=Response::HTTP_CREATED, description="Created")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=OperationStoreCommand::class))
     *     )
     * )
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function store(): Response
    {
        return $this->response($this->handle(OperationStoreCommand::class));
    }
}
