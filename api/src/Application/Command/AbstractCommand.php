<?php

namespace App\Application\Command;

abstract class AbstractCommand
{
    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
        }
    }
}
