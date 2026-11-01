<?php

use GuzzleHttp\Client;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Client\CncClient;
use Nfse\Http\Client\SefinClient;
use Nfse\Http\NfseContext;
use Nfse\Support\SefinEndpointResolver;

function httpClientDoClient(object $client): Client
{
    $property = new ReflectionProperty($client, 'httpClient');
    $property->setAccessible(true);

    return $property->getValue($client);
}

function contextoTls(): NfseContext
{
    return new NfseContext(TipoAmbiente::Producao, 'fake/path.pfx', 'password');
}

it('keeps TLS peer and host verification enabled', function (string $clientClass) {
    $httpClient = httpClientDoClient(new $clientClass(contextoTls()));
    $curl = $httpClient->getConfig('curl');

    expect($httpClient->getConfig('verify'))->toBeTrue()
        ->and($curl)->not->toHaveKey(CURLOPT_SSL_VERIFYPEER)
        ->and($curl)->not->toHaveKey(CURLOPT_SSL_VERIFYHOST);
})->with([
    'SEFIN' => [SefinClient::class],
    'ADN' => [AdnClient::class],
    'CNC' => [CncClient::class],
]);

it('pins municipal hosts that used to be called by IP', function (string $clientClass) {
    $curl = httpClientDoClient(new $clientClass(contextoTls()))->getConfig('curl');

    expect($curl[CURLOPT_RESOLVE])->toBe(SefinEndpointResolver::pinnedHosts());
})->with([
    'SEFIN' => [SefinClient::class],
    'ADN' => [AdnClient::class],
]);

it('keeps TLS verification enabled when using an NSS client certificate', function (string $clientClass) {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Producao,
        nssCertificateSelector: 'NSS Certificate DB:Test Certificate'
    );
    $httpClient = httpClientDoClient(new $clientClass($context));
    $curl = $httpClient->getConfig('curl');

    expect($httpClient->getConfig('verify'))->toBeTrue()
        ->and($curl)->not->toHaveKey(CURLOPT_SSL_VERIFYPEER)
        ->and($curl)->not->toHaveKey(CURLOPT_SSL_VERIFYHOST);
})->with([
    'SEFIN' => [SefinClient::class],
    'ADN' => [AdnClient::class],
    'CNC' => [CncClient::class],
]);
