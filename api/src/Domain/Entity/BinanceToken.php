<?php

namespace App\Domain\Entity;

class BinanceToken
{
    private string $paramsHttp;
    private string $privateKey;
    private string $publicKey;
    private string $signature;

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getParamsHttpWithToken(): string
    {
        return $this->paramsHttp . "&signature={$this->signature}";
    }

    public function setParamsHttp(string $paramsHttp): self
    {
        $this->paramsHttp = $paramsHttp;

        return $this;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function setPublicKey(string $publicKey): self
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    public function setPrivateKey(string $privateKey): self
    {
        $this->privateKey = $privateKey;

        return $this;
    }
}
