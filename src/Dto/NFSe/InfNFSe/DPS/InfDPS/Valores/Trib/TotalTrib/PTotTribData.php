<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTrib;

class PTotTribData 
{
    /**
     * Se a alíquota for informada, então deve ser igual ou maior que 0 e menor ou igual a 100%.
     */
    public ?string $pTotTribFed = null;

    /**
     * Se a alíquota for informada, então deve ser igual ou maior que 0 e menor ou igual a 100%.
     */
    public ?string $pTotTribEst = null;

    /**
     * Se a alíquota for informada, então deve ser igual ou maior que 0 e menor ou igual a 100%.
     */
    public ?string $pTotTribMun = null;

}
