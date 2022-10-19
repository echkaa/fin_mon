<?php

namespace App\Application\Command\Setting\Update;

use App\Application\Service\UserService;
use App\Domain\Contract\Factory\SettingFactoryInterface;
use App\Domain\Contract\Repository\SettingRepositoryInterface;
use Exception;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SettingUpdateHandler implements MessageHandlerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private SettingFactoryInterface $settingFactory,
        private SettingRepositoryInterface $settingRepository,
        private UserService $userService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(SettingUpdateCommand $command): ResponseInterface
    {
        $setting = $this->settingRepository->findByCriteria([
            "user" => $this->userService->getCurrentUser()->getId(),
        ]);

        if (empty($setting = reset($setting))) {
            $setting = $this->settingFactory->getInstance();
        }

        $setting = $this->settingFactory->fillEntity(
            entity: $setting,
            command: $command
        );

        $this->settingRepository->store($setting);

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: $this->serializer->serialize([], 'json')
        );
    }
}
