<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\Obra;

class EndData 
{
    /**
     * O CEP a ser informa para endereço da obra deve pertencer ao município que foi informado como local
     * da prestação do serviço.
     */
    public ?string $CEP = null;

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
     * Se o pais local da prestação do serviço de obra foi informado (cPaisPrestacao foi informado),
     * então o grupo de informações de endereço no exterior deve ser informado.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\Obra\End\EndExtData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\Obra\End\EndExtData $endExt = null;

}
