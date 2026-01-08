<?php

namespace Nfse\Xml;

use DOMDocument;
use DOMElement;
use Nfse\Dto\Nfse\EmitenteData;
use Nfse\Dto\Nfse\EnderecoEmitenteData;
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
        $this->appendElement($valores, 'vBC', $data->baseCalculo !== null ? number_format($data->baseCalculo, 2, '.', '') : null);
        $this->appendElement($valores, 'pAliqAplic', $data->aliquotaAplicada !== null ? number_format($data->aliquotaAplicada, 2, '.', '') : null);
        $this->appendElement($valores, 'vISSQN', $data->valorIssqn !== null ? number_format($data->valorIssqn, 2, '.', '') : null);
        $this->appendElement($valores, 'vTotalRet', $data->valorTotalRetido !== null ? number_format($data->valorTotalRetido, 2, '.', '') : null);
        $this->appendElement($valores, 'vLiq', $data->valorLiquido !== null ? number_format($data->valorLiquido, 2, '.', '') : null);
        $parent->appendChild($valores);
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
