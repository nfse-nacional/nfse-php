<?php

namespace Nfse\Tests\Unit\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nfse\Http\Dto\ConsultaNfseResponse;
use Nfse\Http\Dto\EmissaoNfseResponse;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\SefinClient;
use Nfse\Http\NfseContext;
use PHPUnit\Framework\TestCase;
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

        $property->setValue($client, $httpClient);

        return $client;
    }

    public function test_emitir_nfse()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2023-10-27T10:00:00',
            'idDps' => 'DPS123',
            'chaveAcesso' => 'CHAVE123',
            'nfseXmlGZipB64' => base64_encode(gzencode('<nfse>xml</nfse>')),
            'alertas' => [],
            'erros' => [],
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->emitirNfse('fake-payload');

        $this->assertInstanceOf(EmissaoNfseResponse::class, $response);
        $this->assertEquals('CHAVE123', $response->chaveAcesso);
    }

    public function test_consultar_nfse()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2023-10-27T10:00:00',
            'chaveAcesso' => 'CHAVE123',
            'nfseXmlGZipB64' => base64_encode(gzencode('<nfse>xml</nfse>')),
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarNfse('CHAVE123');

        $this->assertInstanceOf(ConsultaNfseResponse::class, $response);
        $this->assertEquals('CHAVE123', $response->chaveAcesso);
    }

    public function test_verificar_dps()
    {
        $client = $this->createClientWithMock([
            new Response(200),
            new Response(404),
        ]);

        $this->assertTrue($client->verificarDps('DPS123'));
        $this->assertFalse($client->verificarDps('DPS456'));
    }

    public function test_consultar_dps()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2023-10-27T10:00:00',
            'idDps' => 'DPS123',
            'chaveAcesso' => 'CHAVE123',
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarDps('DPS123');

        $this->assertInstanceOf(\Nfse\Http\Dto\ConsultaDpsResponse::class, $response);
        $this->assertEquals('DPS123', $response->idDps);
    }

    public function test_registrar_evento()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2023-10-27T10:00:00',
            'eventoXmlGZipB64' => 'base64',
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->registrarEvento('CHAVE123', 'payload');

        $this->assertInstanceOf(\Nfse\Http\Dto\RegistroEventoResponse::class, $response);
        $this->assertEquals('base64', $response->eventoXmlGZipB64);
    }

    public function test_consultar_evento()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2023-10-27T10:00:00',
            'eventoXmlGZipB64' => 'base64',
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarEvento('CHAVE123', 101101, 1);

        $this->assertInstanceOf(\Nfse\Http\Dto\RegistroEventoResponse::class, $response);
    }

    public function test_listar_eventos()
    {
        $responseData = [['tipoEvento' => 101101]];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->listarEventos('CHAVE123');

        $this->assertEquals($responseData, $response);
    }

    public function test_listar_eventos_por_tipo()
    {
        $responseData = [['tipoEvento' => 101101]];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->listarEventosPorTipo('CHAVE123', 101101);

        $this->assertEquals($responseData, $response);
    }

    public function test_verificar_dps_error_throws_exception()
    {
        $client = $this->createClientWithMock([
            new Response(500, [], 'Server Error'),
        ]);

        $this->expectException(\Nfse\Http\Exceptions\NfseApiException::class);
        $client->verificarDps('DPS123');
    }

    public function test_post_invalid_json_throws_exception()
    {
        $client = $this->createClientWithMock([
            new Response(200, [], 'invalid json'),
        ]);

        $this->expectException(\Nfse\Http\Exceptions\NfseApiException::class);
        $this->expectExceptionMessage('Resposta inválida da API');
        $client->emitirNfse('payload');
    }
}
