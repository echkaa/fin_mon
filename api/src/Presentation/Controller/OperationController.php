<?php

namespace App\Presentation\Controller;

use App\Application\Command\Operation\Archive\OperationArchiveCommand;
use App\Application\Command\Operation\List\OperationListCommand;
use App\Application\Command\Operation\Store\OperationStoreCommand;
use App\Application\Command\Operation\Update\OperationUpdateCommand;
use App\Application\Command\Operation\Delete\OperationDeleteCommand;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class OperationController extends AbstractController
{
    /**
     * @Route("/v1/operations", name="operation_store", methods={"POST"})
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

    /**
     * @Route("/v1/operations", name="operation_list", methods={"GET"})
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
     * @Route("/v1/operations", name="operation_update", methods={"PUT"})
     * @OA\Put(summary="Update operation")
     * @OA\Response(response=Response::HTTP_OK, description="Update")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=OperationUpdateCommand::class))
     *     )
     * )
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function update(): Response
    {
        return $this->response($this->handle(OperationUpdateCommand::class));
    }

    /**
     * @Route("/v1/operations", name="operation_delete", methods={"DELETE"})
     * @OA\Delete(summary="Delete operation")
     * @OA\Response(response=Response::HTTP_OK, description="OK")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=OperationDeleteCommand::class))
     *     )
     * )
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function delete(): Response
    {
        return $this->response($this->handle(OperationDeleteCommand::class));
    }

    /**
     * @Route("/v1/operations/archive", name="operation_archive", methods={"POST"})
     * @OA\Post(summary="Archive operation")
     * @OA\Response(response=Response::HTTP_CREATED, description="Created")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=OperationArchiveCommand::class))
     *     )
     * )
     * @Security(name="Bearer")
     * @throws ExceptionInterface
     */
    public function archive(): Response
    {
        return $this->response($this->handle(OperationArchiveCommand::class));
    }
}
