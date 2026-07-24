<?php

namespace Nfse\Xml;

use DOMDocument;
use DOMElement;
use Nfse\Dto\Nfse\EmitenteData;
use Nfse\Dto\Nfse\EnderecoEmitenteData;
use Nfse\Dto\Nfse\IbscbsNfseData;
use Nfse\Dto\Nfse\InfNfseData;
use Nfse\Dto\Nfse\NfseData;
use Nfse\Dto\Nfse\ValoresNfseData;

class NfseXmlBuilder
{
    private DOMDocument $dom;

    private DpsXmlBuilder $dpsBuilder;

    public function __construct()
    {
        $this->dpsBuilder = new DpsXmlBuilder;
    }

    public function build(NfseData $nfse): string
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = false;

        $root = $this->dom->createElementNS('http://www.sped.fazenda.gov.br/nfse', 'NFSe');
        $root->setAttribute('versao', (string) $nfse->versao);
        $this->dom->appendChild($root);

        $infNfse = $this->dom->createElement('infNFSe');
        $infNfse->setAttribute('Id', (string) $nfse->infNfse->id);
        $infNfse->setAttribute('versao', (string) $nfse->versao);
        $root->appendChild($infNfse);

        $this->buildInfNfse($infNfse, $nfse->infNfse);

        $xml = $this->dom->saveXML();

