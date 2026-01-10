<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm;

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
     * Se o tpEmit é igual a 1 e o intermediário foi identificado pelo CNPJ, então o grupo de
     * informações de endereço nacional do intermediário do serviço deve ser informado
     * obrigatoriamente.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\End\EndNacData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\End\EndNacData $endNac = null;

    /**
     * Se o NIF do intermediário de serviço foi informado e o emitente da DPS for identificado por CNPJ,
     * então o grupo de informações de endereço no exterior do tomador do serviço deve ser informado
     * obrigatoriamente.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\End\EndExtData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Interm\End\EndExtData $endExt = null;

}
