<?php

namespace Nfse\Tests\Unit\Http\Client;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Client\CncClient;
use Nfse\Http\Client\SefinClient;
use Nfse\Http\NfseContext;
use ReflectionClass;

it('configures TLS and timeouts through Guzzle request options, not raw cURL options', function (string $clientClass) {
    $mock = new MockHandler([new Response(200, [], '{}')]);
    $client = new $clientClass(new NfseContext(TipoAmbiente::Homologacao, 'fake/path.pfx', 'password'));

    $httpClient = (new ReflectionClass($client))->getProperty('httpClient')->getValue($client);
    $httpClient->getConfig('handler')->setHandler($mock);

    $httpClient->get('/');

    $options = $mock->getLastOptions();

    expect($options)->not->toHaveKey('curl')
        ->and($options['cert'])->toBe(['fake/path.pfx', 'password'])
        ->and($options['cert_type'])->toBe('P12')
        ->and($options['force_ip_resolve'])->toBe('v4')
        ->and($options['connect_timeout'])->toBe(30)
        ->and($options['timeout'])->toBe(60)
        ->and($options['verify'])->toBeFalse()
        ->and($mock->getLastRequest()->getProtocolVersion())->toBe('1.1');
})->with([SefinClient::class, AdnClient::class, CncClient::class]);
