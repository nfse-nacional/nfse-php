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
        $property->setAccessible(true);
        $property->setValue($client, $httpClient);

        return $client;
    }

    public function test_consultar_parametros_convenio()
    {
        $responseData = [
            'mensagem' => 'Sucesso',
            'parametrosConvenio' => ['tipoConvenio' => 1]
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarParametrosConvenio('3550308');

        $this->assertInstanceOf(\Nfse\Dto\Http\ResultadoConsultaConfiguracoesConvenioResponse::class, $response);
        $this->assertEquals('Sucesso', $response->mensagem);
        $this->assertEquals(1, $response->parametrosConvenio->tipoConvenio);
    }

    public function test_baixar_dfe_contribuinte()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'ultimoNSU' => 100,
            'listaNSU' => [
                ['nsu' => 100, 'xmlGZipB64' => 'base64'],
            ],
        ];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->baixarDfeContribuinte(100);

        $this->assertInstanceOf(\Nfse\Dto\Http\DistribuicaoDfeResponse::class, $response);
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
}
