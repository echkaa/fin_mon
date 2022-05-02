<?php

namespace App\Application\Security\Authorization;

use Jose\Component\Checker\ClaimChecker;
use Jose\Component\Checker\InvalidClaimException;

class AuthChecked implements ClaimChecker
{
    public function checkClaim($value): void
    {
        dd($value);
        if ($value !== 'someConcreteValue') {
            throw new InvalidClaimException("This is a wrong value for a claim.", "userAuth", $value);
        }
    }

    public function supportedClaim(): string
    {
        dd('test');
        return "userAuth";
    }
}
