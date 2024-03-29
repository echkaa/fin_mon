<?php

namespace App\Application\Command\Operation\Store;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\OperationFillCommandInterface;
use App\Domain\Entity\Operation;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @OA\Schema(
 *     required={
 *         "amount",
 *         "date",
 *     },
 *     example={
 *         "amount": 1250.56,
 *         "date": "2000-01-01 10:10:10"
 *     }
 * )
 */
class OperationStoreCommand extends AbstractCommand implements OperationFillCommandInterface
{
    /**
     * @Assert\NotBlank(message="Amount should not be blank.")
     */
    protected float $amount;
    /**
     * @Assert\Choice(choices=Operation::OPERATION_TYPES, message="Choose a valid type.")
     */
    protected ?string $type = null;
    protected ?string $source = null;
    protected ?string $description = null;
    /**
     * @SerializedName("external_code")
     */
    protected ?string $externalCode = null;
    /**
     * @Assert\DateTime()
     */
    protected string $date;

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getExternalCode(): string
    {
        return $this->externalCode ?? Operation::EXTERNAL_CODE_API;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
