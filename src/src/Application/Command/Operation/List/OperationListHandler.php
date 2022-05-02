<?php

namespace App\Application\Command\Operation\List;

use App\Application\Repository\OperationRepository;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OperationListHandler implements MessageHandlerInterface
{
    public function __construct(
        private OperationRepository $operationRepository
    ) { }

    /**
     * @throws Exception
     */
    public function __invoke(OperationListCommand $command): ResponseInterface
    {
        $operations = $this->operationRepository->findAll();

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: json_encode($operations)
        );
    }
}
