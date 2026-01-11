<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalTribCompraGovData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalTribCompraGov
 */
class CRTCTotalTribCompraGovData 
{
    /**
     * Alíquota do IBS de competência do Estado
     */
    public string $pIBSUF;

    /**
     * Valor do Tributo do IBS da UF calculado
     */
    public string $vIBSUF;

    /**
     * Alíquota do IBS de competência do Município
     */
    public string $pIBSMun;

    /**
     * Valor do Tributo do IBS do Município calculado
     */
    public string $vIBSMun;

    /**
     * Alíquota da CBS
     */
    public string $pCBS;

    /**
     * Valor do Tributo da CBS calculado
     */
    public string $vCBS;

}
