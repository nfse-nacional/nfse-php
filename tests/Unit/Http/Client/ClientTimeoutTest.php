<?php

use GuzzleHttp\Client;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Client\CncClient;
use Nfse\Http\Client\SefinClient;
use Nfse\Http\NfseContext;

function httpClientParaTimeout(object $client): Client
{
    $property = new ReflectionProperty($client, 'httpClient');
    $property->setAccessible(true);

    return $property->getValue($client);
}

it('uses a 10s connect timeout and keeps the 60s total timeout', function (string $clientClass) {
    $context = new NfseContext(TipoAmbiente::Producao, 'fake/path.pfx', 'password');
    $httpClient = httpClientParaTimeout(new $clientClass($context));

    // Com o Retry (3 tentativas), o pior caso de um host inacessível fica em 3x10s + 3s.
    expect($httpClient->getConfig('connect_timeout'))->toBe(10)
        ->and($httpClient->getConfig('timeout'))->toBe(60);
})->with([
    'SEFIN' => [SefinClient::class],
    'ADN' => [AdnClient::class],
    'CNC' => [CncClient::class],
]);
