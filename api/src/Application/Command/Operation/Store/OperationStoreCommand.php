<?php

namespace App\Application\Command\Operation\Store;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\OperationFillCommandInterface;
use App\Domain\Entity\Operation;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={
 *         "amount",
 *     },
 *     example={
 *         "amount": 1250.56,
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
    protected ?string $external_code = null;

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getExternalCode(): string
    {
        return $this->external_code ?? Operation::EXTERNAL_CODE_API;
    }
}
