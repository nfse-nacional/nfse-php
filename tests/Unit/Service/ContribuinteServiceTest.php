<?php

namespace Nfse\Tests\Unit\Service;

use Nfse\Http\Dto\ConsultaNfseResponse;
use Nfse\Http\Dto\EmissaoNfseResponse;
use Nfse\Dto\NFSe\InfNFSe\DPSData;
use Nfse\Dto\NFSeData;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Contracts\SefinNacionalInterface;
use Nfse\Http\NfseContext;
use Nfse\Service\ContribuinteService;
use Nfse\Support\IdGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPSData;

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
        $sefinProperty->setValue($this->service, $this->sefinClientMock);

        $adnProperty = $reflection->getProperty('adnClient');
        $adnProperty->setValue($this->service, $this->adnClientMock);
    }

    public function test_emitir_nfse_success()
    {
        $idDps = 'DPS123';
        $dpsData = new DPSData();
        $dpsData->versao = '1.00';
        $dpsData->infDPS = new InfDPSData();
        $dpsData->infDPS->id = $idDps;
        $dpsData->infDPS->tpAmb = 2;
        $dpsData->infDPS->dhEmi = '2023-10-27T10:00:00';
        $dpsData->infDPS->verAplic = '1.0';
        $dpsData->infDPS->serie = '1';
        $dpsData->infDPS->nDPS = '1';
        $dpsData->infDPS->dCompet = '2023-10-27';
        $dpsData->infDPS->tpEmit = 1;
        $dpsData->infDPS->cLocEmi = '3550308';
        
        $xmlContent = '<NFSe xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.00"><infNFSe Id="NFS123456" versao="1.00"><nNFSe>100</nNFSe><DPS versao="1.00"><infDPS Id="DPS123"><tpAmb>2</tpAmb><dhEmi>2023-10-27T10:00:00</dhEmi><verAplic>1.0</verAplic><serie>1</serie><nDPS>1</nDPS><dCompet>2023-10-27</dCompet><tpEmit>1</tpEmit><cLocEmi>3550308</cLocEmi></infDPS></DPS></infNFSe></NFSe>';
        
        $responseDto = new EmissaoNfseResponse();
        $responseDto->tipoAmbiente = 2;
        $responseDto->versaoAplicativo = '1.0';
        $responseDto->dataHoraProcessamento = '2023-10-27T10:00:00';
        $responseDto->idDps = 'DPS123';
        $responseDto->chaveAcesso = 'CHAVE123';
        $responseDto->nfseXmlGZipB64 = base64_encode(gzencode($xmlContent));

        $this->sefinClientMock->expects($this->once())
            ->method('emitirNfse')
            ->willReturn($responseDto);

        $result = $this->service->emitir($dpsData);

        $this->assertInstanceOf(NFSeData::class, $result);
        $this->assertEquals('100', $result->infNFSe->nNFSe);
    }

    public function test_consultar_nfse_success()
    {
        $chave = '12345678901234567890123456789012345678901234567890';
        $xmlContent = '<NFSe xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.00"><infNFSe Id="NFS123456" versao="1.00"><nNFSe>100</nNFSe><DPS versao="1.00"><infDPS Id="DPS123"><tpAmb>2</tpAmb><dhEmi>2023-10-27T10:00:00</dhEmi><verAplic>1.0</verAplic><serie>1</serie><nDPS>1</nDPS><dCompet>2023-10-27</dCompet><tpEmit>1</tpEmit><cLocEmi>3550308</cLocEmi></infDPS></DPS></infNFSe></NFSe>';
        $encodedXml = base64_encode(gzencode($xmlContent));

        $responseDto = new ConsultaNfseResponse();
            $responseDto->tipoAmbiente = 2;
            $responseDto->versaoAplicativo = '1.0';
            $responseDto->dataHoraProcessamento = '2023-10-27T10:00:00';
            $responseDto->chaveAcesso = $chave;
            $responseDto->nfseXmlGZipB64 = $encodedXml;

        $this->sefinClientMock->expects($this->once())
            ->method('consultarNfse')
            ->with($chave)
            ->willReturn($responseDto);

        $result = $this->service->consultar($chave);

        $this->assertInstanceOf(NFSeData::class, $result);
        $this->assertEquals('100', $result->infNFSe->nNFSe);
    }

    // ... other tests updated similarly ...

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
        $responseDto = new \Nfse\Http\Dto\ConsultaDpsResponse();
        $responseDto->tipoAmbiente = 2;
        $responseDto->versaoAplicativo = '1.0';
        $responseDto->dataHoraProcessamento = '2023-10-27T10:00:00';
        $responseDto->idDps = $idDps;
        $responseDto->chaveAcesso = 'CHAVE123';

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
        $responseDto = new \Nfse\Http\Dto\DistribuicaoDfeResponse();
        $responseDto->ultimoNsu = 100;
        $responseDto->listaNsu = [];

        $this->adnClientMock->expects($this->once())
            ->method('baixarDfeContribuinte')
            ->with(100)
            ->willReturn($responseDto);

        $result = $this->service->baixarDfe(100);

        $this->assertEquals($responseDto, $result);
    }

    public function test_consultar_parametros_convenio()
    {
        $params = new \Nfse\Http\Dto\ParametrosConfiguracaoConvenioDto();
        $params->tipoConvenio = 1;

        $response = new \Nfse\Http\Dto\ResultadoConsultaConfiguracoesConvenioResponse();
        $response->mensagem = 'Sucesso';
        $response->parametrosConvenio = $params;

        $this->adnClientMock->expects($this->once())
            ->method('consultarParametrosConvenio')
            ->with('3550308')
            ->willReturn($response);

        $result = $this->service->consultarParametrosConvenio('3550308');

        $this->assertInstanceOf(\Nfse\Http\Dto\ResultadoConsultaConfiguracoesConvenioResponse::class, $result);
        $this->assertEquals('Sucesso', $result->mensagem);
    }

    public function test_consultar_aliquota()
    {
        $aliq = new \Nfse\Http\Dto\AliquotaDto();
        $aliq->aliquota = 5.0;

        $response = new \Nfse\Http\Dto\ResultadoConsultaAliquotasResponse();
        $response->mensagem = 'Sucesso';
        $response->aliquotas = ['01.01.00.001' => [$aliq]];

        $this->adnClientMock->expects($this->once())
            ->method('consultarAliquota')
            ->with('3550308', '01.01.00.001', '2025-01-01T12:00:00')
            ->willReturn($response);

        $result = $this->service->consultarAliquota('3550308', '01.01.00.001', '2025-01-01T12:00:00');

        $this->assertInstanceOf(\Nfse\Http\Dto\ResultadoConsultaAliquotasResponse::class, $result);
        $this->assertEquals('Sucesso', $result->mensagem);
    }

    public function test_registrar_evento()
    {
        $response = new \Nfse\Http\Dto\RegistroEventoResponse();
        $response->tipoAmbiente = 2;
        $response->versaoAplicativo = '1.0';
        $response->dataHoraProcessamento = '2023-10-27T10:00:00';

        $this->sefinClientMock->expects($this->once())
            ->method('registrarEvento')
            ->with('CHAVE123', 'payload')
            ->willReturn($response);

        $result = $this->service->registrarEvento('CHAVE123', 'payload');

        $this->assertEquals($response, $result);
    }

    public function test_consultar_evento()
    {
        $response = new \Nfse\Http\Dto\RegistroEventoResponse();
        $response->tipoAmbiente = 2;
        $response->versaoAplicativo = '1.0';
        $response->dataHoraProcessamento = '2023-10-27T10:00:00';

        $this->sefinClientMock->expects($this->once())
            ->method('consultarEvento')
            ->with('CHAVE123', 101101, 1)
            ->willReturn($response);

        $result = $this->service->consultarEvento('CHAVE123', 101101, 1);

        $this->assertEquals($response, $result);
    }

    public function test_listar_eventos()
    {
        $this->sefinClientMock->expects($this->once())
            ->method('listarEventos')
            ->with('CHAVE123')
            ->willReturn([]);

        $result = $this->service->listarEventos('CHAVE123');

        $this->assertEquals([], $result);
    }

    public function test_listar_eventos_por_tipo()
    {
        $this->sefinClientMock->expects($this->once())
            ->method('listarEventosPorTipo')
            ->with('CHAVE123', 101101)
            ->willReturn([]);

        $result = $this->service->listarEventos('CHAVE123', 101101);

        $this->assertEquals([], $result);
    }

    public function test_consultar_eventos_adn()
    {
        $this->adnClientMock->expects($this->once())
            ->method('consultarEventosContribuinte')
            ->with('CHAVE123')
            ->willReturn([]);

        $result = $this->service->consultarEventos('CHAVE123');

        $this->assertEquals([], $result);
    }

    public function test_consultar_historico_aliquotas()
    {
        $response = new \Nfse\Http\Dto\ResultadoConsultaAliquotasResponse();
        $response->mensagem = 'Sucesso';
        $response->aliquotas = [];

        $this->adnClientMock->expects($this->once())
            ->method('consultarHistoricoAliquotas')
            ->with('3550308', '01.01.00.001')
            ->willReturn($response);

        $result = $this->service->consultarHistoricoAliquotas('3550308', '01.01.00.001');

        $this->assertEquals($response, $result);
    }

    public function test_consultar_beneficio()
    {
        $this->adnClientMock->expects($this->once())
            ->method('consultarBeneficio')
            ->with('3550308', 'BENEF123', '2025-01')
            ->willReturn([]);

        $result = $this->service->consultarBeneficio('3550308', 'BENEF123', '2025-01');

        $this->assertEquals([], $result);
    }

    public function test_consultar_regimes_especiais()
    {
        $this->adnClientMock->expects($this->once())
            ->method('consultarRegimesEspeciais')
            ->with('3550308', '01.01.00.001', '2025-01')
            ->willReturn([]);

        $result = $this->service->consultarRegimesEspeciais('3550308', '01.01.00.001', '2025-01');

        $this->assertEquals([], $result);
    }

    public function test_consultar_retencoes()
    {
        $this->adnClientMock->expects($this->once())
            ->method('consultarRetencoes')
            ->with('3550308', '2025-01')
            ->willReturn([]);

        $result = $this->service->consultarRetencoes('3550308', '2025-01');

        $this->assertEquals([], $result);
    }

    public function test_emitir_nfse_com_erros()
    {
        $idDps = 'DPS123';
        $dpsData = new DPSData();
        $dpsData->versao = '1.00';
        $dpsData->infDPS = new InfDPSData();
        $dpsData->infDPS->id = $idDps;
        // ... fill structure enough for builder ...

        $err = new \Nfse\Http\Dto\MensagemProcessamentoDto();
        $err->codigo = '1';
        $err->descricao = 'Erro teste';

        $responseDto = new EmissaoNfseResponse();
        $responseDto->tipoAmbiente = 2;
        $responseDto->versaoAplicativo = '1.0';
        $responseDto->dataHoraProcessamento = '2023-10-27T10:00:00';
        $responseDto->erros = [$err];

        $this->sefinClientMock->expects($this->once())
            ->method('emitirNfse')
            ->willReturn($responseDto);

        $this->expectException(\Nfse\Http\Exceptions\NfseApiException::class);
        $this->expectExceptionMessage('Erro na emissão');

        $this->service->emitir($dpsData);
    }

    public function test_emitir_nfse_sem_xml()
    {
        $idDps = 'DPS123';
        $dpsData = new DPSData();
        $dpsData->versao = '1.00';
        $dpsData->infDPS = new InfDPSData();
        $dpsData->infDPS->id = $idDps;

        $responseDto = new EmissaoNfseResponse();
        $responseDto->tipoAmbiente = 2;
        $responseDto->versaoAplicativo = '1.0';
        $responseDto->dataHoraProcessamento = '2023-10-27T10:00:00';

        $this->sefinClientMock->expects($this->once())
            ->method('emitirNfse')
            ->willReturn($responseDto);

        $this->expectException(\Nfse\Http\Exceptions\NfseApiException::class);
        $this->expectExceptionMessage('Resposta sem XML da NFS-e');

        $this->service->emitir($dpsData);
    }

    public function test_consultar_nfse_not_found()
    {
        $this->sefinClientMock->expects($this->once())
            ->method('consultarNfse')
            ->willThrowException(\Nfse\Http\Exceptions\NfseApiException::requestError('Not Found', 404));

        $result = $this->service->consultar('CHAVE123');

        $this->assertNull($result);
    }

    public function test_consultar_nfse_sem_xml()
    {
        $responseDto = new ConsultaNfseResponse();
        $responseDto->tipoAmbiente = 2;
        $responseDto->versaoAplicativo = '1.0';
        $responseDto->dataHoraProcessamento = '2023-10-27T10:00:00';
        $responseDto->chaveAcesso = 'CHAVE123';

        $this->sefinClientMock->expects($this->once())
            ->method('consultarNfse')
            ->willReturn($responseDto);

        $result = $this->service->consultar('CHAVE123');

        $this->assertNull($result);
    }
}
