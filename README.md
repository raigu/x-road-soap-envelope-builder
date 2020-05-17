[![Latest Stable Version](https://poser.pugx.org/raigu/x-road-soap-envelope-builder/v/stable)](https://packagist.org/packages/raigu/x-road-soap-envelope-builder)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Build Status](https://travis-ci.com/raigu/x-road-soap-envelope-builder.svg?branch=master)](https://travis-ci.com/raigu/x-road-soap-envelope-builder)
[![codecov](https://codecov.io/gh/raigu/x-road-soap-envelope-builder/branch/master/graph/badge.svg)](https://codecov.io/gh/raigu/x-road-soap-envelope-builder)
[![Scrutinizer](https://scrutinizer-ci.com/g/raigu/x-road-soap-envelope-builder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/raigu/x-road-soap-envelope-builder/)

# x-road-soap-envelope-builder

PHP library for generating a SOAP envelope for X-Road request.

# Requirements

* php 7.2+
* DOM extension

# Installation

```bash
$ composer require raigu/x-road-soap-envelope-builder
``` 

# Usage

## Building SOAP envelope for X-Road request

```php
$builder = \Raigu\XRoad\SoapEnvelope\SoapEnvelopeBuilder::create()
    ->withService('EE/GOV/70008440/rr/RR437/v1')
    ->withClient('EE/COM/12213008/gathering')
    ->withBody(<<<EOD
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

The method's `withBody` input parameter can be generated from
WSDL using free tools like [WSDL Analyzer](http://www.wsdl-analyzer.com/) or [SOAP UI](https://www.soapui.org/). 
The WSDL-s can be found in [X-Road catalog](https://x-tee.ee/catalogue/EE). 

See short (1:34) demo [video](https://youtu.be/ziQIwlTtPLA) how to acquire WSDL and generate a request body.

## Builder methods
| Method name | Mandatory | Description                                                                                                                                                                                                                                                                           |
|-------------|-----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| withService | Y         | service id. <br/>Format: `{xRoadInstance}/{memberClass}/{memberCode}/(subsystemCode}/{serviceCode}/{serviceVersion}`                                                                                                                                                                   |
| withClient  | Y         | client id. <br/>Format: `{xRoadInstance}/{memberClass}/{memberCode}/(subsystemCode}`                                                                                                                                                                                                   |
| withBody    | Y         | X-Road service request witch is but into the X-Road message body. See short [video](https://youtu.be/ziQIwlTtPLA) how you can find the WSDL based on service id and generate body from WSDL. If you use SoapUI make sure you do not miss the XML proper namespace definition. |
| withUserId  | N         | natural person code who is initiating the request. Format: `{isoCountryCode2Alfa}/{personCode}`. Optional.                                                                                                                                                                            |
| withRepresentedParty | N | Party who is represented by client. See [X-Road Third Party Representation Extension](https://x-tee.ee/docs/live/xroad/pr-third_party_representation_extension.html) for more info.<br/>Format: `[{partyClass}/]{partyCode}`. Optional. |

## Making X-Road request

In following samples assign your X-Road security server URL to `$securityServerUrl`.

### Using Guzzle

```php
$client = new \Guzzle\Http\Client();
$request = $client->post(
    $securityServerUrl,
    [ 
        'Content-Type' => 'text/xml',
        'SOAPAction' => ''
    ],
    $envelope
);

$response = $client->send($request);

echo $response->getBody();
```

### Using curl

```php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $securityServerUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $envelope);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type' => 'text/xml',
        'SOAPAction' => ''
    ]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

curl_close($ch);

echo $output;
```
 
# References

* [X-Road Terms and Abbreviations](https://www.x-tee.ee/docs/live/xroad/terms_x-road_docs.html)
* [X-Road: Message Protocol v4.0](https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#e1-request)