# x-road-soap-envelope-builder

PHP library for generating X-Road SOAP envelope.

Useful for communicating with X-Road using third-party HTTP libraries.

# Requirements

* php 7.0+
* DOM extension

# Installation

```bash
$ composer require raigu/x-road-soap-envelope-builder
``` 

# Usage

## Building SOAP envelope

```php
$builder = SoapEnvelopeBuilder::create()
    ->withService('EE/GOV/70008440/rr/RR437/v1')
    ->withClient('EE/COM/12213008/gathering')
    ->withXRoadMessageBody(<<<EOD
        <prod:RR437 xmlns:prod="http://rr.x-road.eu/producer">
            <request>
                <Isikukood>00000000000</Isikukood>
            </request>
        </prod:RR437>
EOD;
    );

$envelope = $builder->build();

echo $envelope;
```

The method's `withXRoadMessageBody` input parameter can be generated from
 WSDL using free tools like [WSDL Analyzer](http://www.wsdl-analyzer.com/) or [SOAP UI](https://www.soapui.org/).

The WSDL-s can be found from [X-Road catalog](https://x-tee.ee/catalogue/EE). 

## Sending SOAP envelope

Samples use same `$envelope` generated above.

### Using Guzzle

```php

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