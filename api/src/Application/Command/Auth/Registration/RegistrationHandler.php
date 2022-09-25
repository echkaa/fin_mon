<?php

namespace App\Application\Command\Auth\Registration;

use App\Domain\Contract\Factory\UserFactoryInterface;
use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Exception\RegistrationException;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegistrationHandler implements MessageHandlerInterface
{
    public function __construct(
        private JWTTokenManagerInterface $JWTManager,
        private UserRepositoryInterface $userRepository,
        private UserFactoryInterface $userFactory,
    ) {
    }

    public function __invoke(RegistrationCommand $command): ResponseInterface
    {
        if ($this->userRepository->getByUsername($command->getUsername())) {
            throw new RegistrationException('Specified username already exists.');
        }

        $user = $this->userFactory->fillEntity(
            $this->userFactory->getInstance(),
            $command,
        );

        $this->userRepository->store($user);

        return new HttpResponse(
            status: Response::HTTP_CREATED,
            body: json_encode(['token' => $this->JWTManager->create($user)])
        );
    }
}
