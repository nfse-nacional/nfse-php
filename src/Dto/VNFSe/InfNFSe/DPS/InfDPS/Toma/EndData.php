<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma;

class EndData 
{
    /**
     * -
     */
    public ?string $xLgr = null;

    /**
     * -
     */
    public ?string $nro = null;

    /**
     * -
     */
    public ?string $xCpl = null;

    /**
     * -
     */
    public ?string $xBairro = null;

    /**
     * Se o tpEmit é igual a 1 e o tomador foi identificado pelo CNPJ, então o grupo de informações de
     * endereço nacional do tomador do serviço deve ser informado obrigatoriamente.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\End\EndNacData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\End\EndNacData $endNac = null;

    /**
     * Se o NIF do tomador de serviço foi informado e o emitente da DPS for identificado por CNPJ, então
     * o grupo de informações de endereço no exterior do tomador do serviço deve ser informado
     * obrigatoriamente.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\End\EndExtData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\End\EndExtData $endExt = null;

}
