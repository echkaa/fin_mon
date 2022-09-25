<?php

namespace App\Application\Command\Auth\Token;

use App\Application\Command\AbstractCommand;
use Symfony\Component\Serializer\Annotation\SerializedName;
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
 *         "scope": "one of available scopes",
 *     }
 * )
 */
class TokenCommand extends AbstractCommand
{
    /**
     * @Assert\NotBlank(message="Username should not be blank.")
     * @SerializedName("username")
     * @OA\Property(property="username")
     */
    protected ?string $username = null;
    /**
     * @Assert\NotBlank(message="Username should not be blank.")
     * @OA\Property(property="username")
     */
    protected ?string $password = null;
    /**
     * @OA\Property(property="scope", type="array", @OA\Items(type="string"))
     */
    protected string|array|null $scope = [];

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getScope(): array|string|null
    {
        return $this->scope;
    }
}
