<?php

namespace App\Application\Command\Binance\StatisticCoins;

use App\Application\Command\AbstractCommand;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     required={
 *         "public_key",
 *         "private_key",
 *         "coins",
 *     },
 *     example={
 *         "public_key": "",
 *         "private_key": "",
 *         "coins": "{'BTC', 'ETH', 'ETC}"
 *     }
 * )
 */
class BinanceStatisticCoinsCommand extends AbstractCommand
{
    /**
     * @Assert\NotBlank(message="Private key Binance should not be blank.")
     */
    protected string $private_key;
    /**
     * @Assert\NotBlank(message="Public key Binance should not be blank.")
     */
    protected string $public_key;
    /**
     * @Assert\NotBlank(message="Coins should not be blank.")
     */
    protected array $coins;

    public function getPublicKey(): string
    {
        return $this->public_key;
    }

    public function getPrivateKey(): string
    {
        return $this->private_key;
    }

    public function getCoins(): array
    {
        return $this->coins;
    }
}
