<?php

namespace App\Application\Command\Binance\Signature;

use App\Application\Command\AbstractCommand;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\SerializedName;

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
     * @SerializedName("public_key")
     */
    protected string $publicKey;
    /**
     * @Assert\NotBlank(message="Private key Binance should not be blank.")
     * @SerializedName("private_key")
     */
    protected string $privateKey;

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function getParams(): string
    {
        return $this->params;
    }
}
