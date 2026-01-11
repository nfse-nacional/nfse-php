<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCValoresIBSCBSFedData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCValoresIBSCBSFed
 */
class CRTCValoresIBSCBSFedData 
{
    /**
     * Alíquota da União para CBS parametrizada no sistema
     */
    public string $pCBS;

    /**
     * Percentual da redução de alíquota da CBS
     */
    public ?string $pRedAliqCBS = null;

    /**
     * pAliqEfetCBS = pCBS x (1 - pRedAliqCBS) x (1 - pRedutor)
     * Se pRedAliqCBS não for informado na DPS, então pAliqEfetCBS é a própria pCBS
     */
    public string $pAliqEfetCBS;

}
