<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Dto\Nfse\NfseData;
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
    $infNfse = $nfse->infNfse;
    expect($infNfse->id)->toBe('NFS123456');
    expect($infNfse->numeroNfse)->toBe('100');
    expect($infNfse->codigoVerificacao)->toBeNull(); // Não presente no XML
    expect($infNfse->dataProcessamento)->toBe('2023-01-01T12:00:00');
    expect($infNfse->ambienteGerador)->toBe(\Nfse\Enums\AmbienteGerador::SefinNacional);
    expect($infNfse->versaoAplicativo)->toBe('1.0');
    expect($infNfse->processoEmissao)->toBe(\Nfse\Enums\ProcessoEmissao::WebService);
    expect($infNfse->localEmissao)->toBe('VARZEA ALEGRE');
    expect($infNfse->localPrestacao)->toBe('VARZEA ALEGRE');
    expect($infNfse->codigoLocalIncidencia)->toBe('2314003');
    expect($infNfse->nomeLocalIncidencia)->toBe('VARZEA ALEGRE');
    expect($infNfse->descricaoTributacaoNacional)->toBe('Enfermagem...');
    expect($infNfse->descricaoTributacaoMunicipal)->toBe('04.06 - Enfermagem...');
    expect($infNfse->codigoStatus)->toBe(\Nfse\Enums\CodigoStatus::NfseGerada);
    expect($infNfse->numeroDfse)->toBe('987654321');

    // Validar EmitenteData
    $emitente = $infNfse->emitente;
    expect($emitente->cnpj)->toBe('12345678000199');
    expect($emitente->nome)->toBe('Prefeitura Municipal');
    expect($emitente->telefone)->toBe('1112345678');
    expect($emitente->email)->toBe('contato@prefeitura.sp.gov.br');

    // Validar EnderecoEmitenteData
    $enderecoEmitente = $emitente->endereco;
    expect($enderecoEmitente->logradouro)->toBe('Praça da Sé');
    expect($enderecoEmitente->numero)->toBe('1');
    expect($enderecoEmitente->bairro)->toBe('Centro');
    expect($enderecoEmitente->codigoMunicipio)->toBe('3550308');
    expect($enderecoEmitente->uf)->toBe('SP');
    expect($enderecoEmitente->cep)->toBe('01001000');

    // Validar ValoresNfseData
    $valoresNfse = $infNfse->valores;
    expect($valoresNfse->baseCalculo)->toBe(1850.00);
    expect($valoresNfse->aliquotaAplicada)->toBe(5.00);
    expect($valoresNfse->valorIssqn)->toBe(92.50);
    expect($valoresNfse->valorLiquido)->toBe(1757.50);

    // Validar DpsData e InfDpsData
    $dps = $infNfse->dps;
    expect($dps->versao)->toBe('1.00');

    $infDps = $dps->infDps;
    expect($infDps->id)->toBe('DPS123');
    expect($infDps->tipoAmbiente)->toBe(\Nfse\Enums\TipoAmbiente::Homologacao);
    expect($infDps->dataEmissao)->toBe('2023-01-01');
    expect($infDps->serie)->toBe('1');
    expect($infDps->numeroDps)->toBe('100');
    expect($infDps->dataCompetencia)->toBe('2023-01-01');
    expect($infDps->tipoEmitente)->toBe(\Nfse\Enums\EmitenteDPS::Prestador);

    // Validar PrestadorData
    $prestador = $infDps->prestador;
    expect($prestador->cnpj)->toBe('12345678000199');
    expect($prestador->nome)->toBe('Prestador Teste');

    // Validar TomadorData
    $tomador = $infDps->tomador;
    expect($tomador->cpf)->toBe('12345678901');
    expect($tomador->nome)->toBe('Tomador Teste');

    // Validar ServicoData
    $servico = $infDps->servico;
    expect($servico->codigoServico->codigoTributacaoNacional)->toBe('010701');
    expect($servico->codigoServico->descricaoServico)->toBe('Descricao do Servico');

    // Validar ValoresData
    $valores = $infDps->valores;
    expect($valores->valorServicoPrestado->valorServico)->toBe(1000.00);
});
