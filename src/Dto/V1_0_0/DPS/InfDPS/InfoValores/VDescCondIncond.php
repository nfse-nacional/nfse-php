<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores;

use NFSe\Dto\Attributes\MapFrom;

/**
 * VDescCondIncond
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCVDescCondIncond
 */
class VDescCondIncond 
{
    /**
     * Valor monetário do desconto incondicionado (R$)
     */
    public ?string $vDescIncond = null;

    /**
     * Valor monetário do desconto condicionado (R$)
     */
    public ?string $vDescCond = null;

}
