<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS\RTCInfoValoresIBSCBS\RTCInfoTributosIBSCBS\RTCInfoTributosSitClas;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCInfoTributosDif
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCInfoTributosDif
 */
class RTCInfoTributosDif 
{
    /**
     * Percentual de diferimento para o IBS estadual
     */
    public string $pDifUF;

    /**
     * Percentual de diferimento para o IBS municipal
     */
    public string $pDifMun;

    /**
     * Percentual de diferimento para a CBS
     */
    public string $pDifCBS;

}
