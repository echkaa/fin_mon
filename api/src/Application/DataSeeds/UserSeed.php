<?php

namespace App\Application\DataSeeds;

use App\Application\Repository\UserRepository;
use App\Domain\Entity\User;
use Evotodi\SeedBundle\Command\Seed;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSeed extends Seed
{
    private const USER_ID = 1;

    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    public static function seedName(): string
    {
        return 'user';
    }

    public static function getOrder(): int
    {
        return 0;
    }

    public function load(InputInterface $input, OutputInterface $output): int
    {
        $this->disableDoctrineLogging();

        if ($this->userRepository->find(self::USER_ID)) {
            return 0;
        }

        $user = (new User())
            ->setId(self::USER_ID)
            ->setClientId('d1befa03c79ca0b84ecc488dea96bc68')
            ->setUsername('oleksii_kava');

        $hashedPassword = $this->passwordHasher->hashPassword($user, 'mypassword');

        $this->userRepository->store($user->setPassword($hashedPassword));

        return 0;
    }

    /**
     * The unload method is called when unloading a seed
     */
    public function unload(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userRepository->findByOne(self::USER_ID);

        $this->userRepository->delete($user);

        return 0;
    }
}
