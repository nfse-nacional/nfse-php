<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEvento;

class EndData 
{
    /**
     * Se o município local da prestação da atividade de evento foi informado (cMunPrestacao foi
     * informado), então o CEP deve ser informado e pertencer a este município.
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
     * Se o pais da prestação da atividade de evento foi informado (cPaisPrestacao foi informado), então
     * o grupo de informações do endereço no exterior deve ser informado.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEvento\End\EndExtData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv\AtvEvento\End\EndExtData $endExt = null;

}
