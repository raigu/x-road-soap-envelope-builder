# x-road-soap-envelope-builder

PHP library for generating X-Road SOAP envelope.

**UNDER CONSTRUCTION**

Useful for making X-Road requests directly over HTTP. 

The goal of this library is to allow composition of X-road request processing
from third-party components by introducing missing piece - X-Road compliant HTTP request body.


# Usage

**Draft**

```php

$builder = SoapEnvelopeBuilder::create()
    ->withService('EE/COM/10256137/cre/test/v1')
    ->withClient('EE/COM/10256137/cre')
    ->withUserId('EE0000000000')
    ->withIssue('3b530db3-833c-41f9-b931-4f278954d654')
    ->withXRoadMessageBody('______');

$envelope = $builder->build();

echo $envelope;
```

## Usage with Guzzle

```php
$envelope = .... // See Usage how to build one. 

$client = new \Guzzle\Http\Client();
$request = $client->post(
    'https://xtee.domain.ee' // <-- your X-road Security server URL
    [ "Content-Type" => "text/xml"],
    $envelope
);

$response = $client->send($request);

echo $response->getBody();
```


# References

* [X-Road Terms and Abbreviations](https://www.x-tee.ee/docs/live/xroad/terms_x-road_docs.html)
* [X-Road: Message Protocol v4.0](https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#e1-request)