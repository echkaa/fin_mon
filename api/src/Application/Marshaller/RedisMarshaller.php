<?php

namespace App\Application\Marshaller;

use Symfony\Component\Cache\Marshaller\MarshallerInterface;

class RedisMarshaller implements MarshallerInterface
{
    public function marshall(array $values, ?array &$failed): array
    {
        $serialized = [];

        foreach ($values as $id => $value) {
            $serialized[$id] = $value;
        }

        return $serialized;
    }

    public function unmarshall(string $value): mixed
    {
        return $value;
    }
}
