<?php

namespace Nfse\Tests\Unit\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nfse\Dto\Http\MensagemProcessamentoDto;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\SefinClient;
use Nfse\Http\Exceptions\NfseApiException;
use Nfse\Http\NfseContext;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class NfseApiExceptionTest extends TestCase
{
    // ---------------------------------------------------------------
    // NfseApiException unit tests
    // ---------------------------------------------------------------

    public function test_request_error_defaults()
    {
        $e = NfseApiException::requestError('something went wrong');

        $this->assertStringContainsString('Erro na requisição', $e->getMessage());
        $this->assertStringContainsString('something went wrong', $e->getMessage());
        $this->assertNull($e->getRawResponse());
        $this->assertSame([], $e->getErrors());
        $this->assertSame(0, $e->getCode());
    }

    public function test_response_error_defaults()
    {
        $e = NfseApiException::responseError('api returned bad data');

        $this->assertStringContainsString('Erro na resposta da API', $e->getMessage());
        $this->assertNull($e->getRawResponse());
        $this->assertSame([], $e->getErrors());
    }

    public function test_request_error_with_raw_response_and_errors()
    {
        $raw = '{"erros":[{"Codigo":"RNG6110","Descricao":"Falha","Complemento":"detail"}]}';
        $errors = [
            new MensagemProcessamentoDto(['codigo' => 'RNG6110', 'descricao' => 'Falha', 'complemento' => 'detail']),
        ];

        $e = NfseApiException::requestError('msg', 400, $raw, $errors);

        $this->assertSame($raw, $e->getRawResponse());
        $this->assertCount(1, $e->getErrors());
        $this->assertSame('RNG6110', $e->getErrors()[0]->codigo);
        $this->assertSame('Falha', $e->getErrors()[0]->descricao);
        $this->assertSame('detail', $e->getErrors()[0]->complemento);
        $this->assertSame(400, $e->getCode());
    }

    public function test_response_error_with_raw_response_and_errors()
    {
        $raw = '{"erros":[{"Codigo":"ERR001","Descricao":"Desc","Complemento":"comp"}]}';
        $errors = [
            new MensagemProcessamentoDto(['codigo' => 'ERR001', 'descricao' => 'Desc', 'complemento' => 'comp']),
        ];

        $e = NfseApiException::responseError('api error', 0, $raw, $errors);

        $this->assertSame($raw, $e->getRawResponse());
        $this->assertCount(1, $e->getErrors());
        $this->assertSame('ERR001', $e->getErrors()[0]->codigo);
    }

    // ---------------------------------------------------------------
    // SefinClient — 400 response with structured errors (erros array)
    // ---------------------------------------------------------------

    private function createSefinClientWithMock(array $responses): SefinClient
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

    public function test_sefi_client_post_400_with_erros_array_populates_exception()
    {
        $errorBody = json_encode([
            'erros' => [
                ['Codigo' => 'RNG6110', 'Descricao' => 'Falha Schema Xml', 'Complemento' => "The 'xLgr' element is invalid"],
            ],
        ]);

        $client = $this->createSefinClientWithMock([
            new Response(400, [], $errorBody),
        ]);

        try {
            $client->emitirNfse('fake-payload');
            $this->fail('Expected NfseApiException was not thrown');
        } catch (NfseApiException $e) {
            $this->assertSame($errorBody, $e->getRawResponse());
            $this->assertCount(1, $e->getErrors());
            $this->assertSame('RNG6110', $e->getErrors()[0]->codigo);
            $this->assertSame('Falha Schema Xml', $e->getErrors()[0]->descricao);
            $this->assertSame("The 'xLgr' element is invalid", $e->getErrors()[0]->complemento);
        }
    }

    public function test_sefi_client_post_400_without_structured_errors_has_empty_errors()
    {
        $errorBody = 'Bad Request plain text';

        $client = $this->createSefinClientWithMock([
            new Response(400, [], $errorBody),
        ]);

        try {
            $client->emitirNfse('fake-payload');
            $this->fail('Expected NfseApiException was not thrown');
        } catch (NfseApiException $e) {
            $this->assertSame([], $e->getErrors());
        }
    }

    public function test_sefi_client_get_400_with_erros_array_populates_exception()
    {
        $errorBody = json_encode([
            'erros' => [
                ['Codigo' => 'NOT_FOUND', 'Descricao' => 'NFS-e não encontrada', 'Complemento' => null],
            ],
        ]);

        $client = $this->createSefinClientWithMock([
            new Response(400, [], $errorBody),
        ]);

        try {
            $client->consultarNfse('CHAVE123');
            $this->fail('Expected NfseApiException was not thrown');
        } catch (NfseApiException $e) {
            $this->assertSame($errorBody, $e->getRawResponse());
            $this->assertCount(1, $e->getErrors());
            $this->assertSame('NOT_FOUND', $e->getErrors()[0]->codigo);
        }
    }

    // ---------------------------------------------------------------
    // SefinClient::mapMensagens() — PascalCase and lowercase handling
    // ---------------------------------------------------------------

    public function test_sefi_client_maps_pascal_case_error_fields()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2024-01-01T00:00:00',
            'idDps' => 'DPS123',
            'chaveAcesso' => null,
            'nfseXmlGZipB64' => null,
            'alertas' => [],
            'erros' => [
                ['Codigo' => 'RNG6110', 'Descricao' => 'Falha Schema Xml', 'Complemento' => 'detail'],
            ],
        ];

        $client = $this->createSefinClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->emitirNfse('fake-payload');

        $this->assertCount(1, $response->erros);
        $this->assertSame('RNG6110', $response->erros[0]->codigo);
        $this->assertSame('Falha Schema Xml', $response->erros[0]->descricao);
        $this->assertSame('detail', $response->erros[0]->complemento);
    }

    public function test_sefi_client_maps_lowercase_error_fields()
    {
        $responseData = [
            'tipoAmbiente' => 2,
            'versaoAplicativo' => '1.0',
            'dataHoraProcessamento' => '2024-01-01T00:00:00',
            'idDps' => 'DPS123',
            'chaveAcesso' => null,
            'nfseXmlGZipB64' => null,
            'alertas' => [],
            'erros' => [
                ['codigo' => 'ERR001', 'descricao' => 'Erro lowercase', 'complemento' => 'info'],
            ],
        ];

        $client = $this->createSefinClientWithMock([
            new Response(200, [], json_encode($responseData)),
        ]);

        $response = $client->emitirNfse('fake-payload');

        $this->assertCount(1, $response->erros);
        $this->assertSame('ERR001', $response->erros[0]->codigo);
        $this->assertSame('Erro lowercase', $response->erros[0]->descricao);
        $this->assertSame('info', $response->erros[0]->complemento);
    }
}
