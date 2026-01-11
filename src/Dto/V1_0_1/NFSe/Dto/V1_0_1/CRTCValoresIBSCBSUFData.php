<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCValoresIBSCBSUFData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCValoresIBSCBSUF
 */
class CRTCValoresIBSCBSUFData 
{
    /**
     * Alíquota da UF para IBS da localidade de incidência parametrizada no sistema
     */
    public string $pIBSUF;

    /**
     * Percentual de redução de alíquota estadual
     */
    public ?string $pRedAliqUF = null;

    /**
     * pAliqEfetUF = pIBSUF x (1 - pRedAliqUF) x (1 - pRedutor)
     * Se pRedAliqUF não for informado na DPS, então pAliqEfetUF é a própria pIBSUF
     */
    public string $pAliqEfetUF;

}
