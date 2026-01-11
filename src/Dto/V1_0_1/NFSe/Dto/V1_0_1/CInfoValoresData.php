<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CInfoValoresData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCInfoValores
 */
class CInfoValoresData 
{
    /**
     * Grupo de informações relativas aos valores do serviço prestado
     */
    public \NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\Valores\CVServPrestData $vServPrest;

    /**
     * Grupo de informações relativas aos descontos condicionados e incondicionados
     */
    public ?\NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\Valores\CVDescCondIncondData $vDescCondIncond = null;

    /**
     * Grupo de informações relativas ao valores para dedução/redução do valor da base de cálculo
     * (valor do serviço)
     */
    public ?\NFSe\Dto\V1_0_1\CInfoDedRedData $vDedRed = null;

    /**
     * Grupo de informações relacionados aos tributos relacionados ao serviço prestado
     */
    public \NFSe\Dto\V1_0_1\CInfoTributacaoData $trib;

}
