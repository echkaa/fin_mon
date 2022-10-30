<?php

namespace App\Application\Command\Binance\StatisticCoins;

use App\Application\Service\BinanceCoinService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BinanceStatisticCoinsHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private BinanceCoinService $binanceCoinService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(BinanceStatisticCoinsCommand $command): ResponseInterface
    {
        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: $this->binanceCoinService->getStatisticCoins($command->getCoins()),
                format: 'json',
            )
        );
    }
}
