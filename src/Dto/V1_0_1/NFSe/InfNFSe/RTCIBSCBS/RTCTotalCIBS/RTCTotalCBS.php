<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCTotalCIBS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCTotalCBS
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalCBS
 */
class RTCTotalCBS 
{
    /**
     * Grupo de valores referentes ao crédito presumido para CBS
     */
    public ?\NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCTotalCIBS\RTCTotalCBS\RTCTotalCBSCredPres $gCBSCredPres = null;

    /**
     * Total do Diferimento CBS
     * vDifCBS = vCBS x pDifCBS
     */
    public ?string $vDifCBS = null;

    /**
     * Total valor da CBS da União
     * vCBS = vBC x (pCBS ou pAliqEfetCBS)
     */
    public string $vCBS;

}
