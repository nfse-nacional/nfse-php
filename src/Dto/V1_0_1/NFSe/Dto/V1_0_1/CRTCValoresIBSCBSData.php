<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCValoresIBSCBSData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCValoresIBSCBS
 */
class CRTCValoresIBSCBSData 
{
    /**
     * Valor da base de cálculo (BC) do IBS/CBS antes das reduções para cálculo do tributo bruto
     * vBC = vServ - descIncond – vCalcReeRepRes – vISSQN – vPIS - vCOFINS (até 2026) ou
     * vBC = vServ - descIncond – vCalcReeRepRes – vISSQN (até 2032)
     */
    public string $vBC;

    /**
     * Valor monetário (R$) total relativo ao fornecimento próprio de bens materiais ou relacionados a
     * operações de terceiros,
     * objeto de reembolso, repasse ou ressarcimento pelo recebedor, já tributados e aqui
     * referenciados e que não integram
     * da base de cálculo (BC) do ISSQN, do IBS e da CBS.
     */
    public ?string $vCalcReeRepRes = null;

    /**
     * Grupo de Informações relativas aos valores do IBS Estadual
     */
    public \NFSe\Dto\V1_0_1\CRTCValoresIBSCBSUFData $uf;

    /**
     * Grupo de Informações relativas aos valores do IBS Municipal
     */
    public \NFSe\Dto\V1_0_1\CRTCValoresIBSCBSMunData $mun;

    /**
     * Grupo de Informações relativas aos valores da CBS
     */
    public \NFSe\Dto\V1_0_1\CRTCValoresIBSCBSFedData $fed;

}
