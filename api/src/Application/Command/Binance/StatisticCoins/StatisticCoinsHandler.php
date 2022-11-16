<?php

namespace App\Application\Command\Binance\StatisticCoins;

use App\Application\Service\TransactionService;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class StatisticCoinsHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private TransactionService $transactionService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(StatisticCoinsCommand $command): ResponseInterface
    {
        $transactions = $this->transactionService->getLastTransactionsForCurrentUser();

        $this->transactionService->updateMarketPriceOnTransactions($transactions);

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize(
                data: $this->transactionService->filterTransactionsByValue($transactions),
                format: 'json',
            )
        );
    }
}
