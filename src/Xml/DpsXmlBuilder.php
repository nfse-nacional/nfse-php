<?php

namespace Nfse\Xml;

use DOMDocument;
use DOMElement;
use Nfse\Dto\Nfse\CondominioData;
use Nfse\Dto\Nfse\DocumentoAjusteBaseCalculoData;
use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\EnderecoData;
use Nfse\Dto\Nfse\IbscbsData;
use Nfse\Dto\Nfse\ImovelData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Dto\Nfse\LocacaoData;
use Nfse\Dto\Nfse\PrestadorData;
use Nfse\Dto\Nfse\ReembolsoDocumentoData;
use Nfse\Dto\Nfse\ServicoData;
use Nfse\Dto\Nfse\TomadorData;
use Nfse\Dto\Nfse\UnidadeImovelData;
use Nfse\Dto\Nfse\ValoresData;
use Nfse\Enums\OpcaoSimplesNacional;
use Nfse\Enums\TipoAmbiente;
use Nfse\Support\SchemaText;

class DpsXmlBuilder
{
    private DOMDocument $dom;

    private string $schema;

    public function __construct(?string $schema = null)
    {
        $this->schema = SchemaDps::resolver($schema, TipoAmbiente::Producao);
    }

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
        if ($this->schema !== '20260209') {
            $this->appendElement($parent, 'finNFSe', $data->finalidadeNfse);
        }
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

        if ($this->schema === '20261124') {
            $this->appendElement($parent, 'indDest', $data->indicadorDestinatario ?? $data->ibscbs?->indicadorDestinatario);
            $destinatario = $data->destinatario ?? $data->ibscbs?->destinatario;
            if ($destinatario) {
                $this->buildDestinatario($parent, $destinatario);
            }
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
            $this->buildIbscbs($parent, $data->ibscbs, $data->finalidadeNfse);
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
            if ($this->schema === '20260209') {
                $this->appendElement($cServ, 'xDescServ', $data->codigoServico->descricaoServico);
            }
            $this->appendElement($cServ, 'cNBS', $data->codigoServico->codigoNbs);
            $this->appendElement($cServ, 'cIntContrib', $data->codigoServico->codigoInternoContribuinte);
            if ($this->schema !== '20260209') {
                $this->appendElement($cServ, 'xDescServ', $data->codigoServico->descricaoServico);
            }
            $serv->appendChild($cServ);
        }

        if ($data->comercioExterior) {
            $comExt = $this->dom->createElement('comExt');
            $this->appendElement($comExt, 'mdPrestacao', $data->comercioExterior->modoPrestacao);
            $this->appendElement($comExt, 'vincPrest', $data->comercioExterior->vinculoPrestacao);
            $this->appendElement($comExt, 'tpMoeda', $data->comercioExterior->tipoMoeda);
            if ($this->schema === '20261124') {
                $this->appendElement($comExt, 'nFatura', $data->comercioExterior->numeroFatura);
                $this->appendElement(
                    $comExt,
                    'vFatura',
                    $data->comercioExterior->valorFatura !== null
                        ? number_format($data->comercioExterior->valorFatura, 2, '.', '')
                        : null
                );
            } else {
                // TSDec15V2 exige duas casas quando há parte decimal (99.9 é rejeitado, 99.90 não)
                $this->appendElement(
                    $comExt,
                    'vServMoeda',
                    $data->comercioExterior->valorServicoMoeda !== null
                        ? number_format($data->comercioExterior->valorServicoMoeda, 2, '.', '')
                        : null
                );
            }
            $this->appendElement($comExt, 'mecAFComexP', $data->comercioExterior->mecanismoApoioComexPrestador);
            $this->appendElement($comExt, 'mecAFComexT', $data->comercioExterior->mecanismoApoioComexTomador);
            $this->appendElement($comExt, 'movTempBens', $data->comercioExterior->movimentacaoTemporariaBens);
            if ($this->schema === '20261124') {
                $this->appendElement($comExt, 'nDUIMP', $data->comercioExterior->numeroDuimp);
                $this->appendElement($comExt, 'nDUE', $data->comercioExterior->numeroDue);
            } else {
                $this->appendElement($comExt, 'nDI', $data->comercioExterior->numeroDeclaracaoImportacao);
                $this->appendElement($comExt, 'nRE', $data->comercioExterior->numeroRegistroExportacao);
            }
            $this->appendElement($comExt, 'mdic', $data->comercioExterior->mdic);
            if ($this->schema === '20261124') {
                $this->appendElement($comExt, 'nContCambio', $data->comercioExterior->numeroContratoCambio);
            }
            $serv->appendChild($comExt);
        }

