<?php

namespace App\Application\Command\MonoBankOperation\Setting;

use App\Application\Service\UserService;
use App\Domain\Contract\Factory\OperationFactoryInterface;
use App\Domain\Contract\Repository\OperationRepositoryInterface;
use App\Domain\Contract\Repository\SettingRepositoryInterface;
use App\Domain\Entity\Setting;
use App\Infrastructure\Client\MonoBankClient;
use GuzzleHttp\Exception\GuzzleException;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Throwable;

class MonoBankOperationSettingHandler implements MessageHandlerInterface
{
    const PERIOD_UPLOAD_OPERATIONS = '1 week';
    private DateTime $startOperation;

    public function __construct(
        private SettingRepositoryInterface $settingRepository,
        private OperationFactoryInterface $operationFactory,
        private OperationRepositoryInterface $operationRepository,
        private MonoBankClient $monoBankClient,
        private UserService $userService,
        private LoggerInterface $logger,
    ) {
        $this->startOperation = (new DateTime())->modify("-" . self::PERIOD_UPLOAD_OPERATIONS);
    }

    public function __invoke(MonoBankOperationSettingCommand $command): void
    {
        $settingList = $this->settingRepository->getNotNullList();

        /** @var Setting $setting */
        foreach ($settingList as $setting) {
            try {
                $operations = $this->getOperationsFromMonoBank($setting);

                $this->userService->setUserById($setting->getUser()->getId());

                $this->saveOperations($operations);

                $this->logger->info(
                    "Setting operations for user ",
                );
            } catch (Throwable $e) {
                $this->logger->error(
                    $e->getMessage(),
                );
            }
        }
    }

    /**
     * @throws GuzzleException
     */
    private function getOperationsFromMonoBank(Setting $setting)
    {
        $response = $this->monoBankClient->getStatement(
            $setting->getMonoBankToken(),
            $this->startOperation->format('U'),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    private function saveOperations(array $operations): void
    {
        $existExternalIds = array_map(
            fn($operation) => $operation['externalId'],
            $this->operationRepository->getExternalIdsFromTime($this->startOperation)
        );

        foreach ($operations as $operation) {
            if ($operation['amount'] >= 0 || in_array($operation['id'], $existExternalIds)) {
                continue;
            }

            $this->operationRepository->store(
                $this->operationFactory->fillEntityFromMonoBank(
                    entity: $this->operationFactory->getInstance(),
                    data: $operation,
                )
            );
        }
    }
}
