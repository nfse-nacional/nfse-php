<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalIBSCredPresData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalIBSCredPres
 */
class CRTCTotalIBSCredPresData 
{
    /**
     * Alíquota do crédito presumido para o IBS
     */
    public string $pCredPresIBS;

    /**
     * Valor do Crédito Presumido para o IBS
     * vCredPresIBS = vBC x pCredPresIBS
     */
    public string $vCredPresIBS;

}
