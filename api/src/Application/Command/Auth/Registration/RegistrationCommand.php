<?php

namespace App\Application\Command\Auth\Registration;

use App\Application\Command\AbstractCommand;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     required={
 *         "username",
 *         "password",
 *     },
 *     example={
 *         "username": "oleksii_kava",
 *         "password": "mypassword",
 *     }
 * )
 */
class RegistrationCommand extends AbstractCommand
{
    /**
     * @Assert\NotBlank(message="Username should not be blank.")
     */
    protected ?string $password = null;
    /**
     * @Assert\NotBlank(message="Username should not be blank.")
     */
    protected ?string $username = null;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
