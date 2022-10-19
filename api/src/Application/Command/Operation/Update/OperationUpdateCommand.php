<?php

namespace App\Application\Command\Operation\Update;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\OperationFillCommandInterface;
use App\Domain\Entity\Operation;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={
 *         "id",
 *         "amount",
 *         "date",
 *     },
 *     example={
 *         "id": 1,
 *         "amount": 1250.56,
 *         "date": "2000-01-01 10:10:10"
 *     }
 * )
 */
class OperationUpdateCommand extends AbstractCommand implements OperationFillCommandInterface
{
    /**
     * @Assert\NotBlank(message="Amount should not be blank.")
     */
    protected float $amount;
    protected ?string $description = null;
    protected ?string $external_code = null;
    /**
     * @Assert\NotBlank(message="Id should not be blank.")
     */
    protected int $id;
    protected ?string $source = null;
    /**
     * @Assert\Choice(choices=Operation::OPERATION_TYPES, message="Choose a valid type.")
     */
    protected ?string $type = null;
    /**
     * @Assert\DateTime()
     */
    protected string $date;

    public function getId(): int
    {
        return $this->id;
    }

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

    public function getDate(): string
    {
        return $this->date;
    }
}
