<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCTotalCIBS\RTCTotalIBS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCTotalIBSCredPres
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalIBSCredPres
 */
class RTCTotalIBSCredPres 
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
