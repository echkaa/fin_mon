<?php

namespace App\Application\CLICommand;

use App\Application\Service\UserService;
use App\Domain\Contract\Factory\OperationFactoryInterface;
use App\Domain\Contract\Repository\OperationRepositoryInterface;
use App\Domain\Contract\Repository\SettingRepositoryInterface;
use App\Domain\Entity\Setting;
use App\Infrastructure\Client\MonoBankClient;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DateTime;
use Throwable;

class MonoBankOperationCommand extends Command
{
    const PERIOD_UPLOAD_OPERATIONS = '1 week';
    protected static $defaultName = 'mono-bank:operations:getting';
    private DateTime $startOperation;

    public function __construct(
        private SettingRepositoryInterface $settingRepository,
        private OperationFactoryInterface $operationFactory,
        private OperationRepositoryInterface $operationRepository,
        private MonoBankClient $monoBankClient,
        private UserService $userService,
    ) {
        $this->startOperation = (new DateTime())->modify("-" . self::PERIOD_UPLOAD_OPERATIONS);

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $settingList = $this->settingRepository->getNotNullList();

        /** @var Setting $setting */
        foreach ($settingList as $setting) {
            try {
                $operations = $this->getOperationsFromMonoBank($setting);

                $this->userService->setUserById($setting->getUser()->getId());

                $this->saveOperations($operations);
            } catch (Throwable $exception) {
                dd($exception->getMessage());
            }
        }

        return 0;
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
