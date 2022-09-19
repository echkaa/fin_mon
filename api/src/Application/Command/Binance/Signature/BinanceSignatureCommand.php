<?php

namespace App\Application\Command\Binance\Signature;

use App\Application\Command\AbstractCommand;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={
 *         "public_key",
 *         "private_key"
 *     },
 *     example={
 *         "public_key": "",
 *         "private_key": "",
 *         "params": "recvWindow=60000&symbol=XRPUSDT"
 *     }
 * )
 */
class BinanceSignatureCommand extends AbstractCommand
{
    protected string $params;
    /**
     * @Assert\NotBlank(message="Public key Binance should not be blank.")
     */
    protected string $public_key;
    /**
     * @Assert\NotBlank(message="Private key Binance should not be blank.")
     */
    protected string $private_key;

    public function getPublicKey(): string
    {
        return $this->public_key;
    }

    public function getPrivateKey(): string
    {
        return $this->private_key;
    }

    public function getParams(): string
    {
        return $this->params;
    }
}
