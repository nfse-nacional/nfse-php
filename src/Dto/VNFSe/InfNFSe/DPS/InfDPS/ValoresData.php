<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS;

class ValoresData 
{
    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VServPrestData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VServPrestData $vServPrest = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDescCondIncondData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDescCondIncondData $vDescCondIncond = null;

    /**
     * Não é permitido o preenchimento dos campos do grupo de informações relativas à
     * Dedução/Redução para o ISSQN quando ocorrer "Imunidade" (tribISSQN = 2), "Exportação de
     * serviço" (tribISSQN = 3) ou "Não incidência" (tribISSQN = 4), ou seja, tpRetISSQN tem que ser
     * igual a 1 (tpRetISSQN = 1).
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRedData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRedData $vDedRed = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\TribData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\TribData $trib = null;

}
