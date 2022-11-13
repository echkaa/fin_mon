<?php

namespace App\Application\Command\Binance\FillCoinList;

use App\Application\Service\DTO\BinanceCoinFillService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BinanceFillCoinListHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private BinanceCoinFillService $coinFillService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(BinanceFillCoinListCommand $command): ResponseInterface
    {
        $this->coinFillService->fillCoinsFromBinance();

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
