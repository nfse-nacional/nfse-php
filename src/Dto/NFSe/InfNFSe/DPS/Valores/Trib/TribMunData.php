<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\Valores\Trib;

class TribMunData 
{
    /**
     * Não é permitido informar BM quando o serviço prestado for imune, exportação de serviço ou não
     * incidência do ISSQN sobre o serviço prestado, ou seja, o campo referente à tributação do ISSQN
     * (tribISSQN) é igual a "2 - Imunidade, "3 - Exportação de Serviço" ou "4 - Não Incidência",
     * (tribISSQN = 2, 3 ou 4).
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\Valores\Trib\TribMun\BMData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\Valores\Trib\TribMun\BMData $BM = null;

}
