<?php

namespace App\Application\Command\Token;

use App\Application\Command\AbstractCommand;
use Symfony\Component\Serializer\Annotation\SerializedName;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     required={
 *         "client_id",
 *         "username",
 *         "password",
 *     },
 *     example={
 *         "id": 100500,
 *         "client_id": "d1befa03c79ca0b84ecc488dea96bc68",
 *         "username": "kava_oleksii",
 *         "password": "mypassword",
 *         "scope": "one of available scopes",
 *     }
 * )
 */
class TokenCommand extends AbstractCommand
{
    /**
     * @Assert\NotBlank(message="client_id should not be blank.")
     * @SerializedName("client_id")
     * @OA\Property(property="client_id")
     */
    protected ?string $clientId = null;
    /**
     * @Assert\NotBlank(message="username should not be blank.")
     * @OA\Property(property="username")
     */
    protected ?string $username = null;
    /**
     * @Assert\NotBlank(message="password should not be blank.")
     * @OA\Property(property="password")
     */
    protected ?string $password = null;
    /**
     * @OA\Property(property="scope", type="array", @OA\Items(type="string"))
     */
    protected string|array|null $scope = [];

    public function getClientId(): ?string
    {
        return $this->clientId;
    }

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
