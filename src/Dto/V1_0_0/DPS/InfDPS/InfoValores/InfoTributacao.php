<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores;

use NFSe\Dto\Attributes\MapFrom;

/**
 * InfoTributacao
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfoTributacao
 */
class InfoTributacao 
{
    /**
     * Grupo de informações relacionados ao Imposto Sobre Serviços de Qualquer Natureza - ISSQN
     */
    public \NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoTributacao\TribMunicipal $tribMun;

    /**
     * Grupo de informações de outros tributos relacionados ao serviço prestado
     */
    public ?\NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoTributacao\TribNacional $tribNac = null;

    /**
     * Grupo de informações para totais aproximados dos tributos relacionados ao serviço prestado
     */
    public \NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoTributacao\TribTotal $totTrib;

}
