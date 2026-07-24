<?php

namespace Nfse\Tests\Unit\Xml;

use Nfse\Xml\NfseXmlBuilder;
use Nfse\Xml\NfseXmlParser;

function nfseXmlComIbscbs(): string
{
    return <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<NFSe xmlns="http://www.sped.fazenda.gov.br/nfse" versao="1.01">
  <infNFSe Id="NFS12345678901234567890123456789012345678901234567890">
    <xLocEmi>Sao Paulo</xLocEmi>
    <xLocPrestacao>Sao Paulo</xLocPrestacao>
    <nNFSe>1001</nNFSe>
    <cLocIncid>3550308</cLocIncid>
    <xLocIncid>Sao Paulo</xLocIncid>
    <xTribNac>Analise de sistemas</xTribNac>
    <verAplic>1.0</verAplic>
    <ambGer>1</ambGer>
    <tpEmis>1</tpEmis>
    <procEmi>1</procEmi>
    <cStat>100</cStat>
    <dhProc>2026-03-10T10:00:00-03:00</dhProc>
    <nDFSe>500</nDFSe>
    <valores>
      <vBC>1000.00</vBC>
      <pAliqAplic>5.00</pAliqAplic>
      <vISSQN>50.00</vISSQN>
      <vLiq>950.00</vLiq>
    </valores>
    <IBSCBS>
      <cLocalidadeIncid>3550308</cLocalidadeIncid>
      <xLocalidadeIncid>Sao Paulo</xLocalidadeIncid>
      <valores>
        <vBC>950.00</vBC>
        <vCalcReeRepRes>50.00</vCalcReeRepRes>
        <uf>
          <pIBSUF>0.10</pIBSUF>
          <pRedAliqUF>30.00</pRedAliqUF>
          <pAliqEfetUF>0.07</pAliqEfetUF>
        </uf>
        <mun>
          <pIBSMun>0.05</pIBSMun>
          <pAliqEfetMun>0.05</pAliqEfetMun>
        </mun>
        <fed>
          <pCBS>0.90</pCBS>
          <pAliqEfetCBS>0.90</pAliqEfetCBS>
        </fed>
      </valores>
      <totCIBS>
        <vTotNF>950.00</vTotNF>
        <gIBS>
          <vIBSTot>1.14</vIBSTot>
          <gIBSUFTot>
            <vDifUF>0.07</vDifUF>
            <vIBSUF>0.67</vIBSUF>
          </gIBSUFTot>
          <gIBSMunTot>
            <vIBSMun>0.47</vIBSMun>
          </gIBSMunTot>
        </gIBS>
        <gCBS>
          <vCBS>8.55</vCBS>
        </gCBS>
      </totCIBS>
    </IBSCBS>
  </infNFSe>
</NFSe>
XML;
}

it('parses the ibscbs group calculated by the national system', function () {
    $nfse = (new NfseXmlParser)->parse(nfseXmlComIbscbs());

    $ibscbs = $nfse->infNfse->ibscbs;

    expect($ibscbs)->not()->toBeNull()
        ->and($ibscbs->codigoLocalidadeIncidencia)->toBe('3550308')
        ->and($ibscbs->nomeLocalidadeIncidencia)->toBe('Sao Paulo')
        ->and($ibscbs->baseCalculo)->toBe(950.00)
        ->and($ibscbs->valorCalculadoReembolso)->toBe(50.00)
        ->and($ibscbs->aliquotaIbsUf)->toBe(0.10)
        ->and($ibscbs->percentualReducaoAliquotaUf)->toBe(30.00)
        ->and($ibscbs->aliquotaEfetivaUf)->toBe(0.07)
        ->and($ibscbs->aliquotaCbs)->toBe(0.90)
        ->and($ibscbs->valorTotalNota)->toBe(950.00)
        ->and($ibscbs->valorTotalIbs)->toBe(1.14)
        ->and($ibscbs->valorDiferimentoUf)->toBe(0.07)
        ->and($ibscbs->valorIbsUf)->toBe(0.67)
        ->and($ibscbs->valorIbsMunicipal)->toBe(0.47)
        ->and($ibscbs->valorCbs)->toBe(8.55)
        ->and($ibscbs->percentualRedutor)->toBeNull()
        ->and($ibscbs->valorCreditoPresumidoIbs)->toBeNull();
});

it('serializes the ibscbs group back after the valores group', function () {
    $nfse = (new NfseXmlParser)->parse(nfseXmlComIbscbs());

    $xml = (new NfseXmlBuilder)->build($nfse);

    expect($xml)->toContain('<cLocalidadeIncid>3550308</cLocalidadeIncid>')
        ->and($xml)->toContain('<uf><pIBSUF>0.10</pIBSUF><pRedAliqUF>30.00</pRedAliqUF><pAliqEfetUF>0.07</pAliqEfetUF></uf>')
        ->and($xml)->toContain('<mun><pIBSMun>0.05</pIBSMun><pAliqEfetMun>0.05</pAliqEfetMun></mun>')
        ->and($xml)->toContain('<gCBS><vCBS>8.55</vCBS></gCBS>')
        ->and($xml)->not()->toContain('<gTribRegular>')
        ->and($xml)->not()->toContain('<gTribCompraGov>')
        ->and(strpos($xml, '<vLiq>950.00</vLiq>'))->toBeLessThan(strpos($xml, '<IBSCBS>'));
});

it('keeps the ibscbs group null when the nfse does not carry it', function () {
    $xml = str_replace('<IBSCBS>', '<naoIBSCBS>', nfseXmlComIbscbs());
    $xml = str_replace('</IBSCBS>', '</naoIBSCBS>', $xml);

    expect((new NfseXmlParser)->parse($xml)->infNfse->ibscbs)->toBeNull();
});
