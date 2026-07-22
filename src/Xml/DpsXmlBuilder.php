<?php

namespace Nfse\Xml;

use DOMDocument;
use DOMElement;
use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\EnderecoData;
use Nfse\Dto\Nfse\IbscbsData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Dto\Nfse\PrestadorData;
use Nfse\Dto\Nfse\ReembolsoDocumentoData;
use Nfse\Dto\Nfse\ServicoData;
use Nfse\Dto\Nfse\TomadorData;
use Nfse\Dto\Nfse\ValoresData;
use Nfse\Enums\OpcaoSimplesNacional;

class DpsXmlBuilder
{
    private DOMDocument $dom;

    public function build(DpsData $dps): string
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = false;
        $this->dom->encoding = 'UTF-8';

        $root = $this->dom->createElementNS('http://www.sped.fazenda.gov.br/nfse', 'DPS');
        $root->setAttribute('versao', (string) $dps->versao);
        $this->dom->appendChild($root);

        $infDps = $this->dom->createElement('infDPS');
        $infDps->setAttribute('Id', (string) $dps->infDps->id);
        $root->appendChild($infDps);

        $this->buildInfDps($infDps, $dps->infDps);

        $xml = $this->dom->saveXML($root);

        return str_replace(["\n", "\r", "\t"], '', $xml);
    }

    private function buildInfDps(DOMElement $parent, InfDpsData $data): void
    {
        $this->appendElement($parent, 'tpAmb', $data->tipoAmbiente);
        $this->appendElement($parent, 'dhEmi', $data->dataEmissao);
        $this->appendElement($parent, 'verAplic', $data->versaoAplicativo);
        $this->appendElement($parent, 'serie', $data->serie);
        $this->appendElement($parent, 'nDPS', $data->numeroDps);
        $this->appendElement($parent, 'dCompet', $data->dataCompetencia);
        $this->appendElement($parent, 'tpEmit', $data->tipoEmitente);
        $this->appendElement($parent, 'cMotivoEmisTI', $data->motivoEmissaoTomadorIntermediario);
        $this->appendElement($parent, 'chNFSeRej', $data->chaveNfseRejeitada);
        $this->appendElement($parent, 'cLocEmi', $data->codigoLocalEmissao);

        if ($data->substituicao) {
            $subst = $this->dom->createElement('subst');
            $this->appendElement($subst, 'chSubstda', $data->substituicao->chaveNfseSubstituida);
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
            $this->buildValores($parent, $data->valores, $data->prestador);
        }

        if ($data->ibscbs) {
            $this->buildIbscbs($parent, $data->ibscbs);
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
            $this->appendElement($regTrib, 'opSimpNac', $data->regimeTributario->opcaoSimplesNacional);
            $this->appendElement($regTrib, 'regApTribSN', $data->regimeTributario->regimeApuracaoTributosSn);
            $this->appendElement($regTrib, 'regEspTrib', $data->regimeTributario->regimeEspecialTributacao);
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

    /**
     * O endereço simples (obra, evento e imóvel) traz o CEP direto no lugar do grupo
     * endNac e não informa o país no endereço no exterior.
     */
    private function buildEndereco(DOMElement $parent, EnderecoData $data, bool $enderecoSimples = false): void
    {
        $end = $this->dom->createElement('end');

        if ($enderecoSimples) {
            if (! $data->enderecoExterior) {
                $this->appendElement($end, 'CEP', $data->cep);
            }
        } elseif ($data->codigoMunicipio || $data->cep) {
            $endNac = $this->dom->createElement('endNac');
            $this->appendElement($endNac, 'cMun', $data->codigoMunicipio);
            $this->appendElement($endNac, 'CEP', $data->cep);
            $end->appendChild($endNac);
        }

        if ($data->enderecoExterior) {
            $endExt = $this->dom->createElement('endExt');
            if (! $enderecoSimples) {
                $this->appendElement($endExt, 'cPais', $data->enderecoExterior->codigoPais);
            }
            $this->appendElement($endExt, 'cEndPost', $data->enderecoExterior->codigoEnderecamentoPostal);
            $this->appendElement($endExt, 'xCidade', $data->enderecoExterior->cidade);
            $this->appendElement($endExt, 'xEstProvReg', $data->enderecoExterior->estadoProvinciaRegiao);
            $end->appendChild($endExt);
        }

        $this->appendElement($end, 'xLgr', $data->logradouro);
        $this->appendElement($end, 'nro', $data->numero);
        $this->appendElement($end, 'xCpl', $data->complemento);
        $this->appendElement($end, 'xBairro', $data->bairro);

        $parent->appendChild($end);
    }

    private function buildServico(DOMElement $parent, ServicoData $data): void
    {
        $serv = $this->dom->createElement('serv');

        if ($data->localPrestacao) {
            $locPrest = $this->dom->createElement('locPrest');
            if ($data->localPrestacao->codigoLocalPrestacao) {
                $this->appendElement($locPrest, 'cLocPrestacao', $data->localPrestacao->codigoLocalPrestacao);
            } elseif ($data->localPrestacao->codigoPaisPrestacao) {
                $this->appendElement($locPrest, 'cPaisPrestacao', $data->localPrestacao->codigoPaisPrestacao);
            }
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
            $this->appendElement($comExt, 'mdPrestacao', $data->comercioExterior->modoPrestacao);
            $this->appendElement($comExt, 'vincPrest', $data->comercioExterior->vinculoPrestacao);
            $this->appendElement($comExt, 'tpMoeda', $data->comercioExterior->tipoMoeda);
            $this->appendElement($comExt, 'vServMoeda', $data->comercioExterior->valorServicoMoeda);
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

        if ($data->informacaoComplemento && ($data->informacaoComplemento->idDocumentoTecnico || $data->informacaoComplemento->documentoReferencia || $data->informacaoComplemento->informacoesComplementares)) {
            $infoCompl = $this->dom->createElement('infoCompl');
            if ($data->informacaoComplemento->idDocumentoTecnico) {
                $this->appendElement($infoCompl, 'idDocTec', $data->informacaoComplemento->idDocumentoTecnico);
            }

            if ($data->informacaoComplemento->documentoReferencia) {
                $this->appendElement($infoCompl, 'docRef', $data->informacaoComplemento->documentoReferencia);
            }

            if ($data->informacaoComplemento->informacoesComplementares) {
                $this->appendElement($infoCompl, 'xInfComp', $data->informacaoComplemento->informacoesComplementares);
            }

            $serv->appendChild($infoCompl);
        }

        $parent->appendChild($serv);
    }

    private function buildValores(DOMElement $parent, ValoresData $data, ?PrestadorData $prestador = null): void
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

            if ($data->deducaoReducao->documentos) {
                $documentos = $this->dom->createElement('documentos');
                foreach ($data->deducaoReducao->documentos as $docData) {
                    $doc = $this->dom->createElement('doc');
                    $this->appendElement($doc, 'chNFSe', $docData->chaveNfse);
                    $this->appendElement($doc, 'chNFe', $docData->chaveNfe);
                    $this->appendElement($doc, 'tpDedRed', $docData->tipoDeducaoReducao);
                    $this->appendElement($doc, 'xDescOutDed', $docData->descricaoOutrasDeducoes);
                    $this->appendElement($doc, 'dEmiDoc', $docData->dataEmissaoDocumento);
                    $this->appendElement($doc, 'vDedutivelRedutivel', $docData->valorDedutivelRedutivel !== null ? number_format($docData->valorDedutivelRedutivel, 2, '.', '') : null);
                    $this->appendElement($doc, 'vDeducaoReducao', $docData->valorDeducaoReducao !== null ? number_format($docData->valorDeducaoReducao, 2, '.', '') : null);
                    $documentos->appendChild($doc);
                }
                $vDedRed->appendChild($documentos);
            }

            $valores->appendChild($vDedRed);
        }

        if ($data->tributacao) {
            $trib = $this->dom->createElement('trib');

            $tribMun = $this->dom->createElement('tribMun');
            $this->appendElement($tribMun, 'tribISSQN', $data->tributacao->tributacaoIssqn);
            $this->appendElement($tribMun, 'tpImunidade', $data->tributacao->tipoImunidade);

            if ($data->tributacao->tipoSuspensao) {
                $exigSusp = $this->dom->createElement('exigSusp');
                $this->appendElement($exigSusp, 'tpSusp', $data->tributacao->tipoSuspensao);
                $this->appendElement($exigSusp, 'nProcesso', $data->tributacao->numeroProcessoSuspensao);
                $tribMun->appendChild($exigSusp);
            }

            if ($data->tributacao->beneficioMunicipal) {
                $bm = $this->dom->createElement('BM');
                $this->appendElement($bm, 'pRedBCBM', $data->tributacao->beneficioMunicipal->percentualReducaoBcBm !== null ? number_format($data->tributacao->beneficioMunicipal->percentualReducaoBcBm, 2, '.', '') : null);
                $this->appendElement($bm, 'vRedBCBM', $data->tributacao->beneficioMunicipal->valorReducaoBcBm !== null ? number_format($data->tributacao->beneficioMunicipal->valorReducaoBcBm, 2, '.', '') : null);
                $tribMun->appendChild($bm);
            }

            $this->appendElement($tribMun, 'tpRetISSQN', $data->tributacao->tipoRetencaoIssqn);
            $this->appendElement(
                $tribMun,
                'pAliq',
                $data->tributacao->aliquota !== null
                    ? number_format($data->tributacao->aliquota, 2, '.', '')
                    : null
            );

            $trib->appendChild($tribMun);

            $hasPiscofins = $data->tributacao->cstPisCofins !== null;
            $hasRetencoesFed = $data->tributacao->valorRetidoIrrf !== null || $data->tributacao->valorRetidoCsll !== null;

            if ($hasPiscofins || $hasRetencoesFed) {
                $tribFed = $this->dom->createElement('tribFed');

                if ($hasPiscofins) {
                    $piscofins = $this->dom->createElement('piscofins');
                    $this->appendElement($piscofins, 'CST', $data->tributacao->cstPisCofins);
                    $this->appendElement($piscofins, 'vBCPisCofins', $data->tributacao->baseCalculoPisCofins !== null ? number_format($data->tributacao->baseCalculoPisCofins, 2, '.', '') : null);
                    $this->appendElement($piscofins, 'pAliqPis', $data->tributacao->aliquotaPis !== null ? number_format($data->tributacao->aliquotaPis, 2, '.', '') : null);
                    $this->appendElement($piscofins, 'pAliqCofins', $data->tributacao->aliquotaCofins !== null ? number_format($data->tributacao->aliquotaCofins, 2, '.', '') : null);
                    $this->appendElement($piscofins, 'vPis', $data->tributacao->valorPis !== null ? number_format($data->tributacao->valorPis, 2, '.', '') : null);
                    $this->appendElement($piscofins, 'vCofins', $data->tributacao->valorCofins !== null ? number_format($data->tributacao->valorCofins, 2, '.', '') : null);
                    $this->appendElement($piscofins, 'tpRetPisCofins', $data->tributacao->tipoRetencaoPisCofins);
                    $tribFed->appendChild($piscofins);
                }

                $this->appendElement($tribFed, 'vRetIRRF', $data->tributacao->valorRetidoIrrf !== null ? number_format($data->tributacao->valorRetidoIrrf, 2, '.', '') : null);
                $this->appendElement($tribFed, 'vRetCSLL', $data->tributacao->valorRetidoCsll !== null ? number_format($data->tributacao->valorRetidoCsll, 2, '.', '') : null);
                $this->appendElement($tribFed, 'vRetContPrev', null); // Placeholder if needed in future

                $trib->appendChild($tribFed);
            }

            $isSimplesNacional = false;
            if ($prestador && $prestador->regimeTributario && $prestador->regimeTributario->opcaoSimplesNacional === OpcaoSimplesNacional::MeEpp) {
                $isSimplesNacional = true;
            }

            $totTrib = null;

            if ($data->tributacao->percentualTotalTributosSN) {
                $totTrib = $this->dom->createElement('totTrib');
                $this->appendElement($totTrib, 'pTotTribSN', number_format($data->tributacao->percentualTotalTributosSN, 2, '.', ''));
            } elseif ($data->tributacao->valorTotalTributosFederais !== null || $data->tributacao->valorTotalTributosEstaduais !== null || $data->tributacao->valorTotalTributosMunicipais !== null) {
                $totTrib = $this->dom->createElement('totTrib');
                $vTotTrib = $this->dom->createElement('vTotTrib');
                $this->appendElement($vTotTrib, 'vTotTribFed', $data->tributacao->valorTotalTributosFederais !== null ? number_format($data->tributacao->valorTotalTributosFederais, 2, '.', '') : null);
                $this->appendElement($vTotTrib, 'vTotTribEst', $data->tributacao->valorTotalTributosEstaduais !== null ? number_format($data->tributacao->valorTotalTributosEstaduais, 2, '.', '') : null);
                $this->appendElement($vTotTrib, 'vTotTribMun', $data->tributacao->valorTotalTributosMunicipais !== null ? number_format($data->tributacao->valorTotalTributosMunicipais, 2, '.', '') : null);
                $totTrib->appendChild($vTotTrib);
            } elseif ($data->tributacao->percentualTotalTributosFederais !== null || $data->tributacao->percentualTotalTributosEstaduais !== null || $data->tributacao->percentualTotalTributosMunicipais !== null) {
                $totTrib = $this->dom->createElement('totTrib');
                $pTotTrib = $this->dom->createElement('pTotTrib');
                $this->appendElement($pTotTrib, 'pTotTribFed', $data->tributacao->percentualTotalTributosFederais !== null ? number_format($data->tributacao->percentualTotalTributosFederais, 2, '.', '') : null);
                $this->appendElement($pTotTrib, 'pTotTribEst', $data->tributacao->percentualTotalTributosEstaduais !== null ? number_format($data->tributacao->percentualTotalTributosEstaduais, 2, '.', '') : null);
                $this->appendElement($pTotTrib, 'pTotTribMun', $data->tributacao->percentualTotalTributosMunicipais !== null ? number_format($data->tributacao->percentualTotalTributosMunicipais, 2, '.', '') : null);
                $totTrib->appendChild($pTotTrib);
            } elseif ($data->tributacao->indicadorTotalTributos !== null) {
                $totTrib = $this->dom->createElement('totTrib');
                $this->appendElement($totTrib, 'indTotTrib', $data->tributacao->indicadorTotalTributos);
            }

            if ($totTrib) {
                $trib->appendChild($totTrib);
            }

            $valores->appendChild($trib);
        }

        $parent->appendChild($valores);
    }

    private function buildIbscbs(DOMElement $parent, IbscbsData $data): void
    {
        $ibscbs = $this->dom->createElement('IBSCBS');

        $this->appendElement($ibscbs, 'finNFSe', $data->finalidadeNfse);
        $this->appendElement($ibscbs, 'indFinal', $data->indicadorUsoConsumoPessoal);
        $this->appendElement($ibscbs, 'cIndOp', $data->codigoIndicadorOperacao);
        $this->appendElement($ibscbs, 'tpOper', $data->tipoOperacao);

        if ($data->chavesNfseReferenciadas) {
            $gRefNFSe = $this->dom->createElement('gRefNFSe');
            foreach ($data->chavesNfseReferenciadas as $chave) {
                $this->appendElement($gRefNFSe, 'refNFSe', $chave);
            }
            $ibscbs->appendChild($gRefNFSe);
        }

        $this->appendElement($ibscbs, 'tpEnteGov', $data->tipoEnteGovernamental);
        $this->appendElement($ibscbs, 'indDest', $data->indicadorDestinatario);

        if ($data->destinatario) {
            $dest = $this->dom->createElement('dest');
            $this->appendElement($dest, 'CNPJ', $data->destinatario->cnpj);
            $this->appendElement($dest, 'CPF', $data->destinatario->cpf);
            $this->appendElement($dest, 'NIF', $data->destinatario->nif);
            $this->appendElement($dest, 'cNaoNIF', $data->destinatario->codigoNaoNif);
            $this->appendElement($dest, 'xNome', $data->destinatario->nome);

            if ($data->destinatario->endereco) {
                $this->buildEndereco($dest, $data->destinatario->endereco);
            }

            $this->appendElement($dest, 'fone', $data->destinatario->telefone);
            $this->appendElement($dest, 'email', $data->destinatario->email);
            $ibscbs->appendChild($dest);
        }

        if ($data->imovel) {
            $imovel = $this->dom->createElement('imovel');
            $this->appendElement($imovel, 'inscImobFisc', $data->imovel->inscricaoImobiliariaFiscal);

            if ($data->imovel->codigoCib) {
                $this->appendElement($imovel, 'cCIB', $data->imovel->codigoCib);
            } elseif ($data->imovel->endereco) {
                $this->buildEndereco($imovel, $data->imovel->endereco, true);
            }

            $ibscbs->appendChild($imovel);
        }

        $valores = $this->dom->createElement('valores');

        if ($data->documentosReembolso) {
            $gReeRepRes = $this->dom->createElement('gReeRepRes');
            foreach ($data->documentosReembolso as $documento) {
                $this->buildDocumentoReembolso($gReeRepRes, $documento);
            }
            $valores->appendChild($gReeRepRes);
        }

        $trib = $this->dom->createElement('trib');
        $gIbscbs = $this->dom->createElement('gIBSCBS');
        $this->appendElement($gIbscbs, 'CST', $data->cst);
        $this->appendElement($gIbscbs, 'cClassTrib', $data->codigoClassificacaoTributaria);
        $this->appendElement($gIbscbs, 'cCredPres', $data->codigoCreditoPresumido);

        if ($data->cstTributacaoRegular) {
            $gTribRegular = $this->dom->createElement('gTribRegular');
            $this->appendElement($gTribRegular, 'CSTReg', $data->cstTributacaoRegular);
            $this->appendElement($gTribRegular, 'cClassTribReg', $data->codigoClassificacaoTributariaRegular);
            $gIbscbs->appendChild($gTribRegular);
        }

        if ($data->percentualDiferimentoUf !== null || $data->percentualDiferimentoMunicipal !== null || $data->percentualDiferimentoCbs !== null) {
            $gDif = $this->dom->createElement('gDif');
            $this->appendElement($gDif, 'pDifUF', number_format((float) $data->percentualDiferimentoUf, 2, '.', ''));
            $this->appendElement($gDif, 'pDifMun', number_format((float) $data->percentualDiferimentoMunicipal, 2, '.', ''));
            $this->appendElement($gDif, 'pDifCBS', number_format((float) $data->percentualDiferimentoCbs, 2, '.', ''));
            $gIbscbs->appendChild($gDif);
        }

        $trib->appendChild($gIbscbs);
        $valores->appendChild($trib);
        $ibscbs->appendChild($valores);

        $parent->appendChild($ibscbs);
    }

    private function buildDocumentoReembolso(DOMElement $parent, ReembolsoDocumentoData $data): void
    {
        $documentos = $this->dom->createElement('documentos');

        if ($data->chaveDfe) {
            $dFeNacional = $this->dom->createElement('dFeNacional');
            $this->appendElement($dFeNacional, 'tipoChaveDFe', $data->tipoChaveDfe);
            $this->appendElement($dFeNacional, 'xTipoChaveDFe', $data->descricaoTipoChaveDfe);
            $this->appendElement($dFeNacional, 'chaveDFe', $data->chaveDfe);
            $documentos->appendChild($dFeNacional);
        } elseif ($data->numeroDocumentoFiscal) {
            $docFiscalOutro = $this->dom->createElement('docFiscalOutro');
            $this->appendElement($docFiscalOutro, 'cMunDocFiscal', $data->codigoMunicipioDocumentoFiscal);
            $this->appendElement($docFiscalOutro, 'nDocFiscal', $data->numeroDocumentoFiscal);
            $this->appendElement($docFiscalOutro, 'xDocFiscal', $data->descricaoDocumentoFiscal);
            $documentos->appendChild($docFiscalOutro);
        } elseif ($data->numeroDocumento) {
            $docOutro = $this->dom->createElement('docOutro');
            $this->appendElement($docOutro, 'nDoc', $data->numeroDocumento);
            $this->appendElement($docOutro, 'xDoc', $data->descricaoDocumento);
            $documentos->appendChild($docOutro);
        }

        if ($data->fornecedor) {
            $fornec = $this->dom->createElement('fornec');
            $this->appendElement($fornec, 'CNPJ', $data->fornecedor->cnpj);
            $this->appendElement($fornec, 'CPF', $data->fornecedor->cpf);
            $this->appendElement($fornec, 'NIF', $data->fornecedor->nif);
            $this->appendElement($fornec, 'cNaoNIF', $data->fornecedor->codigoNaoNif);
            $this->appendElement($fornec, 'xNome', $data->fornecedor->nome);
            $documentos->appendChild($fornec);
        }

        $this->appendElement($documentos, 'dtEmiDoc', $data->dataEmissaoDocumento);
        $this->appendElement($documentos, 'dtCompDoc', $data->dataCompetenciaDocumento);
        $this->appendElement($documentos, 'tpReeRepRes', $data->tipoReembolso);
        $this->appendElement($documentos, 'xTpReeRepRes', $data->descricaoTipoReembolso);
        $this->appendElement($documentos, 'vlrReeRepRes', $data->valorReembolso !== null ? number_format($data->valorReembolso, 2, '.', '') : null);

        $parent->appendChild($documentos);
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
