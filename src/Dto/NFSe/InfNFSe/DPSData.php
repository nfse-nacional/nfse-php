<?php

namespace Nfse\Dto\NFSe\InfNFSe;

class DPSData 
{
    /**
     * Prazo de aceitação da versão do leiaute DPS ultrapassado.
     */
    public ?string $versao = null;

    /**
     * A assinatura da DPS deve ser válida.
     */
    public ?string $Signature = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPSData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPSData $infDPS = null;

}
