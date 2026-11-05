<?php

namespace Nfse\Tests\Unit\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nfse\Dto\Http\ConsultaEventoResponse;
use Nfse\Dto\Http\EventoDto;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\SefinClient;
use Nfse\Http\NfseContext;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class SefinClientConsultarEventoTest extends TestCase
{
    private const CHAVE_ACESSO = '12345678901234567890123456789012345678901234567890';

    private const XML_EVENTO = '<?xml version="1.0" encoding="utf-8"?>'
        .'<evento versao="1.01" xmlns="http://www.sped.fazenda.gov.br/nfse">'
        .'<infEvento Id="EVT'.self::CHAVE_ACESSO.'101101001">'
        .'<nSeqEvento>1</nSeqEvento>'
        .'</infEvento></evento>';

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

    private function respostaComEvento(string $arquivoXml): array
    {
        return [
            'tipoAmbiente' => 1,
            'versaoAplicativo' => 'SefinNacional_1.6.0',
            'dataHoraProcessamento' => '2026-11-03T16:02:37.7141777-03:00',
            'eventos' => [
                [
                    'chaveAcesso' => self::CHAVE_ACESSO,
                    'tipoEvento' => 101101,
                    'numeroPedidoRegistroEvento' => 1,
                    'dataHoraRecebimento' => '2026-11-03T15:43:46.703',
                    'arquivoXml' => $arquivoXml,
                ],
            ],
        ];
    }

    public function test_consultar_evento_mapeia_a_lista_e_descompacta_o_arquivo_xml(): void
    {
        // A consulta de evento entrega DUAS camadas de base64 sobre o gzip.
        $arquivoXml = base64_encode(base64_encode(gzencode(self::XML_EVENTO)));

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($this->respostaComEvento($arquivoXml))),
        ]);

        $response = $client->consultarEvento(self::CHAVE_ACESSO, 101101, 1);

        $this->assertInstanceOf(ConsultaEventoResponse::class, $response);
        $this->assertSame(1, $response->tipoAmbiente);
        $this->assertCount(1, $response->eventos);

        $evento = $response->primeiroEvento();

        $this->assertInstanceOf(EventoDto::class, $evento);
        $this->assertSame(self::CHAVE_ACESSO, $evento->chaveAcesso);
        $this->assertSame(101101, $evento->tipoEvento);
        $this->assertSame(1, $evento->numeroPedidoRegistroEvento);
        $this->assertSame('2026-11-03T15:43:46.703', $evento->dataHoraRecebimento);
        $this->assertSame($arquivoXml, $evento->arquivoXml);
        $this->assertSame(self::XML_EVENTO, $evento->arquivoXmlDecodificado());
    }

    public function test_consultar_evento_aceita_arquivo_xml_em_base64_simples(): void
    {
        $arquivoXml = base64_encode(gzencode(self::XML_EVENTO));

        $client = $this->createClientWithMock([
            new Response(200, [], json_encode($this->respostaComEvento($arquivoXml))),
        ]);

        $evento = $client->consultarEvento(self::CHAVE_ACESSO, 101101, 1)->primeiroEvento();

        $this->assertNotNull($evento);
        $this->assertSame(self::XML_EVENTO, $evento->arquivoXmlDecodificado());
    }

    public function test_consultar_evento_sem_eventos_retorna_lista_vazia(): void
    {
        $client = $this->createClientWithMock([
            new Response(200, [], json_encode([
                'tipoAmbiente' => 1,
                'versaoAplicativo' => 'SefinNacional_1.6.0',
                'dataHoraProcessamento' => '2026-11-03T16:02:37.7141777-03:00',
                'eventos' => [],
            ])),
        ]);

        $response = $client->consultarEvento(self::CHAVE_ACESSO, 101101, 1);

        $this->assertSame([], $response->eventos);
        $this->assertNull($response->primeiroEvento());
    }

    public function test_arquivo_xml_ausente_ou_invalido_nao_quebra_a_decodificacao(): void
    {
        $this->assertNull((new EventoDto)->arquivoXmlDecodificado());
        $this->assertNull((new EventoDto(arquivoXml: 'nao-e-base64'))->arquivoXmlDecodificado());
        $this->assertNull((new EventoDto(arquivoXml: base64_encode('nao-e-gzip')))->arquivoXmlDecodificado());
    }

    public function test_listar_eventos_nao_existe_na_api(): void
    {
        $client = new SefinClient(new NfseContext(
            TipoAmbiente::Homologacao,
            'fake/path.pfx',
            'password'
        ));

        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('não expõe listagem de eventos');

        $client->listarEventos(self::CHAVE_ACESSO);
    }

    public function test_listar_eventos_por_tipo_nao_existe_na_api(): void
    {
        $client = new SefinClient(new NfseContext(
            TipoAmbiente::Homologacao,
            'fake/path.pfx',
            'password'
        ));

        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('não expõe listagem de eventos');

        $client->listarEventosPorTipo(self::CHAVE_ACESSO, 101101);
    }
}
