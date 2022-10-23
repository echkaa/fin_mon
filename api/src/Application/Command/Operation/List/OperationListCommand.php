<?php

namespace App\Application\Command\Operation\List;

use App\Application\Command\AbstractCommand;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     example={
 *          "filters": {
 *              "from": "2000-01-01",
 *              "to": "2000-01-01"
 *          }
 *     }
 * )
 */
class OperationListCommand extends AbstractCommand
{
    /**
     * @Assert\Collection(
     *      fields={
     *          "from" = @Assert\Date(),
     *          "to" = @Assert\Date(),
     *      },
     *      allowMissingFields=true
     * )
     */
    protected $filters;

    public function getFilters(): ?array
    {
        return $this->filters;
    }
}
