<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalTribRegularData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalTribRegular
 */
class CRTCTotalTribRegularData 
{
    /**
     * Alíquota efetiva de tributação regular do IBS estadual
     */
    public string $pAliqEfeRegIBSUF;

    /**
     * Valor da tributação regular do IBS estadual
     * vTribRegIBSUF = vBC x pAliqEfeRegIBSUF
     */
    public string $vTribRegIBSUF;

    /**
     * Alíquota efetiva de tributação regular do IBS municipal
     */
    public string $pAliqEfeRegIBSMun;

    /**
     * Valor da tributação regular do IBS municipal
     * vTribRegIBSMun = vBC x pAliqEfeRegIBSMun
     */
    public string $vTribRegIBSMun;

    /**
     * Alíquota efetiva de tributação regular da CBS
     */
    public string $pAliqEfeRegCBS;

    /**
     * Valor da tributação regular da CBS
     * vTribRegCBS = vBC x pAliqEfeRegCBS
     */
    public string $vTribRegCBS;

}
