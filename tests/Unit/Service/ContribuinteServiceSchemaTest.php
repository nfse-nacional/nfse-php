<?php

namespace Nfse\Tests\Unit\Service;

use Nfse\Dto\Http\EmissaoNfseResponse;
use Nfse\Dto\Nfse\DpsData;
use Nfse\Enums\TipoAmbiente;
use Nfse\Http\Client\AdnClient;
use Nfse\Http\Contracts\SefinNacionalInterface;
use Nfse\Http\NfseContext;
use Nfse\Service\ContribuinteService;
use Nfse\Signer\Certificate;
use Nfse\Signer\SignerInterface;
use Nfse\Support\IdGenerator;
use Nfse\Xml\SchemaDps;
use ReflectionClass;

class EmissorSchemaTeste extends ContribuinteService
{
    public string $xml = '';

    protected function createSigner(Certificate $certificate): SignerInterface
    {
        return new AssinadorQueGuardaXml($this);
    }
}

class AssinadorQueGuardaXml implements SignerInterface
{
    public function __construct(private EmissorSchemaTeste $emissor) {}

    public function sign(
        string $content,
        string $tagname,
        string $mark = 'Id',
        int $algorithm = OPENSSL_ALGO_SHA1,
        array $canonical = [true, false, null, null],
        string $rootname = '',
        array $options = []
    ): string {
        $this->emissor->xml = $content;

        return $content;
    }
}

function dpsEmitidaNoSchema(): DpsData
{
    return new DpsData([
        '@attributes' => ['versao' => '1.01'],
        'infDPS' => [
            '@attributes' => ['Id' => IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001')],
            'tpAmb' => 2,
            'dhEmi' => '2026-11-26T10:00:00-03:00',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '1001',
            'dCompet' => '2026-11-26',
            'tpEmit' => 1,
            'finNFSe' => '0',
            'cLocEmi' => '3550308',
            'prest' => ['CNPJ' => '12345678000199'],
            'toma' => ['xNome' => 'Tomador Exemplo'],
            'serv' => [
                'locPrest' => ['cLocPrestacao' => '3550308'],
                'cServ' => [
                    'cTribNac' => '010201',
                    'xDescServ' => 'Analise de sistemas',
                ],
            ],
            'valores' => [
                'vServPrest' => ['vServ' => 100.00],
            ],
            'IBSCBS' => [
                'cIndOp' => '100301',
                'indDest' => 0,
                'valores' => [
                    'trib' => [
                        'CST' => '000',
                        'cClassTrib' => '000001',
                    ],
                ],
            ],
        ],
    ]);
}

function xmlDaEmissao(TipoAmbiente|string $ambiente, SchemaDps|string|null $schema = null): string
{
    $servico = new EmissorSchemaTeste(new NfseContext(
        $ambiente,
        dirname(__DIR__, 2).'/fixtures/certs/test.pfx',
        '1234'
    ));

    $resposta = '<?xml version="1.0" encoding="UTF-8"?>
<NFSe xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.00">
  <infNFSe Id="NFS123456" versao="1.00">
    <nNFSe>100</nNFSe>
    <DPS versao="1.00">
        <infDPS Id="DPS123">
            <tpAmb>2</tpAmb>
            <dhEmi>2026-11-26T10:00:00-03:00</dhEmi>
            <verAplic>1.0</verAplic>
            <serie>1</serie>
            <nDPS>1</nDPS>
            <dCompet>2026-11-26</dCompet>
            <tpEmit>1</tpEmit>
            <cLocEmi>3550308</cLocEmi>
        </infDPS>
    </DPS>
  </infNFSe>
</NFSe>';

    $sefin = \Mockery::mock(SefinNacionalInterface::class);
    $sefin->shouldReceive('emitirNfse')->andReturn(new EmissaoNfseResponse([
        'tpAmb' => 2,
        'verAplic' => '1.0',
        'dhProc' => '2026-11-26T10:00:00-03:00',
        'idDPS' => 'DPS123',
        'chAcesso' => 'CHAVE123',
        'nfseXmlGZipB64' => base64_encode(gzencode($resposta)),
    ]));

    $reflexao = new ReflectionClass(ContribuinteService::class);
    $reflexao->getProperty('sefinClient')->setValue($servico, $sefin);
    $reflexao->getProperty('adnClient')->setValue($servico, \Mockery::mock(AdnClient::class));

    $servico->emitir(dpsEmitidaNoSchema(), $schema);

    return $servico->xml;
}

it('usa o schema do ambiente quando a versao nao e informada', function () {
    $homologacao = xmlDaEmissao(TipoAmbiente::Homologacao);
    $producao = xmlDaEmissao(TipoAmbiente::Producao);

    expect($homologacao)->toContain('</toma><indDest>0</indDest><serv>')
        ->and($homologacao)->not->toContain('<indDest>0</indDest><valores>')
        ->and($producao)->toContain('<IBSCBS><cIndOp>100301</cIndOp><indDest>0</indDest>')
        ->and($producao)->not->toContain('</toma><indDest>');
});

it('prevalece a versao informada sobre o ambiente', function () {
    $xml = xmlDaEmissao(TipoAmbiente::Homologacao, SchemaDps::Producao);

    expect($xml)->toContain('<IBSCBS><cIndOp>100301</cIndOp><indDest>0</indDest>')
        ->and($xml)->not->toContain('</toma><indDest>');
});
