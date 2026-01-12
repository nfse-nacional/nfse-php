<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCInfoValoresIBSCBS
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCInfoValoresIBSCBS
 */
class RTCInfoValoresIBSCBS 
{
    /**
     * Grupo de informações relativas a valores incluídos neste documento e recebidos por motivo de
     * estarem relacionadas
     * a operações de terceiros, objeto de reembolso, repasse ou ressarcimento pelo
     * recebedor, já tributados e aqui referenciados
     */
    public ?\NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS\RTCInfoValoresIBSCBS\RTCInfoReeRepRes $gReeRepRes = null;

    /**
     * Grupo de informações relacionados aos tributos IBS e CBS
     */
    public \NFSe\Dto\V1_0_1\DPS\InfDPS\RTCInfoIBSCBS\RTCInfoValoresIBSCBS\RTCInfoTributosIBSCBS $trib;

}
