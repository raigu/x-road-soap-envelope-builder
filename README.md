# x-road-soap-envelope-builder

PHP library for generating SOAP envelope of X-Road request.

Useful for making requests over X-Road using third-party HTTP libraries.

# Requirements

* php 7.1+
* DOM extension

# Installation

```bash
$ composer require raigu/x-road-soap-envelope-builder
``` 

# Usage

## Building SOAP envelope of X-Road Request

```php
$builder = \Raigu\XRoad\SoapEnvelopeBuilder::create()
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

The method's `withXRoadMessageBody` input parameter can be generated from
 WSDL using free tools like [WSDL Analyzer](http://www.wsdl-analyzer.com/) or [SOAP UI](https://www.soapui.org/).

The WSDL-s can be found on [X-Road catalog](https://x-tee.ee/catalogue/EE). 

## Making X-Road request

Assign to `$securityServerUrl` your security server URL in following samples.

### Using Guzzle

```php
$client = new \Guzzle\Http\Client();
$request = $client->post(
    $securityServerUrl,
    [ "Content-Type" => "text/xml"],
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
    'Content-Type: text/xml',
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);

curl_close($ch);

echo $output;
```
 
# References

* [X-Road Terms and Abbreviations](https://www.x-tee.ee/docs/live/xroad/terms_x-road_docs.html)
* [X-Road: Message Protocol v4.0](https://www.x-tee.ee/docs/live/xroad/pr-mess_x-road_message_protocol.html#e1-request)