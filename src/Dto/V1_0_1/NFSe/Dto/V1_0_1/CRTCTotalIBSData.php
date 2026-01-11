<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalIBSData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalIBS
 */
class CRTCTotalIBSData 
{
    /**
     * Valor total do IBS.
     * vIBSTot = vIBSUF + vIBSMun
     */
    public string $vIBSTot;

    /**
     * Grupo de valores referentes ao crédito presumido para IBS
     */
    public ?\NFSe\Dto\V1_0_1\CRTCTotalIBSCredPresData $gIBSCredPres = null;

    /**
     * Grupo de valores referentes ao IBS Estadual
     */
    public \NFSe\Dto\V1_0_1\CRTCTotalIBSUFData $gIBSUFTot;

    /**
     * Grupo de valores referentes ao IBS Municipal
     */
    public \NFSe\Dto\V1_0_1\CRTCTotalIBSMunData $gIBSMunTot;

}
