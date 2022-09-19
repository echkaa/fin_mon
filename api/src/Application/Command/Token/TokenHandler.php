<?php

namespace App\Application\Command\Token;

use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Contract\Verification\VerifyUserCredentialsInterface;
use App\Domain\Exception\AuthException;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TokenHandler implements MessageHandlerInterface
{
    public function __construct(
        private JWTTokenManagerInterface $JWTManager,
        private UserRepositoryInterface $userRepository,
        private VerifyUserCredentialsInterface $verifyUserCredentials,
    ) { }

    public function __invoke(TokenCommand $command): ResponseInterface
    {
        $user = $this->userRepository->getByClientId($command->getClientId());

        if ($user === null) {
            throw new AuthException('No found user');
        }

        $checkCredentials = $this->verifyUserCredentials->verify(
            user: $user,
            password: $command->getPassword()
        );

        if ($checkCredentials === false) {
            throw new AuthException('No valid credentials');
        }

        return new HttpResponse(
            status: Response::HTTP_OK,
            body: json_encode(['token' => $this->JWTManager->create($user)])
        );
    }
}
