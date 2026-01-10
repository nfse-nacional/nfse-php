<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores;

class TribData 
{
    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMunData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribMunData $tribMun = null;

    /**
     * Não é permitido o preenchimento das informações relativas aos tributos federais quando o
     * emitente da DPS for identificado por uma pessoa física (CPF).
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFedData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFedData $tribFed = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTribData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTribData $totalTrib = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotTribData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotTribData $totTrib = null;

}
