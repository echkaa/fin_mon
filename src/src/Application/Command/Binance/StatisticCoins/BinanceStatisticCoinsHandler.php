<?php

namespace App\Application\Command\Binance\StatisticCoins;

use App\Application\Request\Binance\AccountBinanceRequest;
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
        private AccountBinanceRequest $accountBinanceRequest,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(BinanceStatisticCoinsCommand $command): ResponseInterface
    {
        $accountData = $this->accountBinanceRequest->sendRequest(
            $command->getPublicKey(),
            $command->getPrivateKey(),
        );

        /*TODO::Формирование параметров и отправка на бинанс (получить котировки по монетам)*/

        /*TODO::Произведение расчёта*/

        /*TODO::Формирование ответа*/

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: [],
                format: 'json',
            )
        );
    }
}
