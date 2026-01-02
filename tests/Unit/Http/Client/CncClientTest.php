<?php

namespace Nfse\Tests\Unit\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\CncClient;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class CncClientTest extends TestCase
{
    private function createClientWithMock(array $responses): CncClient
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        $httpClient = new Client(['handler' => $handlerStack]);

        $context = new NfseContext(
            TipoAmbiente::Homologacao,
            'fake/path.pfx',
            'password'
        );

        $client = new CncClient($context);

        $reflection = new ReflectionClass($client);
        $property = $reflection->getProperty('httpClient');
        $property->setAccessible(true);
        $property->setValue($client, $httpClient);

        return $client;
    }

    public function test_consultar_contribuinte()
    {
        $responseData = ['cpfCnpj' => '12345678000199', 'nome' => 'Empresa Teste'];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->consultarContribuinte('12345678000199');

        $this->assertEquals($responseData, $response);
    }

    public function test_baixar_alteracoes_cadastro()
    {
        $responseData = ['nsu' => 100, 'eventos' => []];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->baixarAlteracoesCadastro(100);

        $this->assertEquals($responseData, $response);
    }

    public function test_atualizar_contribuinte()
    {
        $responseData = ['status' => 'sucesso'];
        $payload = ['cpfCnpj' => '12345678000199'];

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->atualizarContribuinte($payload);

        $this->assertEquals($responseData, $response);
    }

    public function test_request_error_throws_exception()
    {
        $client = $this->createClientWithMock([
            new Response(400, [], 'Bad Request'),
        ]);

        $this->expectException(NfseApiException::class);
        $client->consultarContribuinte('123');
    }

    public function test_invalid_json_throws_exception()
    {
        $client = $this->createClientWithMock([
            new Response(200, [], 'invalid json'),
        ]);

        $this->expectException(NfseApiException::class);
        $this->expectExceptionMessage('Resposta inválida (não é JSON)');
        $client->consultarContribuinte('123');
    }
}
