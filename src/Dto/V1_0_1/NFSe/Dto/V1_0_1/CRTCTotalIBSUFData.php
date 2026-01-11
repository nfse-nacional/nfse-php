<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalIBSUFData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalIBSUF
 */
class CRTCTotalIBSUFData 
{
    /**
     * Total do Diferimento do IBS estadual
     * vDifUF = vIBSUF x pDifUF
     */
    public ?string $vDifUF = null;

    /**
     * Total valor do IBS estadual
     * vIBSUF = vBC x (pIBSUF ou pAliqEfetUF)
     */
    public string $vIBSUF;

}
