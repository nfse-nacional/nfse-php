<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

class TribFedData 
{
    /**
     * -
     */
    public ?string $pisconfins = null;

    /**
     * Se o valor do tributo CP for informado, então deve ser maior que zero e menor que o valor do
     * serviço informado na DPS.
     */
    public ?string $vRetCP = null;

    /**
     * Se o valor do tributo IRRF for informado, então deve ser maior que zero e menor que o valor do
     * serviço informado na DPS.
     */
    public ?string $vRetIRRF = null;

    /**
     * Se o valor do tributo CSLL for informado, então deve ser maior que zero e menor que o valor do
     * serviço informado na DPS.
     */
    public ?string $vRetCSLL = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFed\PiscofinsData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFed\PiscofinsData $piscofins = null;

}