        if ($data->obra) {
            $obra = $this->dom->createElement('obra');
            $this->appendElement($obra, 'inscImobFisc', $data->obra->inscricaoImobiliariaFiscal);
            if ($data->obra->codigoObra) {
                $this->appendElement($obra, 'cObra', $data->obra->codigoObra);
            } elseif ($data->obra->codigoCib) {
                $this->appendElement($obra, 'cCIB', $data->obra->codigoCib);
            } elseif ($data->obra->endereco) {
                $this->buildEndereco($obra, $data->obra->endereco, true);
            }
            $serv->appendChild($obra);
        }

        if ($data->atividadeEvento) {
            $atvEvento = $this->dom->createElement('atvEvento');
            $this->appendElement($atvEvento, 'xNome', $data->atividadeEvento->nome);
            $this->appendElement($atvEvento, 'dtIni', $data->atividadeEvento->dataInicio);
            $this->appendElement($atvEvento, 'dtFim', $data->atividadeEvento->dataFim);
            if ($this->schema === '20261124') {
                $this->appendElement($atvEvento, 'cMun', $data->atividadeEvento->codigoMunicipio);
            }
            if ($data->atividadeEvento->idAtividadeEvento) {
                $this->appendElement($atvEvento, 'idAtvEvt', $data->atividadeEvento->idAtividadeEvento);
            } elseif ($data->atividadeEvento->endereco) {
                $this->buildEndereco($atvEvento, $data->atividadeEvento->endereco, true);
            }
            $serv->appendChild($atvEvento);
        }

