<?php

namespace Nfse\Tests\Unit\Http\Client;

use Nfse\Http\Client\AdnClient;
use Nfse\Http\NfseContext;
use Nfse\Enums\TipoAmbiente;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use ReflectionClass;

class AdnClientTest extends TestCase
{
    private function createClientWithMock(array $responses): AdnClient
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        $httpClient = new Client(['handler' => $handlerStack]);

        $context = new NfseContext(
            TipoAmbiente::Homologacao,
            'fake/path.pfx',
            'password'
        );

        $client = new AdnClient($context);
        
        $reflection = new ReflectionClass($client);
        $property = $reflection->getProperty('httpClient');
        $property->setAccessible(true);
        $property->setValue($client, $httpClient);

        return $client;
    }

    public function testConsultarParametrosConvenio()
    {
        $responseData = ['param' => 'value'];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData))
        ]);

        $response = $client->consultarParametrosConvenio('3550308');

        $this->assertEquals($responseData, $response);
    }

    public function testObterDanfse()
    {
        $pdfContent = '%PDF-1.4';

        $client = $this->createClientWithMock([
            new Response(200, [], $pdfContent)
        ]);

        $response = $client->obterDanfse('CHAVE123');

        $this->assertEquals($pdfContent, $response);
    }
}
