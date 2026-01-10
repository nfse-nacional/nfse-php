<?php

namespace Nfse\Tests\Unit\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Nfse\Http\Dto\RegistroEventoResponse;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\SefinClient;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class SefinClientRegistrarTest extends TestCase
{
    private function createClientWithMock(array $responses): SefinClient
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        $httpClient = new Client(['handler' => $handlerStack]);

        $context = new NfseContext(
            TipoAmbiente::Homologacao,
            'fake/path.pfx',
            'password'
        );

        $client = new SefinClient($context);

        $reflection = new ReflectionClass($client);
        $property = $reflection->getProperty('httpClient');

        $property->setValue($client, $httpClient);

        return $client;
    }

    public function test_registrar_evento_success()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2025-01-01T12:00:00',
            'eventoXmlGZipB64' => base64_encode(gzencode('<evento>ok</evento>')),
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $result = $client->registrarEvento('CHAVE123', 'payload');

        $this->assertInstanceOf(RegistroEventoResponse::class, $result);
        $this->assertEquals($responseData['eventoXmlGZipB64'], $result->eventoXmlGZipB64);
    }

    public function test_registrar_evento_request_error_throws_nfse_exception()
    {
        $request = new Request('POST', '/nfse/CHAVE123/eventos');
        $exception = new RequestException('Network error', $request);

        $client = $this->createClientWithMock([
            $exception,
        ]);

        $this->expectException(NfseApiException::class);
        $client->registrarEvento('CHAVE123', 'payload');
    }
}
