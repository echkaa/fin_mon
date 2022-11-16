<?php

namespace App\Application\Command\Binance\Signature;

use App\Application\Command\AbstractCommand;
use App\Domain\Contract\Command\AsyncCommandInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @OA\Schema(
 *     example={
 *         "params": "recvWindow=60000&symbol=XRPUSDT"
 *     }
 * )
 */
class SignatureCommand extends AbstractCommand implements AsyncCommandInterface
{
    protected string $params;

    public function getParams(): string
    {
        return $this->params;
    }
}
