<?php

namespace Raigu\XRoad;

use Psr\Http\Message\StreamInterface;

class Message implements \Psr\Http\Message\MessageInterface
{
    /**
     * @var string
     */
    private $version;
    /**
     * @var array
     */
    private $headers;
    /**
     * @var StreamInterface
     */
    private $body;

    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader($nameRequestInterface, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body)
    {
        return new self(
            $this->version,
            $this->headers,
            $body
        );
    }

    public static function create(): self
    {
        return new self(
            '1.1',
            [],
            Stream::empty()
        );
    }

    private function __construct(
        string $version,
        array $headers,
        StreamInterface $body
    ) {
        $this->version = $version;
        $this->headers = $headers;
        $this->body = $body;
    }
}
