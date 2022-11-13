<?php

namespace App\Application\Command\Binance\FillUserWallet;

use App\Application\Service\DTO\BinanceAccountBuilderService;
use App\Application\Service\DTO\BinanceAccountCoinFillService;
use App\Application\Service\DTO\BinanceCoinFilterService;
use App\Application\Service\TransactionService;
use App\Application\Service\UserService;
use App\Infrastructure\Persistence\MySQL\Repository\UserRepository;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BinanceFillUserWalletHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private UserService $userService,
        private UserRepository $userRepository,
        private BinanceAccountBuilderService $accountBuilderService,
        private BinanceAccountCoinFillService $coinFillService,
        private BinanceCoinFilterService $coinFilterService,
        private TransactionService $transactionService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(BinanceFillUserWalletCommand $command): ResponseInterface
    {
        $this->userService->setUser(
            $this->userRepository->find($command->getUserId())
        );

        $account = $this->accountBuilderService->getAccount();
        $this->accountBuilderService->setTransactionByAccount($account);

        $this->coinFillService->fillFullStatCoinsByAccount($account);

        $this->transactionService->fillFromBinanceBalanceCoinCollection(
            $this->coinFilterService->filterCoins($account->getBalanceCoins())
        );

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
