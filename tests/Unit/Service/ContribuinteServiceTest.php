<?php

namespace Nfse\Tests\Unit\Service;

use Nfse\Dto\Http\ConsultaNfseResponse;
use Nfse\Dto\Http\EmissaoNfseResponse;
use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Contracts\SefinNacionalInterface;
use Nfse\Http\NfseContext;
use Nfse\Service\ContribuinteService;
use Nfse\Support\IdGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ContribuinteServiceTest extends TestCase
{
    private $context;

    private $service;

    private $sefinClientMock;

    private $adnClientMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->context = new NfseContext(
            TipoAmbiente::Homologacao,
            __DIR__.'/../../fixtures/certs/test.pfx',
            '1234'
        );

        $this->sefinClientMock = $this->createMock(SefinNacionalInterface::class);
        $this->adnClientMock = $this->createMock(AdnClient::class);

        $this->service = new ContribuinteService($this->context);

        $reflection = new ReflectionClass($this->service);

        $sefinProperty = $reflection->getProperty('sefinClient');
        $sefinProperty->setAccessible(true);
        $sefinProperty->setValue($this->service, $this->sefinClientMock);

        $adnProperty = $reflection->getProperty('adnClient');
        $adnProperty->setAccessible(true);
        $adnProperty->setValue($this->service, $this->adnClientMock);
    }

    public function test_emitir_nfse_success()
    {
        $idDps = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1');
        $dpsData = new DpsData(
            versao: '1.00',
            infDps: new InfDpsData(
                id: $idDps,
                tipoAmbiente: 2,
                dataEmissao: '2023-10-27T10:00:00',
                versaoAplicativo: '1.0',
                serie: '1',
                numeroDps: '1',
                dataCompetencia: '2023-10-27',
                tipoEmitente: 1,
                codigoLocalEmissao: '3550308'
            )
        );

        $responseDto = new EmissaoNfseResponse(
            tipoAmbiente: 2,
            versaoAplicativo: '1.0',
            dataHoraProcessamento: '2023-10-27T10:00:00',
            idDps: 'DPS123',
            chaveAcesso: 'CHAVE123',
            nfseXmlGZipB64: base64_encode(gzencode('<nfse>xml</nfse>'))
        );

        $this->sefinClientMock->expects($this->once())
            ->method('emitirNfse')
            ->willReturn($responseDto);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Parser de XML ainda não implementado');

        $this->service->emitir($dpsData);
    }

    public function test_consultar_nfse_success()
    {
        $chave = '12345678901234567890123456789012345678901234567890';
        $xmlContent = '<nfse>Dados da Nota</nfse>';
        $encodedXml = base64_encode(gzencode($xmlContent));

        $responseDto = new ConsultaNfseResponse(
            tipoAmbiente: 2,
            versaoAplicativo: '1.0',
            dataHoraProcessamento: '2023-10-27T10:00:00',
            chaveAcesso: $chave,
            nfseXmlGZipB64: $encodedXml
        );

        $this->sefinClientMock->expects($this->once())
            ->method('consultarNfse')
            ->with($chave)
            ->willReturn($responseDto);

        try {
            $this->service->consultar($chave);
        } catch (\Exception $e) {
            $this->assertStringContainsString('Parser de XML ainda não implementado', $e->getMessage());
            $this->assertStringContainsString('Dados da Nota', $e->getMessage());
        }
    }

    public function test_download_danfse_success()
    {
        $chave = '12345678901234567890123456789012345678901234567890';
        $pdfContent = '%PDF-1.4 content...';

        $this->adnClientMock->expects($this->once())
            ->method('obterDanfse')
            ->with($chave)
            ->willReturn($pdfContent);

        $result = $this->service->downloadDanfse($chave);

        $this->assertEquals($pdfContent, $result);
    }

    public function test_consultar_dps_success()
    {
        $idDps = 'DPS123';
        $responseDto = new \Nfse\Dto\Http\ConsultaDpsResponse(
            tipoAmbiente: 2,
            versaoAplicativo: '1.0',
            dataHoraProcessamento: '2023-10-27T10:00:00',
            idDps: $idDps,
            chaveAcesso: 'CHAVE123'
        );

        $this->sefinClientMock->expects($this->once())
            ->method('consultarDps')
            ->with($idDps)
            ->willReturn($responseDto);

        $result = $this->service->consultarDps($idDps);

        $this->assertEquals($responseDto, $result);
    }

    public function test_verificar_dps_success()
    {
        $idDps = 'DPS123';
        $this->sefinClientMock->expects($this->once())
            ->method('verificarDps')
            ->with($idDps)
            ->willReturn(true);

        $result = $this->service->verificarDps($idDps);

        $this->assertTrue($result);
    }

    public function test_baixar_dfe_contribuinte()
    {
        $responseDto = new \Nfse\Dto\Http\DistribuicaoDfeResponse(ultimoNsu: 100, listaNsu: []);
        $this->adnClientMock->expects($this->once())
            ->method('baixarDfeContribuinte')
            ->with(100)
            ->willReturn($responseDto);

        $result = $this->service->baixarDfe(100);

        $this->assertEquals($responseDto, $result);
    }

    public function test_consultar_parametros_convenio()
    {
        $response = new \Nfse\Dto\Http\ResultadoConsultaConfiguracoesConvenioResponse(
            mensagem: 'Sucesso',
            parametrosConvenio: new \Nfse\Dto\Http\ParametrosConfiguracaoConvenioDto(tipoConvenio: 1)
        );

        $this->adnClientMock->expects($this->once())
            ->method('consultarParametrosConvenio')
            ->with('3550308')
            ->willReturn($response);

        $result = $this->service->consultarParametrosConvenio('3550308');

        $this->assertInstanceOf(\Nfse\Dto\Http\ResultadoConsultaConfiguracoesConvenioResponse::class, $result);
        $this->assertEquals('Sucesso', $result->mensagem);
    }

    public function test_consultar_aliquota()
    {
        $response = new \Nfse\Dto\Http\ResultadoConsultaAliquotasResponse(
            mensagem: 'Sucesso',
            aliquotas: ['01.01.00.001' => [new \Nfse\Dto\Http\AliquotaDto(aliquota: 5.0)]]
        );

        $this->adnClientMock->expects($this->once())
            ->method('consultarAliquota')
            ->with('3550308', '01.01.00.001', '2025-01-01T12:00:00')
            ->willReturn($response);

        $result = $this->service->consultarAliquota('3550308', '01.01.00.001', '2025-01-01T12:00:00');

        $this->assertInstanceOf(\Nfse\Dto\Http\ResultadoConsultaAliquotasResponse::class, $result);
        $this->assertEquals('Sucesso', $result->mensagem);
    }
}
