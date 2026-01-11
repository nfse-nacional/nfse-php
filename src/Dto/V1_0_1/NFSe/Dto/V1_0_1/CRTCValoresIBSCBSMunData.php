<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCValoresIBSCBSMunData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCValoresIBSCBSMun
 */
class CRTCValoresIBSCBSMunData 
{
    /**
     * Alíquota do Município para IBS da localidade de incidência parametrizada no sistema
     */
    public string $pIBSMun;

    /**
     * Percentual de redução de alíquota municipal
     */
    public ?string $pRedAliqMun = null;

    /**
     * pAliqEfetMun = pIBSMun x (1 - pRedAliqMun) x (1 - pRedutor)
     * Se pRedAliqMun não for informado na DPS, então pAliqEfetMun é a própria pIBSMun
     */
    public string $pAliqEfetMun;

}
