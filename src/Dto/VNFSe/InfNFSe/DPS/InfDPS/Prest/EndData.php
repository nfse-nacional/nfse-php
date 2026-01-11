<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest;

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
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\End\EndNacData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\End\EndNacData $endNac = null;

    /**
     * Se o NIF do prestador de serviço foi informado e o emitente da DPS, tomador ou intermedirio (tpEmit
     * = 2 ou 3), for identificado por CNPJ, então o grupo de informações de endereço no exterior do
     * prestador do serviço deve ser informado obrigatoriamente.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\End\EndExtData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\End\EndExtData $endExt = null;

}
