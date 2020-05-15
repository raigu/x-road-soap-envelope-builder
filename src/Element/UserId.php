<?php

namespace Raigu\XRoad\SoapEnvelope\Element;

use DOMDocument;
use PHPUnit\Runner\Exception;

class UserId implements XmlInjectable
{
    /**
     * @var string
     */
    private $countryCode;
    /**
     * @var string
     */
    private $personCode;

    public function inject(DOMDocument $dom)
    {
        $elements = $dom->getElementsByTagNameNS(
            'http://schemas.xmlsoap.org/soap/envelope/',
            'Header'
        );

        $elements->item(0)->appendChild(
            $dom->createElementNS(
                'http://x-road.eu/xsd/xroad.xsd',
                'userId',
                $this->countryCode . $this->personCode
            )
        );
    }

    public static function fromStr(string $value): self
    {
        return new self(
            substr($value, 0, 2),
            substr($value, 2)
        );
    }

    protected function __construct(string $countryCode, string $personCode)
    {
        if (preg_match('/^[A-Z]{2}$/', $countryCode) !== 1) {
            throw new Exception(
                sprintf(
                    'Invalid country code prefix in userId. Must be two-letter ISO country code. Actual: %s',
                    $countryCode
                )
            );
        }

        $this->countryCode = $countryCode;
        $this->personCode = $personCode;
    }
}
