<?php

namespace App\Application\Command\Setting\Update;

use App\Application\Command\AbstractCommand;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @OA\Schema(
 *     example={
 *         "binance_public_key": "",
 *         "binance_private_key": "",
 *         "mono_bank_token": "",
 *     }
 * )
 */
class UpdateCommand extends AbstractCommand
{
    /**
     * @SerializedName("binance_public_key")
     */
    protected ?string $binancePublicKey = null;
    /**
     * @SerializedName("binance_private_key")
     */
    protected ?string $binancePrivateKey = null;
    /**
     * @SerializedName("mono_bank_token")
     */
    protected ?string $monoBankToken = null;

    public function getBinancePublicKey(): ?string
    {
        return $this->binancePublicKey;
    }

    public function getBinancePrivateKey(): ?string
    {
        return $this->binancePrivateKey;
    }

    public function getMonoBankToken(): ?string
    {
        return $this->monoBankToken;
    }
}
