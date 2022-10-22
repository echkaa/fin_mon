<?php

namespace App\Application\Service;

use App\Domain\Entity\User;
use App\Infrastructure\Persistence\MySQL\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\Security\Core\Security;

class UserService
{
    private ?User $user = null;

    public function __construct(
        private UserRepository $userRepository,
        private Security $security,
    ) {
    }

    /**
     * @throws JWTDecodeFailureException
     */
    public function getCurrentUser(): User
    {
        if ($this->user === null) {
            $this->setCurrentUser();
        }

        return $this->user;
    }

    /**
     * @throws JWTDecodeFailureException
     */
    private function setCurrentUser(): void
    {
        $this->user = $this->userRepository->findOneBy([
            'username' => $this->security->getUser()->getUserIdentifier(),
        ]);
    }

    public function setUserById(int $userId): void
    {
        $this->user = $this->userRepository->findOneBy([
            'id' => $userId,
        ]);
    }
}
