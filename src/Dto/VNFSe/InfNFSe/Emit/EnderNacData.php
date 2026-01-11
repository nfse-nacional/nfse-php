<?php

namespace Nfse\Dto\NFSe\InfNFSe\Emit;

class EnderNacData 
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
     * Verificar se o código do município do emitente da NFS-e corresponde ao código do município
     * emissor (cLocEmi) informado na NFS-e.
     */
    public ?string $cMun = null;

    /**
     * -
     */
    public ?string $UF = null;

    /**
     * -
     */
    public ?string $CEP = null;

}
