<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\NFSeData;
use Nfse\Xml\NfseXmlParser;

it('parses XML and maps to DTO properties with full names', function () {
    $xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<NFSe xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.00">
  <infNFSe Id="NFS123456" versao="1.00">
    <xLocEmi>VARZEA ALEGRE</xLocEmi>
    <xLocPrestacao>VARZEA ALEGRE</xLocPrestacao>
    <nNFSe>100</nNFSe>
    <cLocIncid>2314003</cLocIncid>
    <xLocIncid>VARZEA ALEGRE</xLocIncid>
    <xTribNac>Enfermagem...</xTribNac>
    <xTribMun>04.06 - Enfermagem...</xTribMun>
    <verAplic>1.0</verAplic>
    <ambGer>2</ambGer>
    <tpEmis>1</tpEmis>
    <procEmi>1</procEmi>
    <cStat>100</cStat>
    <dhProc>2023-01-01T12:00:00</dhProc>
    <nDFSe>987654321</nDFSe>
    <emit>
      <CNPJ>12345678000199</CNPJ>
      <xNome>Prefeitura Municipal</xNome>
      <enderNac>
        <xLgr>Praça da Sé</xLgr>
        <nro>1</nro>
        <xBairro>Centro</xBairro>
        <cMun>3550308</cMun>
        <UF>SP</UF>
        <CEP>01001000</CEP>
      </enderNac>
      <fone>1112345678</fone>
      <email>contato@prefeitura.sp.gov.br</email>
    </emit>
    <valores>
      <vBC>1850.00</vBC>
      <pAliqAplic>5.00</pAliqAplic>
      <vISSQN>92.50</vISSQN>
      <vLiq>1757.50</vLiq>
    </valores>
    <DPS versao="1.00">
      <infDPS Id="DPS123">
        <tpAmb>2</tpAmb>
        <dhEmi>2023-01-01</dhEmi>
        <verAplic>1.0</verAplic>
        <serie>1</serie>
        <nDPS>100</nDPS>
        <dCompet>2023-01-01</dCompet>
        <tpEmit>1</tpEmit>
        <cLocEmi>1234567</cLocEmi>
        <prest>
            <CNPJ>12345678000199</CNPJ>
            <xNome>Prestador Teste</xNome>
        </prest>
        <toma>
            <CPF>12345678901</CPF>
            <xNome>Tomador Teste</xNome>
        </toma>
        <serv>
            <cServ>
                <cTribNac>010701</cTribNac>
                <xDescServ>Descricao do Servico</xDescServ>
            </cServ>
        </serv>
        <valores>
            <vServPrest>
                <vServ>1000.00</vServ>
            </vServPrest>
        </valores>
      </infDPS>
    </DPS>
  </infNFSe>
</NFSe>
XML;

    $parser = new NfseXmlParser;
    $nfse = $parser->parse($xml);

    expect($nfse)->toBeInstanceOf(NfseData::class);

    // Validar propriedades de nível superior (NfseData)
    expect($nfse->versao)->toBe('1.00');

    // Validar InfNfseData
    $infNfse = $nfse->infNFSe;
    expect($infNfse->id)->toBe('NFS123456');
    expect($infNfse->nNFSe)->toBe('100');
    // cVerif is likely not in XML provided for this test? XML says: <infNFSe ...> ... </infNFSe>. No cVerif tag?
    // Checking XML: line 12-40. cVerif not present. 
    // expect($infNfse->cVerif)->toBeNull(); 

    expect($infNfse->dhProc)->toBe('2023-01-01T12:00:00');
    expect($infNfse->ambGer)->toBe('2'); // String because DTO property is ?string
    expect($infNfse->verAplic)->toBe('1.0');
    expect($infNfse->procEmi)->toBe('1');
    expect($infNfse->xLocEmi)->toBe('VARZEA ALEGRE');
    expect($infNfse->xLocPrestacao)->toBe('VARZEA ALEGRE');
    expect($infNfse->cLocIncid)->toBe('2314003');
    expect($infNfse->xLocIncid)->toBe('VARZEA ALEGRE');
    expect($infNfse->xTribNac)->toBe('Enfermagem...');
    expect($infNfse->xTribMun)->toBe('04.06 - Enfermagem...');
    expect($infNfse->cStat)->toBe('100');
    expect($infNfse->nDFSe)->toBe('987654321');

    // Validar EmitenteData
    $emitente = $infNfse->emit;
    expect($emitente->CNPJ)->toBe('12345678000199');
    expect($emitente->xNome)->toBe('Prefeitura Municipal');
    expect($emitente->fone)->toBe('1112345678');
    expect($emitente->email)->toBe('contato@prefeitura.sp.gov.br');

    // Validar EnderecoEmitenteData
    $enderecoEmitente = $emitente->enderNac;
    expect($enderecoEmitente->xLgr)->toBe('Praça da Sé');
    expect($enderecoEmitente->nro)->toBe('1');
    expect($enderecoEmitente->xBairro)->toBe('Centro');
    expect($enderecoEmitente->cMun)->toBe('3550308');
    expect($enderecoEmitente->UF)->toBe('SP');
    expect($enderecoEmitente->CEP)->toBe('01001000');

    // Validar ValoresNfseData
    $valoresNfse = $infNfse->valores;
    // Values are strings in DTO? 
    // In generated DTOs everything is ?string.
    expect((float)$valoresNfse->vBC)->toBe(1850.00);
    expect((float)$valoresNfse->pAliqAplic)->toBe(5.00);
    expect((float)$valoresNfse->vISSQN)->toBe(92.50);
    expect((float)$valoresNfse->vLiq)->toBe(1757.50);

    // Validar DpsData e InfDpsData
    $dps = $infNfse->DPS;
    expect($dps->versao)->toBe('1.00');

    $infDps = $dps->infDPS;
    expect($infDps->id)->toBe('DPS123');
    expect($infDps->tpAmb)->toBe('2');
    expect($infDps->dhEmi)->toBe('2023-01-01');
    expect($infDps->serie)->toBe('1');
    expect($infDps->nDPS)->toBe('100');
    expect($infDps->dCompet)->toBe('2023-01-01');
    expect($infDps->tpEmit)->toBe('1');

    // Validar PrestadorData
    $prestador = $infDps->prest;
    expect($prestador->CNPJ)->toBe('12345678000199');
    expect($prestador->xNome)->toBe('Prestador Teste');

    // Validar TomadorData
    $tomador = $infDps->toma;
    expect($tomador->CPF)->toBe('12345678901');
    expect($tomador->xNome)->toBe('Tomador Teste');

    // Validar ServicoData
    $servico = $infDps->serv;
    expect($servico->cServ->cTribNac)->toBe('010701');
    expect($servico->cServ->xDescServ)->toBe('Descricao do Servico');

    // Validar ValoresData
    $valores = $infDps->valores;
    expect((float)$valores->vServPrest->vServ)->toBe(1000.00);
});
