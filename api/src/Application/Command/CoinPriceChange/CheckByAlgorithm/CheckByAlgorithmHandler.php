<?php

namespace App\Application\Command\CoinPriceChange\CheckByAlgorithm;

use App\Application\Service\CoinPriceChangeAlgorithmService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CheckByAlgorithmHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private CoinPriceChangeAlgorithmService $algorithmService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(CheckByAlgorithmCommand $command): ResponseInterface
    {
        $this->algorithmService->checkOnChangePercent($command->getTimeRange());

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: [],
                format: 'json',
            )
        );
    }
}
