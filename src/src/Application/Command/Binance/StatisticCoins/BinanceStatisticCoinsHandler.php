<?php

namespace App\Application\Command\Binance\StatisticCoins;

use App\Application\Factory\DTO\BinanceAccountFactory;
use App\Application\Request\Binance\AccountBinanceRequest;
use App\Application\Service\BinanceCoinService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class BinanceStatisticCoinsHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private AccountBinanceRequest $accountBinanceRequest,
        private BinanceAccountFactory $binanceAccountFactory,
        private BinanceCoinService $binanceCoinService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(BinanceStatisticCoinsCommand $command): ResponseInterface
    {
        try {
            $accountData = $this->accountBinanceRequest->sendRequest();

            $account = $this->binanceAccountFactory->create($accountData);

            $account->setBalanceCoins(
                $this->binanceCoinService->filterCoinsByList(
                    coins: $account->getBalanceCoins(),
                    coinNeedList: $command->getCoins(),
                )
            );

            $this->binanceCoinService->fillMarketPrice($account->getBalanceCoins());
            $this->binanceCoinService->fillRealPrice($account->getBalanceCoins());
        } catch (Throwable $exception) {
            dd($exception);
        }

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: $account->getBalanceCoins(),
                format: 'json',
            )
        );
    }
}
