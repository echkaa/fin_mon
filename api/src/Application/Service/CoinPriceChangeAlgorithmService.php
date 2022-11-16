<?php

namespace App\Application\Service;

use App\Application\Command\Telegram\SendMessage\SendMessageCommand;
use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Entity\CoinPriceChange;
use App\Domain\Entity\User;
use Symfony\Component\Messenger\MessageBusInterface;

class CoinPriceChangeAlgorithmService
{
    private const NOTIFICATION_TEXT = "Coin: %s\r\nTimeRange: %s\r\nChangePercent: %.2F\r\nPosition: %s\r\nCurrentPrice: %.8F\r\nLastPrice: %.8F";

    public function __construct(
        private CoinPriceChangeService $coinPriceChangeService,
        private UserRepositoryInterface $userRepository,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function checkOnChangePercent(string $timeRange): void
    {
        $coinPriceChangeList = $this->coinPriceChangeService->getLastCoinPriceChangeByTimeRange($timeRange);

        $coinPriceChangeList->map(
            fn(CoinPriceChange $coinPriceChange) => $this->checkCoinChangePercent($coinPriceChange)
        );
    }

    private function checkCoinChangePercent(CoinPriceChange $coinPriceChange): void
    {
        if (abs($coinPriceChange->getChangePercent()) >= $coinPriceChange->getReactionPercent()) {
            $this->notificationUsers($coinPriceChange);
        }
    }

    private function notificationUsers(CoinPriceChange $coinPriceChange): void
    {
        $users = $this->userRepository->getTelegramChatIdNotNullList();

        $message = sprintf(
            self::NOTIFICATION_TEXT,
            $coinPriceChange->getCoin()->getName(),
            $coinPriceChange->getTimeRange(),
            $coinPriceChange->getChangePercent(),
            $coinPriceChange->getChangePercent() >= 0 ? 'LONG' : 'SHORT',
            $coinPriceChange->getMarketPrice(),
            $coinPriceChange->getPreviousChange()->getMarketPrice(),
        );

        array_map(
            function (User $user) use ($message) {
                $this->messageBus->dispatch(
                    (new SendMessageCommand())
                        ->setTelegramChatId($user->getTelegramChatId())
                        ->setMessage($message)
                );
            },
            $users,
        );
    }
}
