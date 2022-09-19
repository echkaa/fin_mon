<?php

namespace App\Application\Command\Operation\Delete;

use App\Application\Command\AbstractCommand;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={
 *         "id"
 *     },
 *     example={
 *         "id": 1,
 *     }
 * )
 */
class OperationDeleteCommand extends AbstractCommand
{
    /**
     * @Assert\NotBlank(message="Id should not be blank.")
     */
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }
}
