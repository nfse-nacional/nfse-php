<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoTributacao;

use NFSe\Dto\Attributes\MapFrom;

/**
 * TribNacional
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCTribNacional
 */
class TribNacional 
{
    /**
     * Grupo de informações dos tributos PIS/COFINS
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoTributacao\TribNacional\TribOutrosPisCofins $piscofins = null;

    /**
     * Valor monetário do CP(R$).
     */
    public ?string $vRetCP = null;

    /**
     * Valor monetário do IRRF (R$).
     */
    public ?string $vRetIRRF = null;

    /**
     * Valor monetário do CSLL (R$).
     */
    public ?string $vRetCSLL = null;

}
