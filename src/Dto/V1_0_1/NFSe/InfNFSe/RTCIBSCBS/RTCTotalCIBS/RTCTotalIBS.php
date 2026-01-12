<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCTotalCIBS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCTotalIBS
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalIBS
 */
class RTCTotalIBS 
{
    /**
     * Valor total do IBS.
     * vIBSTot = vIBSUF + vIBSMun
     */
    public string $vIBSTot;

    /**
     * Grupo de valores referentes ao crédito presumido para IBS
     */
    public ?\NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCTotalCIBS\RTCTotalIBS\RTCTotalIBSCredPres $gIBSCredPres = null;

    /**
     * Grupo de valores referentes ao IBS Estadual
     */
    public \NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCTotalCIBS\RTCTotalIBS\RTCTotalIBSUF $gIBSUFTot;

    /**
     * Grupo de valores referentes ao IBS Municipal
     */
    public \NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCTotalCIBS\RTCTotalIBS\RTCTotalIBSMun $gIBSMunTot;

}
