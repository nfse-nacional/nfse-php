<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class IbscbsNfseData extends Dto
{
    /**
     * Código IBGE da localidade de incidência do IBS/CBS (local da operação).
     */
    #[MapFrom('cLocalidadeIncid')]
    public ?string $codigoLocalidadeIncidencia = null;

    /**
     * Nome da localidade de incidência do IBS/CBS.
     */
    #[MapFrom('xLocalidadeIncid')]
    public ?string $nomeLocalidadeIncidencia = null;

    /**
     * Percentual de redução de alíquota em compra governamental.
     */
    #[MapFrom('pRedutor')]
    public ?float $percentualRedutor = null;

    /**
     * Valor da base de cálculo do IBS/CBS antes das reduções.
     */
    #[MapFrom('valores.vBC')]
    public ?float $baseCalculo = null;

    /**
     * Valor total relativo a reembolso, repasse ou ressarcimento que não integra
     * a base de cálculo do ISSQN, do IBS e da CBS.
     */
    #[MapFrom('valores.vCalcReeRepRes')]
    public ?float $valorCalculadoReembolso = null;

    /**
     * Alíquota da UF para IBS da localidade de incidência.
     */
    #[MapFrom('valores.uf.pIBSUF')]
    public ?float $aliquotaIbsUf = null;

    /**
     * Percentual de redução de alíquota estadual.
     */
    #[MapFrom('valores.uf.pRedAliqUF')]
    public ?float $percentualReducaoAliquotaUf = null;

    /**
     * Alíquota efetiva da UF para IBS.
     */
    #[MapFrom('valores.uf.pAliqEfetUF')]
    public ?float $aliquotaEfetivaUf = null;

    /**
     * Alíquota do Município para IBS da localidade de incidência.
     */
    #[MapFrom('valores.mun.pIBSMun')]
    public ?float $aliquotaIbsMunicipal = null;

    /**
     * Percentual de redução de alíquota municipal.
     */
    #[MapFrom('valores.mun.pRedAliqMun')]
    public ?float $percentualReducaoAliquotaMunicipal = null;

    /**
     * Alíquota efetiva do Município para IBS.
     */
    #[MapFrom('valores.mun.pAliqEfetMun')]
    public ?float $aliquotaEfetivaMunicipal = null;

    /**
     * Alíquota da União para CBS.
     */
    #[MapFrom('valores.fed.pCBS')]
    public ?float $aliquotaCbs = null;

    /**
     * Percentual de redução de alíquota da CBS.
     */
    #[MapFrom('valores.fed.pRedAliqCBS')]
    public ?float $percentualReducaoAliquotaCbs = null;

    /**
     * Alíquota efetiva da União para CBS.
     */
    #[MapFrom('valores.fed.pAliqEfetCBS')]
    public ?float $aliquotaEfetivaCbs = null;

    /**
     * Valor total da NFS-e considerando os impostos por fora (IBS e CBS).
     */
    #[MapFrom('totCIBS.vTotNF')]
    public ?float $valorTotalNota = null;

    /**
     * Valor total do IBS.
     */
    #[MapFrom('totCIBS.gIBS.vIBSTot')]
    public ?float $valorTotalIbs = null;

    /**
     * Alíquota do crédito presumido para o IBS.
     */
    #[MapFrom('totCIBS.gIBS.gIBSCredPres.pCredPresIBS')]
    public ?float $aliquotaCreditoPresumidoIbs = null;

    /**
     * Valor do crédito presumido para o IBS.
     */
    #[MapFrom('totCIBS.gIBS.gIBSCredPres.vCredPresIBS')]
    public ?float $valorCreditoPresumidoIbs = null;

    /**
     * Total do diferimento do IBS estadual.
     */
    #[MapFrom('totCIBS.gIBS.gIBSUFTot.vDifUF')]
    public ?float $valorDiferimentoUf = null;

    /**
     * Total do valor do IBS estadual.
     */
    #[MapFrom('totCIBS.gIBS.gIBSUFTot.vIBSUF')]
    public ?float $valorIbsUf = null;

    /**
     * Total do diferimento do IBS municipal.
     */
    #[MapFrom('totCIBS.gIBS.gIBSMunTot.vDifMun')]
    public ?float $valorDiferimentoMunicipal = null;

    /**
     * Total do valor do IBS municipal.
     */
    #[MapFrom('totCIBS.gIBS.gIBSMunTot.vIBSMun')]
    public ?float $valorIbsMunicipal = null;

    /**
     * Alíquota do crédito presumido para a CBS.
     */
    #[MapFrom('totCIBS.gCBS.gCBSCredPres.pCredPresCBS')]
    public ?float $aliquotaCreditoPresumidoCbs = null;

    /**
     * Valor do crédito presumido da CBS.
     */
    #[MapFrom('totCIBS.gCBS.gCBSCredPres.vCredPresCBS')]
    public ?float $valorCreditoPresumidoCbs = null;

    /**
     * Total do diferimento da CBS.
     */
    #[MapFrom('totCIBS.gCBS.vDifCBS')]
    public ?float $valorDiferimentoCbs = null;

    /**
     * Total do valor da CBS da União.
     */
    #[MapFrom('totCIBS.gCBS.vCBS')]
    public ?float $valorCbs = null;

    /**
     * Alíquota efetiva de tributação regular do IBS estadual.
     */
    #[MapFrom('totCIBS.gTribRegular.pAliqEfeRegIBSUF')]
    public ?float $aliquotaEfetivaRegularIbsUf = null;

    /**
     * Valor da tributação regular do IBS estadual.
     */
    #[MapFrom('totCIBS.gTribRegular.vTribRegIBSUF')]
    public ?float $valorTributacaoRegularIbsUf = null;

    /**
     * Alíquota efetiva de tributação regular do IBS municipal.
     */
    #[MapFrom('totCIBS.gTribRegular.pAliqEfeRegIBSMun')]
    public ?float $aliquotaEfetivaRegularIbsMunicipal = null;

    /**
     * Valor da tributação regular do IBS municipal.
     */
    #[MapFrom('totCIBS.gTribRegular.vTribRegIBSMun')]
    public ?float $valorTributacaoRegularIbsMunicipal = null;

    /**
     * Alíquota efetiva de tributação regular da CBS.
     */
    #[MapFrom('totCIBS.gTribRegular.pAliqEfeRegCBS')]
    public ?float $aliquotaEfetivaRegularCbs = null;

    /**
     * Valor da tributação regular da CBS.
     */
    #[MapFrom('totCIBS.gTribRegular.vTribRegCBS')]
    public ?float $valorTributacaoRegularCbs = null;

    /**
     * Alíquota do IBS de competência do Estado em compras governamentais.
     */
    #[MapFrom('totCIBS.gTribCompraGov.pIBSUF')]
    public ?float $aliquotaCompraGovIbsUf = null;

    /**
     * Valor do tributo do IBS da UF calculado em compras governamentais.
     */
    #[MapFrom('totCIBS.gTribCompraGov.vIBSUF')]
    public ?float $valorCompraGovIbsUf = null;

    /**
     * Alíquota do IBS de competência do Município em compras governamentais.
     */
    #[MapFrom('totCIBS.gTribCompraGov.pIBSMun')]
    public ?float $aliquotaCompraGovIbsMunicipal = null;

    /**
     * Valor do tributo do IBS do Município calculado em compras governamentais.
     */
    #[MapFrom('totCIBS.gTribCompraGov.vIBSMun')]
    public ?float $valorCompraGovIbsMunicipal = null;

    /**
     * Alíquota da CBS em compras governamentais.
     */
    #[MapFrom('totCIBS.gTribCompraGov.pCBS')]
    public ?float $aliquotaCompraGovCbs = null;

    /**
     * Valor do tributo da CBS calculado em compras governamentais.
     */
    #[MapFrom('totCIBS.gTribCompraGov.vCBS')]
    public ?float $valorCompraGovCbs = null;
}
