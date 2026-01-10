<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores;

class VDedRedData 
{
    /**
     * Se informado, o valor percentual para dedução/redução deve ser maior 0 e menor ou igual a 100%.
     */
    public ?string $pDR = null;

    /**
     * Código de serviço informado na DPS não permite dedução/redução na base de cálculo do ISSQN
     * por valor monetário, conforme parametrização do município de incidência conveniado ao Sistema
     * Nacional NFS-e.
     */
    public ?string $vDR = null;

    /**
     * Código de serviço informado na DPS não permite dedução/redução na base de cálculo do ISSQN
     * por documentos, conforme parametrização do município de incidência conveniado ao Sistema
     * Nacional NFS-e.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\DocumentosData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\DocumentosData $documentos = null;

}
