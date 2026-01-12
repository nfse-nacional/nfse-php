<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\InfoValores\InfoTributacao\TribTotal;

use NFSe\Dto\Attributes\MapFrom;

/**
 * TribTotalMonet
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCTribTotalMonet
 */
class TribTotalMonet 
{
    /**
     * Valor monetário total aproximado dos tributos federais (R$).
     */
    public string $vTotTribFed;

    /**
     * Valor monetário total aproximado dos tributos estaduais (R$).
     */
    public string $vTotTribEst;

    /**
     * Valor monetário total aproximado dos tributos municipais (R$).
     */
    public string $vTotTribMun;

}
