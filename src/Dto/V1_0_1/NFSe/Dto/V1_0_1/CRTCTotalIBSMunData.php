<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalIBSMunData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalIBSMun
 */
class CRTCTotalIBSMunData 
{
    /**
     * Total do Diferimento do IBS municipal
     * vDifMun = vIBSMun x pDifMun
     */
    public ?string $vDifMun = null;

    /**
     * Total valor do IBS municipal
     * vIBSMun = vBC x (pIBSMun ou pAliqEfetMun)
     */
    public string $vIBSMun;

}
