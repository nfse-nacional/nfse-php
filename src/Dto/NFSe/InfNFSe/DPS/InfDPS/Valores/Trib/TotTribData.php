<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

class TotTribData 
{
    /**
     * Se a situação do emitente da DPS perante o Simples Nacional na data de competência informada for
     * MEI, somente um dos 3 grupos abaixo poderá ser informado.
     * vTotTrib ou pTotTrib ou indTotTrib.
     */
    public ?string $indTotTrib = null;

    /**
     * Se a situação do emitente da DPS perante o Simples Nacional na data de competência informada for
     * ME/EPP, somente um dos 3 grupos abaixo poderá ser informado:
     * vTotTrib ou pTotTrib ou pTotTribSN.
     */
    public ?string $pTotTribSN = null;

}
