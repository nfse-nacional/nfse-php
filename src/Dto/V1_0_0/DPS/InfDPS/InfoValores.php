<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS;

use NFSe\Dto\Attributes\MapFrom;

/**
 * InfoValores
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfoValores
 */
class InfoValores 
{
    /**
     * Grupo de informações relativas aos valores do serviço prestado
     */
    public \NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\VServPrest $vServPrest;

    /**
     * Grupo de informações relativas aos descontos condicionados e incondicionados
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\VDescCondIncond $vDescCondIncond = null;

    /**
     * Grupo de informações relativas ao valores para dedução/redução do valor da base de cálculo
     * (valor do serviço)
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoDedRed $vDedRed = null;

    /**
     * Grupo de informações relacionados aos tributos relacionados ao serviço prestado
     */
    public \NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoTributacao $trib;

}
