<?php

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\Client;

class ClientValidationTest extends TestCase
{
    /**
     * @test
     */
    public function fromStr_throws_exception_when_invalid_format()
    {
        $this->expectExceptionMessage('Invalid format');
        Client::fromStr('');
    }
}
