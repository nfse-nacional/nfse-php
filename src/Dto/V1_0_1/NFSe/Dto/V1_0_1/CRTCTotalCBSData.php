<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalCBSData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalCBS
 */
class CRTCTotalCBSData 
{
    /**
     * Grupo de valores referentes ao crédito presumido para CBS
     */
    public ?\NFSe\Dto\V1_0_1\CRTCTotalCBSCredPresData $gCBSCredPres = null;

    /**
     * Total do Diferimento CBS
     * vDifCBS = vCBS x pDifCBS
     */
    public ?string $vDifCBS = null;

    /**
     * Total valor da CBS da União
     * vCBS = vBC x (pCBS ou pAliqEfetCBS)
     */
    public string $vCBS;

}
