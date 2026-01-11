<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalCBSCredPresData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalCBSCredPres
 */
class CRTCTotalCBSCredPresData 
{
    /**
     * Alíquota do crédito presumido para a CBS
     */
    public string $pCredPresCBS;

    /**
     * Valor do Crédito Presumido da CBS
     * vCredPresCBS = vBC x pCredPresCBS
     */
    public string $vCredPresCBS;

}
