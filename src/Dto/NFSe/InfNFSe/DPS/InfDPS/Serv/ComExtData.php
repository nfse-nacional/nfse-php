<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv;

class ComExtData 
{
    /**
     * Se o valor do campo mdPrestacao for 0, então a DPS deve ser rejeitada.
     */
    public ?string $mdPrestacao = null;

    /**
     * -
     */
    public ?string $vincPrest = null;

    /**
     * -
     */
    public ?string $tpMoeda = null;

    /**
     * -
     */
    public ?string $vServMoeda = null;

    /**
     * Se o valor do campo mecAFComexP for 0, então a DPS deve ser rejeitada.
     */
    public ?string $mecAFComexP = null;

    /**
     * Se o valor do campo mecAFComexT for 0, então a DPS deve ser rejeitada.
     */
    public ?string $mecAFComexT = null;

    /**
     * Se o valor do campo movTempBens for 0, então a DPS deve ser rejeitada.
     */
    public ?string $movTempBens = null;

    /**
     * Se movTempBens = 2, então o preenchimento de nDI é obrigatório
     */
    public ?string $nDI = null;

    /**
     * 
     */
    public ?string $nRE = null;

    /**
     * -
     */
    public ?string $mdic = null;

}
