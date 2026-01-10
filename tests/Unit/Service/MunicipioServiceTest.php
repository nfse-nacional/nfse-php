<?php

namespace Nfse\Tests\Unit\Service;

use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Client\CncClient;
use Nfse\Http\NfseContext;
use Nfse\Service\MunicipioService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class MunicipioServiceTest extends TestCase
{
    private $context;

    private $service;

    private $adnClientMock;

    private $cncClientMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->context = new NfseContext(
            TipoAmbiente::Homologacao,
            '/tmp/cert.pfx',
            'password'
        );

        $this->adnClientMock = $this->createMock(AdnClient::class);
        $this->cncClientMock = $this->createMock(CncClient::class);

        $this->service = new MunicipioService($this->context);

        $reflection = new ReflectionClass($this->service);

        $adnProperty = $reflection->getProperty('adnClient');
        $adnProperty->setValue($this->service, $this->adnClientMock);

        $cncProperty = $reflection->getProperty('cncClient');
        $cncProperty->setValue($this->service, $this->cncClientMock);
    }

    public function test_baixar_dfe_municipio()
    {
        $this->adnClientMock->expects($this->once())
            ->method('baixarDfeMunicipio')
            ->with(100)
            ->willReturn((function () {
                $response = new \Nfse\Http\Dto\DistribuicaoDfeResponse();
                $response->ultimoNsu = 100;
                $response->listaNsu = [];
                return $response;
            })());

        $result = $this->service->baixarDfe(100);

        $this->assertInstanceOf(\Nfse\Http\Dto\DistribuicaoDfeResponse::class, $result);
    }

    public function test_enviar_lote()
    {
        $xmlZipB64 = 'base64data';
        $this->adnClientMock->expects($this->once())
            ->method('enviarLote')
            ->with($xmlZipB64)
            ->willReturn(['protocolo' => '123']);

        $result = $this->service->enviarLote($xmlZipB64);

        $this->assertEquals(['protocolo' => '123'], $result);
    }

    public function test_consultar_contribuinte()
    {
        $this->cncClientMock->expects($this->once())
            ->method('consultarContribuinte')
            ->with('12345678000199')
            ->willReturn(['nome' => 'Empresa Teste']);

        $result = $this->service->consultarContribuinte('12345678000199');

        $this->assertEquals(['nome' => 'Empresa Teste'], $result);
    }

    public function test_baixar_alteracoes_cadastro()
    {
        $this->cncClientMock->expects($this->once())
            ->method('baixarAlteracoesCadastro')
            ->with(100)
            ->willReturn(['alteracoes' => []]);

        $result = $this->service->baixarAlteracoesCadastro(100);

        $this->assertEquals(['alteracoes' => []], $result);
    }

    public function test_atualizar_contribuinte()
    {
        $dados = ['cnpj' => '12345678000199'];
        $this->cncClientMock->expects($this->once())
            ->method('atualizarContribuinte')
            ->with($dados)
            ->willReturn(['status' => 'sucesso']);

        $result = $this->service->atualizarContribuinte($dados);

        $this->assertEquals(['status' => 'sucesso'], $result);
    }

    public function test_consultar_parametros_convenio()
    {
        $response = new \Nfse\Http\Dto\ResultadoConsultaConfiguracoesConvenioResponse();
        $response->mensagem = 'Sucesso';
        $params = new \Nfse\Http\Dto\ParametrosConfiguracaoConvenioDto();
        $params->tipoConvenio = 1;
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
        $response = new \Nfse\Http\Dto\ResultadoConsultaAliquotasResponse();
        $response->mensagem = 'Sucesso';
        $aliquota = new \Nfse\Http\Dto\AliquotaDto();
        $aliquota->aliquota = 5.0;
        $response->aliquotas = ['01.01.00.001' => [$aliquota]];

        $this->adnClientMock->expects($this->once())
            ->method('consultarAliquota')
            ->with('3550308', '01.01.00.001', '2025-01-01T12:00:00')
            ->willReturn($response);

        $result = $this->service->consultarAliquota('3550308', '01.01.00.001', '2025-01-01T12:00:00');

        $this->assertInstanceOf(\Nfse\Http\Dto\ResultadoConsultaAliquotasResponse::class, $result);
        $this->assertEquals('Sucesso', $result->mensagem);
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
}
