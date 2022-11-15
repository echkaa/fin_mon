<?php

namespace App\Application\Command\Binance\ClearOldFuturesCoinPrice;

use App\Application\Service\CoinPriceService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ClearOldFuturesCoinPriceHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private CoinPriceService $coinPriceService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ClearOldFuturesCoinPriceCommand $command): ResponseInterface
    {
        $this->coinPriceService->deleteOldFuturesCoinsPrice(
            $command->getDeletedTo()
        );

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: [],
                format: 'json',
            )
        );
    }
}
