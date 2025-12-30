<?php

namespace Nfse\Nfse\Xml;

use DOMDocument;
use DOMElement;
use Nfse\Nfse\Dto\DpsData;
use Nfse\Nfse\Dto\InfDpsData;
use Nfse\Nfse\Dto\PrestadorData;
use Nfse\Nfse\Dto\TomadorData;
use Nfse\Nfse\Dto\ServicoData;
use Nfse\Nfse\Dto\ValoresData;
use Nfse\Nfse\Dto\EnderecoData;

class DpsXmlBuilder
{
    private DOMDocument $dom;

    public function build(DpsData $dps): string
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = true;

        $root = $this->dom->createElementNS('http://www.sped.fazenda.gov.br/nfse', 'DPS');
        $this->dom->appendChild($root);

        $infDps = $this->dom->createElement('infDPS');
        $infDps->setAttribute('Id', $dps->infDps->id);
        $infDps->setAttribute('versao', $dps->versao);
        $root->appendChild($infDps);

        $this->buildInfDps($infDps, $dps->infDps);

        return $this->dom->saveXML();
    }

    private function buildInfDps(DOMElement $parent, InfDpsData $data): void
    {
        $this->appendElement($parent, 'tpAmb', (string)$data->tipoAmbiente);
        $this->appendElement($parent, 'dhEmi', $data->dataEmissao);
        $this->appendElement($parent, 'verAplic', $data->versaoAplicativo);
        $this->appendElement($parent, 'serie', $data->serie);
        $this->appendElement($parent, 'nDPS', $data->numeroDps);
        $this->appendElement($parent, 'dCompet', $data->dataCompetencia);
        $this->appendElement($parent, 'tpEmit', (string)$data->tipoEmitente);
        $this->appendElement($parent, 'cLocEmi', $data->codigoLocalEmissao);
        $this->appendElement($parent, 'cMotivoEmisTI', $data->motivoEmissaoTomadorIntermediario);
        $this->appendElement($parent, 'chNFSeRej', $data->chaveNfseRejeitada);

        if ($data->substituicao) {
            $subst = $this->dom->createElement('subst');
            $this->appendElement($subst, 'chSubstda', $data->substituicao->chaveSubstituida);
            $this->appendElement($subst, 'cMotivo', $data->substituicao->codigoMotivo);
            $this->appendElement($subst, 'xMotivo', $data->substituicao->descricaoMotivo);
            $parent->appendChild($subst);
        }

        if ($data->prestador) {
            $this->buildPrestador($parent, $data->prestador);
        }

        if ($data->tomador) {
            $this->buildTomador($parent, $data->tomador);
        }

        if ($data->intermediario) {
            $interm = $this->dom->createElement('interm');
            $this->appendElement($interm, 'CNPJ', $data->intermediario->cnpj);
            $this->appendElement($interm, 'CPF', $data->intermediario->cpf);
            $this->appendElement($interm, 'NIF', $data->intermediario->nif);
            $this->appendElement($interm, 'cNaoNIF', $data->intermediario->codigoNaoNif);
            $this->appendElement($interm, 'CAEPF', $data->intermediario->caepf);
            $this->appendElement($interm, 'IM', $data->intermediario->inscricaoMunicipal);
            $this->appendElement($interm, 'xNome', $data->intermediario->nome);
            
            if ($data->intermediario->endereco) {
                $this->buildEndereco($interm, $data->intermediario->endereco);
            }

            $this->appendElement($interm, 'fone', $data->intermediario->telefone);
            $this->appendElement($interm, 'email', $data->intermediario->email);
            $parent->appendChild($interm);
        }

        if ($data->servico) {
            $this->buildServico($parent, $data->servico);
        }

        if ($data->valores) {
            $this->buildValores($parent, $data->valores);
        }
    }

    private function buildPrestador(DOMElement $parent, PrestadorData $data): void
    {
        $prest = $this->dom->createElement('prest');
        $this->appendElement($prest, 'CNPJ', $data->cnpj);
        $this->appendElement($prest, 'CPF', $data->cpf);
        $this->appendElement($prest, 'NIF', $data->nif);
        $this->appendElement($prest, 'cNaoNIF', $data->codigoNaoNif);
        $this->appendElement($prest, 'CAEPF', $data->caepf);
        $this->appendElement($prest, 'IM', $data->inscricaoMunicipal);
        $this->appendElement($prest, 'xNome', $data->nome);
        
        if ($data->endereco) {
            $this->buildEndereco($prest, $data->endereco);
        }

        $this->appendElement($prest, 'fone', $data->telefone);
        $this->appendElement($prest, 'email', $data->email);

        if ($data->regimeTributario) {
            $regTrib = $this->dom->createElement('regTrib');
            $this->appendElement($regTrib, 'opSimpNac', (string)$data->regimeTributario->opcaoSimplesNacional);
            $this->appendElement($regTrib, 'regApTribSN', (string)$data->regimeTributario->regimeApuracaoTributariaSN);
            $this->appendElement($regTrib, 'regEspTrib', (string)$data->regimeTributario->regimeEspecialTributacao);
            $prest->appendChild($regTrib);
        }

        $parent->appendChild($prest);
    }

    private function buildTomador(DOMElement $parent, TomadorData $data): void
    {
        $toma = $this->dom->createElement('toma');
        $this->appendElement($toma, 'CNPJ', $data->cnpj);
        $this->appendElement($toma, 'CPF', $data->cpf);
        $this->appendElement($toma, 'NIF', $data->nif);
        $this->appendElement($toma, 'cNaoNIF', $data->codigoNaoNif);
        $this->appendElement($toma, 'CAEPF', $data->caepf);
        $this->appendElement($toma, 'IM', $data->inscricaoMunicipal);
        $this->appendElement($toma, 'xNome', $data->nome);

        if ($data->endereco) {
            $this->buildEndereco($toma, $data->endereco);
        }

        $this->appendElement($toma, 'fone', $data->telefone);
        $this->appendElement($toma, 'email', $data->email);
        $parent->appendChild($toma);
    }

    private function buildEndereco(DOMElement $parent, EnderecoData $data): void
    {
        $end = $this->dom->createElement('end');
        $this->appendElement($end, 'xLgr', $data->logradouro);
        $this->appendElement($end, 'nro', $data->numero);
        $this->appendElement($end, 'xCpl', $data->complemento);
        $this->appendElement($end, 'xBairro', $data->bairro);
        
        $endNac = $this->dom->createElement('endNac');
        $this->appendElement($endNac, 'cMun', $data->codigoMunicipio);
        $this->appendElement($endNac, 'CEP', $data->cep);
        $end->appendChild($endNac);

        $parent->appendChild($end);
    }

    private function buildServico(DOMElement $parent, ServicoData $data): void
    {
        $serv = $this->dom->createElement('serv');
        
        if ($data->localPrestacao) {
            $locPrest = $this->dom->createElement('locPrest');
            $this->appendElement($locPrest, 'cLocPrestacao', $data->localPrestacao->codigoLocalPrestacao);
            $this->appendElement($locPrest, 'cPaisPrestacao', $data->localPrestacao->codigoPaisPrestacao);
            $serv->appendChild($locPrest);
        }

        if ($data->codigoServico) {
            $cServ = $this->dom->createElement('cServ');
            $this->appendElement($cServ, 'cTribNac', $data->codigoServico->codigoTributacaoNacional);
            $this->appendElement($cServ, 'cTribMun', $data->codigoServico->codigoTributacaoMunicipal);
            $this->appendElement($cServ, 'xDescServ', $data->codigoServico->descricaoServico);
            $this->appendElement($cServ, 'cNBS', $data->codigoServico->codigoNbs);
            $this->appendElement($cServ, 'cIntContrib', $data->codigoServico->codigoInternoContribuinte);
            $serv->appendChild($cServ);
        }

        if ($data->comercioExterior) {
            $comExt = $this->dom->createElement('comExt');
            $this->appendElement($comExt, 'mdPrestacao', (string)$data->comercioExterior->modoPrestacao);
            $this->appendElement($comExt, 'vincPrest', (string)$data->comercioExterior->vinculoPrestacao);
            $this->appendElement($comExt, 'tpMoeda', $data->comercioExterior->tipoMoeda);
            $this->appendElement($comExt, 'vServMoeda', (string)$data->comercioExterior->valorServicoMoeda);
            $this->appendElement($comExt, 'mecAFComexP', $data->comercioExterior->mecanismoApoioComexPrestador);
            $this->appendElement($comExt, 'mecAFComexT', $data->comercioExterior->mecanismoApoioComexTomador);
            $this->appendElement($comExt, 'movTempBens', $data->comercioExterior->movimentacaoTemporariaBens);
            $this->appendElement($comExt, 'nDI', $data->comercioExterior->numeroDeclaracaoImportacao);
            $this->appendElement($comExt, 'nRE', $data->comercioExterior->numeroRegistroExportacao);
            $this->appendElement($comExt, 'mdic', $data->comercioExterior->mdic);
            $serv->appendChild($comExt);
        }

        if ($data->obra) {
            $obra = $this->dom->createElement('obra');
            $this->appendElement($obra, 'inscImobFisc', $data->obra->inscricaoImobiliariaFiscal);
            $this->appendElement($obra, 'cObra', $data->obra->codigoObra);
            if ($data->obra->endereco) {
                $this->buildEndereco($obra, $data->obra->endereco);
            }
            $serv->appendChild($obra);
        }

        if ($data->atividadeEvento) {
            $atvEvento = $this->dom->createElement('atvEvento');
            $this->appendElement($atvEvento, 'xNome', $data->atividadeEvento->nome);
            $this->appendElement($atvEvento, 'dtIni', $data->atividadeEvento->dataInicio);
            $this->appendElement($atvEvento, 'dtFim', $data->atividadeEvento->dataFim);
            $this->appendElement($atvEvento, 'idAtvEvt', $data->atividadeEvento->idAtividadeEvento);
            if ($data->atividadeEvento->endereco) {
                $this->buildEndereco($atvEvento, $data->atividadeEvento->endereco);
            }
            $serv->appendChild($atvEvento);
        }

        $this->appendElement($serv, 'infoComplem', $data->informacoesComplementares);
        $this->appendElement($serv, 'idDocTec', $data->idDocumentoTecnico);
        $this->appendElement($serv, 'docRef', $data->documentoReferencia);
        $this->appendElement($serv, 'xInfComp', $data->descricaoInformacoesComplementares);

        $parent->appendChild($serv);
    }

    private function buildValores(DOMElement $parent, ValoresData $data): void
    {
        $valores = $this->dom->createElement('valores');
        
        if ($data->valorServicoPrestado) {
            $vServPrest = $this->dom->createElement('vServPrest');
            $this->appendElement($vServPrest, 'vReceb', $data->valorServicoPrestado->valorRecebido !== null ? number_format($data->valorServicoPrestado->valorRecebido, 2, '.', '') : null);
            $this->appendElement($vServPrest, 'vServ', $data->valorServicoPrestado->valorServico !== null ? number_format($data->valorServicoPrestado->valorServico, 2, '.', '') : null);
            $valores->appendChild($vServPrest);
        }

        if ($data->desconto) {
            $vDescCondIncond = $this->dom->createElement('vDescCondIncond');
            $this->appendElement($vDescCondIncond, 'vDescIncond', $data->desconto->valorDescontoIncondicionado !== null ? number_format($data->desconto->valorDescontoIncondicionado, 2, '.', '') : null);
            $this->appendElement($vDescCondIncond, 'vDescCond', $data->desconto->valorDescontoCondicionado !== null ? number_format($data->desconto->valorDescontoCondicionado, 2, '.', '') : null);
            $valores->appendChild($vDescCondIncond);
        }

        if ($data->deducaoReducao) {
            $vDedRed = $this->dom->createElement('vDedRed');
            $this->appendElement($vDedRed, 'pDR', $data->deducaoReducao->percentualDeducaoReducao !== null ? number_format($data->deducaoReducao->percentualDeducaoReducao, 2, '.', '') : null);
            $this->appendElement($vDedRed, 'vDR', $data->deducaoReducao->valorDeducaoReducao !== null ? number_format($data->deducaoReducao->valorDeducaoReducao, 2, '.', '') : null);
            // TODO: Map 'documentos' array if needed
            $valores->appendChild($vDedRed);
        }

        if ($data->tributacao) {
            $trib = $this->dom->createElement('trib');
            
            $tribMun = $this->dom->createElement('tribMun');
            $this->appendElement($tribMun, 'tribISSQN', (string)$data->tributacao->tributacaoIssqn);
            $this->appendElement($tribMun, 'tpImunidade', (string)$data->tributacao->tipoImunidade);
            $this->appendElement($tribMun, 'tpRetISSQN', (string)$data->tributacao->tipoRetencaoIssqn);

            if ($data->tributacao->tipoSuspensao) {
                $exigSusp = $this->dom->createElement('exigSusp');
                $this->appendElement($exigSusp, 'tpSusp', (string)$data->tributacao->tipoSuspensao);
                $this->appendElement($exigSusp, 'nProcesso', $data->tributacao->numeroProcessoSuspensao);
                $tribMun->appendChild($exigSusp);
            }

            if ($data->tributacao->beneficioMunicipal) {
                $bm = $this->dom->createElement('BM');
                $this->appendElement($bm, 'pRedBCBM', $data->tributacao->beneficioMunicipal->percentualReducaoBcBm !== null ? number_format($data->tributacao->beneficioMunicipal->percentualReducaoBcBm, 2, '.', '') : null);
                $this->appendElement($bm, 'vRedBCBM', $data->tributacao->beneficioMunicipal->valorReducaoBcBm !== null ? number_format($data->tributacao->beneficioMunicipal->valorReducaoBcBm, 2, '.', '') : null);
                $tribMun->appendChild($bm);
            }

            $trib->appendChild($tribMun);

            if ($data->tributacao->cstPisCofins) {
                $tribFed = $this->dom->createElement('tribFed');
                $piscofins = $this->dom->createElement('piscofins');
                $this->appendElement($piscofins, 'CST', $data->tributacao->cstPisCofins);
                $tribFed->appendChild($piscofins);
                $trib->appendChild($tribFed);
            }

            if ($data->tributacao->percentualTotalTributosSN) {
                $totTrib = $this->dom->createElement('totTrib');
                $this->appendElement($totTrib, 'pTotTribSN', $data->tributacao->percentualTotalTributosSN !== null ? number_format($data->tributacao->percentualTotalTributosSN, 2, '.', '') : null);
                $trib->appendChild($totTrib);
            } elseif ($data->tributacao->indicadorTotalTributos !== null) {
                $totTrib = $this->dom->createElement('totTrib');
                $this->appendElement($totTrib, 'indTotTrib', (string)$data->tributacao->indicadorTotalTributos);
                $trib->appendChild($totTrib);
            }

            $valores->appendChild($trib);
        }

        $parent->appendChild($valores);
    }

    private function appendElement(DOMElement $parent, string $name, ?string $value): void
    {
        if ($value !== null) {
            $element = $this->dom->createElement($name, $value);
            $parent->appendChild($element);
        }
    }
}