        $info = $data->informacaoComplemento;
        if ($info && ($info->idDocumentoTecnico || $info->documentoReferencia || $info->numeroPedido || $info->itensPedido || $info->informacoesComplementares)) {
            $infoCompl = $this->dom->createElement('infoCompl');
            $this->appendElement($infoCompl, 'idDocTec', $info->idDocumentoTecnico);
            $this->appendElement($infoCompl, 'docRef', $info->documentoReferencia);
            $this->appendElement($infoCompl, 'xPed', $info->numeroPedido);
            if ($info->itensPedido) {
                $gItemPed = $this->dom->createElement('gItemPed');
                foreach ($info->itensPedido as $itemPedido) {
                    $this->appendElement($gItemPed, 'xItemPed', $itemPedido);
                }
                $infoCompl->appendChild($gItemPed);
            }
            $this->appendElement($infoCompl, 'xInfComp', $info->informacoesComplementares);
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

        if ($this->schema === '20260209' && $data->deducaoReducao) {
            $vDedRed = $this->dom->createElement('vDedRed');

            if ($data->deducaoReducao->documentos) {
                $documentos = $this->dom->createElement('documentos');
                foreach ($data->deducaoReducao->documentos as $docData) {
                    $doc = $this->dom->createElement('docDedRed');
                    $this->appendElement($doc, 'chNFSe', $docData->chaveNfse);
                    $this->appendElement($doc, 'chNFe', $docData->chaveNfe);
                    $this->appendElement($doc, 'tpDedRed', $docData->tipoDeducaoReducao);
                    $this->appendElement($doc, 'xDescOutDed', $docData->descricaoOutrasDeducoes);
                    $this->appendElement($doc, 'dtEmiDoc', $docData->dataEmissaoDocumento);
                    $this->appendElement($doc, 'vDedutivelRedutivel', $docData->valorDedutivelRedutivel !== null ? number_format($docData->valorDedutivelRedutivel, 2, '.', '') : null);
                    $this->appendElement($doc, 'vDeducaoReducao', $docData->valorDeducaoReducao !== null ? number_format($docData->valorDeducaoReducao, 2, '.', '') : null);
                    $documentos->appendChild($doc);
                }
                $vDedRed->appendChild($documentos);
            } elseif ($data->deducaoReducao->percentualDeducaoReducao !== null) {
                $this->appendElement($vDedRed, 'pDR', number_format($data->deducaoReducao->percentualDeducaoReducao, 2, '.', ''));
            } else {
                $this->appendElement($vDedRed, 'vDR', $data->deducaoReducao->valorDeducaoReducao !== null ? number_format($data->deducaoReducao->valorDeducaoReducao, 2, '.', '') : null);
            }

            $valores->appendChild($vDedRed);
        }

        if ($this->schema !== '20260209' && $data->ajusteBaseCalculo) {
            $vAjusteBc = $this->dom->createElement('vAjusteBC');
            if ($data->ajusteBaseCalculo->percentualAjusteBaseCalculoIssqn !== null) {
                $this->appendElement($vAjusteBc, 'pAjusteBCISSQN', number_format($data->ajusteBaseCalculo->percentualAjusteBaseCalculoIssqn, 2, '.', ''));
            } elseif ($data->ajusteBaseCalculo->valorAjusteBaseCalculoIssqn !== null) {
                $this->appendElement($vAjusteBc, 'vAjusteBCISSQN', number_format($data->ajusteBaseCalculo->valorAjusteBaseCalculoIssqn, 2, '.', ''));
            }

            if ($data->ajusteBaseCalculo->documentos) {
                $documentos = $this->dom->createElement('documentos');
                foreach ($data->ajusteBaseCalculo->documentos as $docData) {
                    $documentos->appendChild($this->buildDocumentoAjusteBaseCalculo($docData));
                }
                $vAjusteBc->appendChild($documentos);
            }

            if ($this->schema === '20261124' && $data->ajusteBaseCalculo->valorAjusteBaseCalculoIbscbsComercioExterior !== null) {
                $this->appendElement(
                    $vAjusteBc,
                    'vAjusteBCIBSCBSComExt',
                    number_format($data->ajusteBaseCalculo->valorAjusteBaseCalculoIbscbsComercioExterior, 2, '.', '')
                );
            }

            $valores->appendChild($vAjusteBc);
        }

        if ($data->tributacao) {
            $trib = $this->dom->createElement('trib');

            $tribMun = $this->dom->createElement('tribMun');
            $this->appendElement($tribMun, 'tribISSQN', $data->tributacao->tributacaoIssqn);
            $this->appendElement($tribMun, 'cPaisResult', $data->tributacao->codigoPaisResultado);
            $this->appendElement($tribMun, 'tpImunidade', $data->tributacao->tipoImunidade);

            if ($data->tributacao->tipoSuspensao) {
                $exigSusp = $this->dom->createElement('exigSusp');
                $this->appendElement($exigSusp, 'tpSusp', $data->tributacao->tipoSuspensao);
                $this->appendElement($exigSusp, 'nProcesso', $data->tributacao->numeroProcessoSuspensao);
                $tribMun->appendChild($exigSusp);
            }

            if ($data->tributacao->beneficioMunicipal && $data->tributacao->beneficioMunicipal->codigoBeneficio) {
                $bm = $this->dom->createElement('BM');
                $this->appendElement($bm, 'nBM', $data->tributacao->beneficioMunicipal->codigoBeneficio);
                if ($data->tributacao->beneficioMunicipal->valorReducaoBcBm !== null) {
                    $this->appendElement($bm, 'vRedBCBM', number_format($data->tributacao->beneficioMunicipal->valorReducaoBcBm, 2, '.', ''));
                } else {
                    $this->appendElement($bm, 'pRedBCBM', $data->tributacao->beneficioMunicipal->percentualReducaoBcBm !== null ? number_format($data->tributacao->beneficioMunicipal->percentualReducaoBcBm, 2, '.', '') : null);
                }
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
            $hasRetencoesFed = $data->tributacao->valorRetidoCp !== null
                || $data->tributacao->valorRetidoIrrf !== null
                || $data->tributacao->valorRetidoCsll !== null;

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

                $this->appendElement($tribFed, 'vRetCP', $data->tributacao->valorRetidoCp !== null ? number_format($data->tributacao->valorRetidoCp, 2, '.', '') : null);
                $this->appendElement($tribFed, 'vRetIRRF', $data->tributacao->valorRetidoIrrf !== null ? number_format($data->tributacao->valorRetidoIrrf, 2, '.', '') : null);
                $this->appendElement($tribFed, 'vRetCSLL', $data->tributacao->valorRetidoCsll !== null ? number_format($data->tributacao->valorRetidoCsll, 2, '.', '') : null);

                $trib->appendChild($tribFed);
            }

            $isSimplesNacional = false;
            if ($prestador && $prestador->regimeTributario && $prestador->regimeTributario->opcaoSimplesNacional === OpcaoSimplesNacional::MeEpp) {
                $isSimplesNacional = true;
            }

            $totTrib = null;

            if ($data->tributacao->percentualTotalTributosSN !== null) {
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

    private function buildDestinatario(DOMElement $parent, TomadorData $data): void
    {
        $dest = $this->dom->createElement('dest');
        $this->appendElement($dest, 'CNPJ', $data->cnpj);
        $this->appendElement($dest, 'CPF', $data->cpf);
        $this->appendElement($dest, 'NIF', $data->nif);
        $this->appendElement($dest, 'cNaoNIF', $data->codigoNaoNif);
        $this->appendElement($dest, 'xNome', $data->nome);

        if ($data->endereco) {
            $this->buildEndereco($dest, $data->endereco);
        }

        $this->appendElement($dest, 'fone', $data->telefone);
        $this->appendElement($dest, 'email', $data->email);
        $parent->appendChild($dest);
    }

    private function buildCondominios(CondominioData $data): DOMElement
    {
        $condominios = $this->dom->createElement('condominios');
        $this->appendElement($condominios, 'dVencOrig', $data->dataVencimentoOriginal);

        foreach ($data->cobrancas ?? [] as $cobranca) {
            $gCobranca = $this->dom->createElement('gCobranca');
            $this->appendElement($gCobranca, 'tpCobranca', $cobranca->tipoCobranca);
            $this->appendElement($gCobranca, 'xTpCobranca', $cobranca->descricaoTipoCobranca);
            $this->appendElement(
                $gCobranca,
                'vCobranca',
                $cobranca->valorCobranca !== null
                    ? number_format($cobranca->valorCobranca, 2, '.', '')
                    : null
            );

            foreach ($cobranca->detalhamentos ?? [] as $detalhe) {
                $gDetCobranca = $this->dom->createElement('gDetCobranca');
                $this->appendElement($gDetCobranca, 'tpDetCobranca', $detalhe->tipoDetalhamento);
                $this->appendElement($gDetCobranca, 'xTpDetCobranca', $detalhe->descricaoTipoDetalhamento);
                $this->appendElement(
                    $gDetCobranca,
                    'vDetCobranca',
                    $detalhe->valorDetalhamento !== null
                        ? number_format($detalhe->valorDetalhamento, 2, '.', '')
                        : null
                );
                $gCobranca->appendChild($gDetCobranca);
            }

            $condominios->appendChild($gCobranca);
        }

        foreach ($data->descontos ?? [] as $desconto) {
            $gDesconto = $this->dom->createElement('gDesconto');
            $this->appendElement($gDesconto, 'tpDesconto', $desconto->tipoDesconto);
            $this->appendElement(
                $gDesconto,
                'vDesconto',
                $desconto->valorDesconto !== null
                    ? number_format($desconto->valorDesconto, 2, '.', '')
                    : null
            );
            $this->appendElement($gDesconto, 'xTpDesconto', $desconto->descricaoTipoDesconto);
            $condominios->appendChild($gDesconto);
        }

        return $condominios;
    }

    private function buildIbscbs(DOMElement $parent, IbscbsData $data, ?string $finalidadeInfDps = null): void
    {
        $ibscbs = $this->dom->createElement('IBSCBS');

        if ($this->schema === '20260209') {
            $this->appendElement($ibscbs, 'finNFSe', $data->finalidadeNfse ?? $finalidadeInfDps);
        }

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
        if ($this->schema !== '20261124') {
            $this->appendElement($ibscbs, 'indDest', $data->indicadorDestinatario);
            if ($data->destinatario) {
                $this->buildDestinatario($ibscbs, $data->destinatario);
            }
        }

        if ($data->imovel) {
            $ibscbs->appendChild($this->buildImovel($data->imovel));
        }

        if ($this->schema !== '20260209' && $data->bensMoveis) {
            foreach ($data->bensMoveis as $bemMovel) {
                $bensMoveis = $this->dom->createElement('bensMoveis');
                $this->appendElement($bensMoveis, 'cNCMBemMovel', $bemMovel->codigoNcmBemMovel);
                $this->appendElement($bensMoveis, 'xNCMBemMovel', $bemMovel->descricaoNcmBemMovel);
                $this->appendElement($bensMoveis, 'qtdNCMBemMovel', $bemMovel->quantidadeNcmBemMovel);
                $ibscbs->appendChild($bensMoveis);
            }
        }

        if ($this->schema === '20261124' && $data->condominios) {
            $ibscbs->appendChild($this->buildCondominios($data->condominios));
        }

        $valores = $this->dom->createElement('valores');

        if ($this->schema === '20260209' && $data->documentosReembolso) {
            $gReeRepRes = $this->dom->createElement('gReeRepRes');
            foreach ($data->documentosReembolso as $documento) {
                $this->buildDocumentoReembolso($gReeRepRes, $documento);
            }
            $valores->appendChild($gReeRepRes);
        }

        $trib = $this->dom->createElement('trib');
        $gIbscbs = $this->dom->createElement('gIBSCBS');
        $destinoCst = $this->schema === '20260209' ? $gIbscbs : $trib;
        $this->appendElement($destinoCst, 'CST', $data->cst);
        $this->appendElement($destinoCst, 'cClassTrib', $data->codigoClassificacaoTributaria);

        $temGrupo = $this->schema === '20260209'
            || $data->codigoCreditoPresumido !== null
            || $data->cstTributacaoRegular !== null
            || $data->percentualDiferimentoUf !== null
            || $data->percentualDiferimentoMunicipal !== null
            || $data->percentualDiferimentoCbs !== null;

        if ($temGrupo) {
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
        }

        $valores->appendChild($trib);
        $ibscbs->appendChild($valores);
        $parent->appendChild($ibscbs);
    }

    private function buildImovel(ImovelData $data): DOMElement
    {
        $imovel = $this->dom->createElement('imovel');
        $this->appendElement($imovel, 'cMun', $data->codigoMunicipio);

        if ($data->locacao) {
            $imovel->appendChild($this->buildLocacao($data->locacao));
        }

        foreach ($data->unidadesImovel ?? [] as $unidade) {
            $imovel->appendChild($this->buildUnidadeImovel($unidade));
        }

        return $imovel;
    }

    private function buildLocacao(LocacaoData $data): DOMElement
    {
        $locacao = $this->dom->createElement('gLocacao');
        $this->appendElement($locacao, 'pCopropriedade', $data->percentualCopropriedade !== null ? number_format($data->percentualCopropriedade, 2, '.', '') : null);
        $this->appendElement($locacao, 'vTotOper', $data->valorTotalOperacao !== null ? number_format($data->valorTotalOperacao, 2, '.', '') : null);
        $this->appendElement($locacao, 'vDescIncondTot', $data->valorDescontoIncondicionadoTotal !== null ? number_format($data->valorDescontoIncondicionadoTotal, 2, '.', '') : null);
        $this->appendElement($locacao, 'vDescCondTot', $data->valorDescontoCondicionadoTotal !== null ? number_format($data->valorDescontoCondicionadoTotal, 2, '.', '') : null);
        $this->appendElement($locacao, 'dVencOrig', $data->dataVencimentoOriginal);

        return $locacao;
    }

    private function buildUnidadeImovel(UnidadeImovelData $data): DOMElement
    {
        $unidade = $this->dom->createElement('gUnidImob');
        $this->appendElement($unidade, 'inscImobFisc', $data->inscricaoImobiliariaFiscal);

        if ($data->codigoCib) {
            $this->appendElement($unidade, 'cCIB', $data->codigoCib);
        } elseif ($data->endereco) {
            $this->buildEndereco($unidade, $data->endereco, true);
        }

        foreach ($data->ajustesBaseCalculoLocacao ?? [] as $ajuste) {
            $parcela = $this->dom->createElement('gAjusteBCLocImoveis');
            $this->appendElement($parcela, 'tpAjusteBCLocImoveis', $ajuste->tipoAjusteBaseCalculoLocacao);
            $this->appendElement($parcela, 'xTpAjusteBCLocImoveis', $ajuste->descricaoTipoAjusteBaseCalculoLocacao);
            $this->appendElement($parcela, 'vAjusteBCLocImoveis', $ajuste->valorAjusteBaseCalculoLocacao !== null ? number_format($ajuste->valorAjusteBaseCalculoLocacao, 2, '.', '') : null);
            $unidade->appendChild($parcela);
        }

        return $unidade;
    }

    private function buildDocumentoAjusteBaseCalculo(DocumentoAjusteBaseCalculoData $data): DOMElement
    {
        $doc = $this->dom->createElement('docAjusteBC');
        $this->appendElement($doc, 'tpAjusteBC', $data->tipoAjusteBaseCalculo);
        $this->appendElement($doc, 'xTpAjusteBC', $data->descricaoTipoAjusteBaseCalculo);
        $this->appendElement($doc, 'vTotDoc', $data->valorTotalDocumento !== null ? number_format($data->valorTotalDocumento, 2, '.', '') : null);
        $this->appendElement($doc, 'vAjusteAplic', $data->valorAjusteAplicado !== null ? number_format($data->valorAjusteAplicado, 2, '.', '') : null);
        $this->appendElement($doc, 'dtEmiDoc', $data->dataEmissaoDocumento);
        $this->appendElement($doc, 'dtCompDoc', $data->dataCompetenciaDocumento);

        if ($data->dfeNacional) {
            $dfe = $this->dom->createElement('dFeNacional');
            $this->appendElement($dfe, 'tipoChaveDFe', $data->dfeNacional->tipoChaveDfe);
            $this->appendElement($dfe, 'xTipoChaveDFe', $data->dfeNacional->descricaoTipoChaveDfe);
            $this->appendElement($dfe, 'chaveDFe', $data->dfeNacional->chaveDfe);
            $doc->appendChild($dfe);
        } elseif ($data->documentoFiscalOutro) {
            $fiscal = $this->dom->createElement('docFiscalOutro');
            $this->appendElement($fiscal, 'cMunDocFiscal', $data->documentoFiscalOutro->codigoMunicipioDocumentoFiscal);
            $this->appendElement($fiscal, 'nDocFiscal', $data->documentoFiscalOutro->numeroDocumentoFiscal);
            $this->appendElement($fiscal, 'xDocFiscal', $data->documentoFiscalOutro->descricaoDocumentoFiscal);
            $doc->appendChild($fiscal);
        } elseif ($data->documentoOutro) {
            $outro = $this->dom->createElement('docOutro');
            $this->appendElement($outro, 'nDoc', $data->documentoOutro->numeroDocumento);
            $this->appendElement($outro, 'xDoc', $data->documentoOutro->descricaoDocumento);
            $doc->appendChild($outro);
        }

        if ($data->fornecedor) {
            $fornec = $this->dom->createElement('fornec');
            $this->appendElement($fornec, 'CNPJ', $data->fornecedor->cnpj);
            $this->appendElement($fornec, 'CPF', $data->fornecedor->cpf);
            $this->appendElement($fornec, 'NIF', $data->fornecedor->nif);
            $this->appendElement($fornec, 'cNaoNIF', $data->fornecedor->codigoNaoNif);
            $this->appendElement($fornec, 'CAEPF', $data->fornecedor->caepf);
            $this->appendElement($fornec, 'IM', $data->fornecedor->inscricaoMunicipal);
            $this->appendElement($fornec, 'xNome', $data->fornecedor->nome);
            if ($data->fornecedor->endereco) {
                $this->buildEndereco($fornec, $data->fornecedor->endereco);
            }
            $this->appendElement($fornec, 'fone', $data->fornecedor->telefone);
            $this->appendElement($fornec, 'email', $data->fornecedor->email);
            $doc->appendChild($fornec);
        }

        return $doc;
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
            $text = SchemaText::forSchema((string) $value);
            if ($text === null || $text === '') {
                return;
            }
            $element = $this->dom->createElement($name);
            $element->appendChild($this->dom->createTextNode($text));
            $parent->appendChild($element);
        }
    }
}
