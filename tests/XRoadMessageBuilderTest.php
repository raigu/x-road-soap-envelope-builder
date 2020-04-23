<?php

use PHPUnit\Framework\TestCase;
use Raigu\XRoad\MessageBuilder;

class XRoadMessageBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function builds_PSR7_compatible_request()
    {
        $sut = MessageBuilder::create();

        $this->assertInstanceOf(
            \Psr\Http\Message\MessageInterface::class,
            $sut->build()
        );
    }

    /**
     * @test
     */
    public function builds_SOAP_message()
    {
        $sut = MessageBuilder::create();
        $request = $sut->build();
        $actual = strval($request->getBody());

        $dom = new DOMDocument;
        $dom->loadXML($actual);
        $this->assertTrue(
            $dom->schemaValidate(__DIR__ . '/soap-v1.1.xsd')
        );
    }
}
