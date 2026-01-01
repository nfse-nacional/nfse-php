<?php

namespace Nfse\Tests\Unit\Http\Client;

use Nfse\Http\Client\SefinClient;
use Nfse\Http\NfseContext;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Dto\EmissaoNfseResponse;
use Nfse\Http\Dto\ConsultaNfseResponse;
use Nfse\Http\Dto\ConsultaDpsResponse;
use Nfse\Http\Dto\RegistroEventoResponse;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use ReflectionClass;

class SefinClientTest extends TestCase
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
        $property->setAccessible(true);
        $property->setValue($client, $httpClient);

        return $client;
    }

    public function testEmitirNfse()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2023-10-27T10:00:00',
            'idDps' => 'DPS123',
            'chaveAcesso' => 'CHAVE123',
            'nfseXmlGZipB64' => base64_encode(gzencode('<nfse>xml</nfse>')),
            'alertas' => [],
            'erros' => []
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData))
        ]);

        $response = $client->emitirNfse('fake-payload');

        $this->assertInstanceOf(EmissaoNfseResponse::class, $response);
        $this->assertEquals('CHAVE123', $response->chaveAcesso);
    }

    public function testConsultarNfse()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2023-10-27T10:00:00',
            'chaveAcesso' => 'CHAVE123',
            'nfseXmlGZipB64' => base64_encode(gzencode('<nfse>xml</nfse>'))
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData))
        ]);

        $response = $client->consultarNfse('CHAVE123');

        $this->assertInstanceOf(ConsultaNfseResponse::class, $response);
        $this->assertEquals('CHAVE123', $response->chaveAcesso);
    }

    public function testVerificarDps()
    {
        $client = $this->createClientWithMock([
            new Response(200),
            new Response(404)
        ]);

        $this->assertTrue($client->verificarDps('DPS123'));
        $this->assertFalse($client->verificarDps('DPS456'));
    }
}
