<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe;

use NFSe\Dto\Attributes\MapFrom;

/**
 * RTCIBSCBS
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCIBSCBS
 */
class RTCIBSCBS 
{
    /**
     * Código IBGE da localidade de incidência do IBS/CBS (local da operação)
     */
    public string $cLocalidadeIncid;

    /**
     * Nome da localidade de incidência do IBS/CBS
     */
    public string $xLocalidadeIncid;

    /**
     * Percentual de redução de aliquota em compra governamental
     */
    public ?string $pRedutor = null;

    /**
     * Grupo de valores brutos referentes ao IBS/CBS
     */
    public \NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCValoresIBSCBS $valores;

    /**
     * Grupo de Totalizadores
     */
    public \NFSe\Dto\V1_0_1\NFSe\InfNFSe\RTCIBSCBS\RTCTotalCIBS $totCIBS;

}