        return str_replace(["\n", "\r", "\t"], '', $xml);
    }

    private function buildInfNfse(DOMElement $parent, InfNfseData $data): void
    {
        $this->appendElement($parent, 'xLocEmi', $data->localEmissao);
        $this->appendElement($parent, 'xLocPrestacao', $data->localPrestacao);
        $this->appendElement($parent, 'nNFSe', $data->numeroNfse);
        $this->appendElement($parent, 'cLocIncid', $data->codigoLocalIncidencia);
        $this->appendElement($parent, 'xLocIncid', $data->nomeLocalIncidencia);
        $this->appendElement($parent, 'xTribNac', $data->descricaoTributacaoNacional);
        $this->appendElement($parent, 'xTribMun', $data->descricaoTributacaoMunicipal);
        $this->appendElement($parent, 'xNBS', $data->descricaoNbs);
        $this->appendElement($parent, 'verAplic', $data->versaoAplicativo);
        $this->appendElement($parent, 'ambGer', $data->ambienteGerador);
        $this->appendElement($parent, 'tpEmis', $data->tipoEmissao);
        $this->appendElement($parent, 'procEmi', $data->processoEmissao);
        $this->appendElement($parent, 'cStat', $data->codigoStatus);
        $this->appendElement($parent, 'dhProc', $data->dataProcessamento);
        $this->appendElement($parent, 'nDFSe', $data->numeroDfse);
        $this->appendElement($parent, 'cVerif', $data->codigoVerificacao);

        if ($data->emitente) {
            $this->buildEmitente($parent, $data->emitente);
        }

        if ($data->valores) {
            $this->buildValores($parent, $data->valores);
        }

        if ($data->ibscbs) {
            $this->buildIbscbs($parent, $data->ibscbs);
        }

        if ($data->dps) {
            // The DpsXmlBuilder creates a full XML, we need to import the 'DPS' element
            $dpsXml = $this->dpsBuilder->build($data->dps);
            $tempDom = new DOMDocument;
            $tempDom->loadXML($dpsXml);
            $dpsNode = $tempDom->documentElement;
            if ($dpsNode) {
                $importedNode = $this->dom->importNode($dpsNode, true);
                $parent->appendChild($importedNode);
            }
        }
    }

    private function buildEmitente(DOMElement $parent, EmitenteData $data): void
    {
        $emit = $this->dom->createElement('emit');
        $this->appendElement($emit, 'CNPJ', $data->cnpj);
        $this->appendElement($emit, 'CPF', $data->cpf);
        $this->appendElement($emit, 'IM', $data->inscricaoMunicipal);
        $this->appendElement($emit, 'xNome', $data->nome);
        $this->appendElement($emit, 'xFant', $data->nomeFantasia);

        if ($data->endereco) {
            $this->buildEndereco($emit, $data->endereco);
        }

        $this->appendElement($emit, 'fone', $data->telefone);
        $this->appendElement($emit, 'email', $data->email);
        $parent->appendChild($emit);
    }

    private function buildEndereco(DOMElement $parent, EnderecoEmitenteData $data): void
    {
        $enderNac = $this->dom->createElement('enderNac');
        $this->appendElement($enderNac, 'xLgr', $data->logradouro);
        $this->appendElement($enderNac, 'nro', $data->numero);
        $this->appendElement($enderNac, 'xCpl', $data->complemento);
        $this->appendElement($enderNac, 'xBairro', $data->bairro);
        $this->appendElement($enderNac, 'cMun', $data->codigoMunicipio);
        $this->appendElement($enderNac, 'UF', $data->uf);
        $this->appendElement($enderNac, 'CEP', $data->cep);
        $parent->appendChild($enderNac);
    }

    private function buildValores(DOMElement $parent, ValoresNfseData $data): void
    {
        $valores = $this->dom->createElement('valores');
        $this->appendElement($valores, 'vBC', $this->formatValue($data->baseCalculo));
        $this->appendElement($valores, 'pAliqAplic', $this->formatValue($data->aliquotaAplicada));
        $this->appendElement($valores, 'vISSQN', $this->formatValue($data->valorIssqn));
        $this->appendElement($valores, 'vTotalRet', $this->formatValue($data->valorTotalRetido));
        $this->appendElement($valores, 'vLiq', $this->formatValue($data->valorLiquido));
        $parent->appendChild($valores);
    }

    private function buildIbscbs(DOMElement $parent, IbscbsNfseData $data): void
    {
        $ibscbs = $this->dom->createElement('IBSCBS');
        $this->appendElement($ibscbs, 'cLocalidadeIncid', $data->codigoLocalidadeIncidencia);
        $this->appendElement($ibscbs, 'xLocalidadeIncid', $data->nomeLocalidadeIncidencia);
        $this->appendElement($ibscbs, 'pRedutor', $this->formatValue($data->percentualRedutor));

        $valores = $this->dom->createElement('valores');
        $this->appendElement($valores, 'vBC', $this->formatValue($data->baseCalculo));
        $this->appendElement($valores, 'vCalcReeRepRes', $this->formatValue($data->valorCalculadoReembolso));

        $uf = $this->dom->createElement('uf');
        $this->appendElement($uf, 'pIBSUF', $this->formatValue($data->aliquotaIbsUf));
        $this->appendElement($uf, 'pRedAliqUF', $this->formatValue($data->percentualReducaoAliquotaUf));
        $this->appendElement($uf, 'pAliqEfetUF', $this->formatValue($data->aliquotaEfetivaUf));
        $valores->appendChild($uf);

        $mun = $this->dom->createElement('mun');
        $this->appendElement($mun, 'pIBSMun', $this->formatValue($data->aliquotaIbsMunicipal));
        $this->appendElement($mun, 'pRedAliqMun', $this->formatValue($data->percentualReducaoAliquotaMunicipal));
        $this->appendElement($mun, 'pAliqEfetMun', $this->formatValue($data->aliquotaEfetivaMunicipal));
        $valores->appendChild($mun);

        $fed = $this->dom->createElement('fed');
        $this->appendElement($fed, 'pCBS', $this->formatValue($data->aliquotaCbs));
        $this->appendElement($fed, 'pRedAliqCBS', $this->formatValue($data->percentualReducaoAliquotaCbs));
        $this->appendElement($fed, 'pAliqEfetCBS', $this->formatValue($data->aliquotaEfetivaCbs));
        $valores->appendChild($fed);

        $ibscbs->appendChild($valores);

        $totCIBS = $this->dom->createElement('totCIBS');
        $this->appendElement($totCIBS, 'vTotNF', $this->formatValue($data->valorTotalNota));

        $gIBS = $this->dom->createElement('gIBS');
        $this->appendElement($gIBS, 'vIBSTot', $this->formatValue($data->valorTotalIbs));

        if ($data->valorCreditoPresumidoIbs !== null) {
            $gIBSCredPres = $this->dom->createElement('gIBSCredPres');
            $this->appendElement($gIBSCredPres, 'pCredPresIBS', $this->formatValue($data->aliquotaCreditoPresumidoIbs));
            $this->appendElement($gIBSCredPres, 'vCredPresIBS', $this->formatValue($data->valorCreditoPresumidoIbs));
            $gIBS->appendChild($gIBSCredPres);
        }

        $gIBSUFTot = $this->dom->createElement('gIBSUFTot');
        $this->appendElement($gIBSUFTot, 'vDifUF', $this->formatValue($data->valorDiferimentoUf));
        $this->appendElement($gIBSUFTot, 'vIBSUF', $this->formatValue($data->valorIbsUf));
        $gIBS->appendChild($gIBSUFTot);

        $gIBSMunTot = $this->dom->createElement('gIBSMunTot');
        $this->appendElement($gIBSMunTot, 'vDifMun', $this->formatValue($data->valorDiferimentoMunicipal));
        $this->appendElement($gIBSMunTot, 'vIBSMun', $this->formatValue($data->valorIbsMunicipal));
        $gIBS->appendChild($gIBSMunTot);

        $totCIBS->appendChild($gIBS);

        $gCBS = $this->dom->createElement('gCBS');

        if ($data->valorCreditoPresumidoCbs !== null) {
            $gCBSCredPres = $this->dom->createElement('gCBSCredPres');
            $this->appendElement($gCBSCredPres, 'pCredPresCBS', $this->formatValue($data->aliquotaCreditoPresumidoCbs));
            $this->appendElement($gCBSCredPres, 'vCredPresCBS', $this->formatValue($data->valorCreditoPresumidoCbs));
            $gCBS->appendChild($gCBSCredPres);
        }

        $this->appendElement($gCBS, 'vDifCBS', $this->formatValue($data->valorDiferimentoCbs));
        $this->appendElement($gCBS, 'vCBS', $this->formatValue($data->valorCbs));
        $totCIBS->appendChild($gCBS);

        if ($data->valorTributacaoRegularCbs !== null) {
            $gTribRegular = $this->dom->createElement('gTribRegular');
            $this->appendElement($gTribRegular, 'pAliqEfeRegIBSUF', $this->formatValue($data->aliquotaEfetivaRegularIbsUf));
            $this->appendElement($gTribRegular, 'vTribRegIBSUF', $this->formatValue($data->valorTributacaoRegularIbsUf));
            $this->appendElement($gTribRegular, 'pAliqEfeRegIBSMun', $this->formatValue($data->aliquotaEfetivaRegularIbsMunicipal));
            $this->appendElement($gTribRegular, 'vTribRegIBSMun', $this->formatValue($data->valorTributacaoRegularIbsMunicipal));
            $this->appendElement($gTribRegular, 'pAliqEfeRegCBS', $this->formatValue($data->aliquotaEfetivaRegularCbs));
            $this->appendElement($gTribRegular, 'vTribRegCBS', $this->formatValue($data->valorTributacaoRegularCbs));
            $totCIBS->appendChild($gTribRegular);
        }

        if ($data->valorCompraGovCbs !== null) {
            $gTribCompraGov = $this->dom->createElement('gTribCompraGov');
            $this->appendElement($gTribCompraGov, 'pIBSUF', $this->formatValue($data->aliquotaCompraGovIbsUf));
            $this->appendElement($gTribCompraGov, 'vIBSUF', $this->formatValue($data->valorCompraGovIbsUf));
            $this->appendElement($gTribCompraGov, 'pIBSMun', $this->formatValue($data->aliquotaCompraGovIbsMunicipal));
            $this->appendElement($gTribCompraGov, 'vIBSMun', $this->formatValue($data->valorCompraGovIbsMunicipal));
            $this->appendElement($gTribCompraGov, 'pCBS', $this->formatValue($data->aliquotaCompraGovCbs));
            $this->appendElement($gTribCompraGov, 'vCBS', $this->formatValue($data->valorCompraGovCbs));
            $totCIBS->appendChild($gTribCompraGov);
        }

        $ibscbs->appendChild($totCIBS);
        $parent->appendChild($ibscbs);
    }

    private function formatValue(?float $value): ?string
    {
        return $value !== null ? number_format($value, 2, '.', '') : null;
    }

    private function appendElement(DOMElement $parent, string $name, mixed $value): void
    {
        if ($value instanceof \BackedEnum) {
            $value = $value->value;
        }

        if ($value !== null && $value !== '') {
            $element = $this->dom->createElement($name);
            $element->appendChild($this->dom->createTextNode((string) $value));
            $parent->appendChild($element);
        }
    }
}
