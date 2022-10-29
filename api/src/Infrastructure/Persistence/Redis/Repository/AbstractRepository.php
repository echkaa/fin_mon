<?php

namespace App\Infrastructure\Persistence\Redis\Repository;

use Exception;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Psr\Cache\InvalidArgumentException;
use DateInterval;

abstract class AbstractRepository
{
    public function __construct(
        protected AdapterInterface $adapter,
    ) {
    }

    public function save(string $identifier, string $value): void
    {
        $this->adapter->save(
            $this->adapter->getItem($this->buildKey($identifier))
                ->expiresAfter($this->getInterval())
                ->set($value)
        );
    }

    private function buildKey(string $identifier): string
    {
        return $this->getPrefix() . "_" . $identifier;
    }

    abstract function getPrefix(): string;

    /**
     * @throws Exception
     */
    private function getInterval(): DateInterval
    {
        return new DateInterval(sprintf('P%sM', 15));
    }

    /**
     * @throws Exception|InvalidArgumentException
     */
    public function find(string $identifier): string
    {
        $item = $this->adapter->getItem(
            $this->buildKey($identifier),
        );

        if ($item->get() === null) {
            throw new Exception("Not found value for identifier");
        }

        return $item->get();
    }
}
