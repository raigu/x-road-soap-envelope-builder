<?php

namespace Raigu\XRoad\SoapEnvelope;

use PHPUnit\Runner\Exception;

/**
 * I am validated user id.
 *
 * I will throw exception if I am invalid.
 */
final class ValidatedUserId
{
    /**
     * @var string
     */
    private $userId;

    public function asStr(): string
    {
        $countryCode = substr($this->userId, 0, 2);
        if (preg_match('/^[A-Z]{2}$/', $countryCode) !== 1) {
            throw new Exception(
                sprintf(
                    'Invalid country code prefix in userId. Must be two-letter ISO country code. Actual: %s',
                    $countryCode
                )
            );
        }

        return $this->userId;
    }

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }
}
