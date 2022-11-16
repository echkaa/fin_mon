<?php

namespace App\Application\Command\Binance\StoreFuturesCoinPriceChange;

use App\Application\Service\CoinPriceChangeService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class StoreFuturesCoinPriceChangeHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private CoinPriceChangeService $coinPriceChangeService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(StoreFuturesCoinPriceChangeCommand $command): ResponseInterface
    {
        $this->coinPriceChangeService->storeFuturesCoinPriceChangeByTimeRange($command->getTimeRange());

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: [],
                format: 'json',
            )
        );
    }
}
