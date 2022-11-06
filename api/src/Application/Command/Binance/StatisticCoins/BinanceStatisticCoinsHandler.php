<?php

namespace App\Application\Command\Binance\StatisticCoins;

use App\Application\Service\BinanceAccountBuilderService;
use App\Application\Service\BinanceAccountCoinFillService;
use App\Application\Service\BinanceCoinFilterService;
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
        private BinanceAccountBuilderService $accountBuilderService,
        private BinanceAccountCoinFillService $coinFillService,
        private BinanceCoinFilterService $coinFilterService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(BinanceStatisticCoinsCommand $command): ResponseInterface
    {
        $account = $this->accountBuilderService->getAccount();
        $this->accountBuilderService->setTransactionByAccount($account);

        $account->setBalanceCoins(
            $this->coinFilterService->filterCoinsByList(
                coins: $account->getBalanceCoins(),
                coinNeedList: $command->getCoins(),
            )
        );

        $this->coinFillService->fillFullStatCoinsByAccount($account);

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: $this->coinFilterService->filterCoins($account->getBalanceCoins()),
                format: 'json',
            )
        );
    }
}
