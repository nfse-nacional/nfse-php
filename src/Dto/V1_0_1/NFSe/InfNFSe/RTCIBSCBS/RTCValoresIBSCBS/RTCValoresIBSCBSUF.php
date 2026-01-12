<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCValoresIBSCBS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCValoresIBSCBSUF
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCValoresIBSCBSUF
 */
class RTCValoresIBSCBSUF 
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
