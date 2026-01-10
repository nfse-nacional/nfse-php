<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv;

class AtvEventoData 
{
    /**
     * -
     */
    public ?string $xNome = null;

    /**
     * -
     */
    public ?string $dtIni = null;

    /**
     * -
     */
    public ?string $dtFim = null;

    /**
     * -
     */
    public ?string $idAtvEvt = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEvento\EndData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEvento\EndData $end = null;

}
