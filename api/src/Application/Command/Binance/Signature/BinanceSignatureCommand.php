<?php

namespace App\Application\Command\Binance\Signature;

use App\Application\Command\AbstractCommand;
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
class BinanceSignatureCommand extends AbstractCommand
{
    protected string $params;

    public function getParams(): string
    {
        return $this->params;
    }
}
