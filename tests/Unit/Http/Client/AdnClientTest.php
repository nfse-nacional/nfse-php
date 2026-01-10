<?php

namespace Nfse\Tests\Unit\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\NfseContext;
use PHPUnit\Framework\TestCase;
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

        $property->setValue($client, $httpClient);

        return $client;
    }

    public function test_consultar_parametros_convenio()
    {
        $responseData = [
            'mensagem' => 'Sucesso',
            'parametrosConvenio' => ['aderenteAmbienteNacional' => 1],
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarParametrosConvenio('3550308');

        $this->assertInstanceOf(\Nfse\Http\Dto\ResultadoConsultaConfiguracoesConvenioResponse::class, $response);
        $this->assertEquals('Sucesso', $response->mensagem);
        $this->assertEquals(1, $response->parametrosConvenio->aderenteAmbienteNacional);
    }

    public function test_baixar_dfe_contribuinte()
    {
        $responseData = [
            'TipoAmbiente' => 2,
            'UltimoNSU' => 100,
            'LoteDFe' => [
                ['NSU' => 100, 'ArquivoXml' => 'base64'],
            ],
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->baixarDfeContribuinte(100);

        $this->assertInstanceOf(\Nfse\Http\Dto\DistribuicaoDfeResponse::class, $response);
        $this->assertEquals(100, $response->ultimoNsu);
    }

    public function test_obter_danfse()
    {
        $pdfContent = '%PDF-1.4';

        $client = $this->createClientWithMock([
            new Response(200, [], $pdfContent),
        ]);

        $response = $client->obterDanfse('CHAVE123');

        $this->assertEquals($pdfContent, $response);
    }

    public function test_consultar_eventos_contribuinte()
    {
        $responseData = [['tipoEvento' => 101101]];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarEventosContribuinte('CHAVE123');

        $this->assertEquals($responseData, $response);
    }

    public function test_baixar_dfe_municipio()
    {
        $responseData = [
            'UltimoNSU' => 100,
            'LoteDFe' => [],
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->baixarDfeMunicipio(100);

        $this->assertInstanceOf(\Nfse\Http\Dto\DistribuicaoDfeResponse::class, $response);
        $this->assertEquals(100, $response->ultimoNsu);
    }

    public function test_enviar_lote()
    {
        $responseData = ['protocolo' => '123'];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->enviarLote('base64data');

        $this->assertEquals($responseData, $response);
    }

    public function test_consultar_aliquota()
    {
        $responseData = [
            'mensagem' => 'Sucesso',
            'aliquotas' => [
                '01.01.00.001' => [
                    ['Incidencia' => '1', 'Aliq' => 5.0, 'DtIni' => '2023-01-01'],
                ],
            ],
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarAliquota('3550308', '01.01.00.001', '2025-01-01');

        $this->assertInstanceOf(\Nfse\Http\Dto\ResultadoConsultaAliquotasResponse::class, $response);
        $this->assertArrayHasKey('01.01.00.001', $response->aliquotas);
        $this->assertEquals(5.0, $response->aliquotas['01.01.00.001'][0]->aliquota);
    }

    public function test_consultar_historico_aliquotas()
    {
        $responseData = [
            'mensagem' => 'Sucesso',
            'aliquotas' => [],
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarHistoricoAliquotas('3550308', '01.01.00.001');

        $this->assertInstanceOf(\Nfse\Http\Dto\ResultadoConsultaAliquotasResponse::class, $response);
    }

    public function test_consultar_beneficio()
    {
        $responseData = [];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarBeneficio('3550308', 'BENEF123', '2025-01');

        $this->assertEquals($responseData, $response);
    }

    public function test_consultar_regimes_especiais()
    {
        $responseData = [];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarRegimesEspeciais('3550308', '01.01.00.001', '2025-01');

        $this->assertEquals($responseData, $response);
    }

    public function test_consultar_retencoes()
    {
        $responseData = [];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarRetencoes('3550308', '2025-01');

        $this->assertEquals($responseData, $response);
    }

    public function test_request_error_throws_exception()
    {
        $client = $this->createClientWithMock([
            new Response(400, [], 'Bad Request'),
        ]);

        $this->expectException(\Nfse\Http\Exceptions\NfseApiException::class);
        $client->baixarDfeContribuinte(100);
    }

    public function test_invalid_json_throws_exception()
    {
        $client = $this->createClientWithMock([
            new Response(200, [], 'invalid json'),
        ]);

        $this->expectException(\Nfse\Http\Exceptions\NfseApiException::class);
        $this->expectExceptionMessage('Resposta inválida (não é JSON)');
        $client->baixarDfeContribuinte(100);
    }
}
