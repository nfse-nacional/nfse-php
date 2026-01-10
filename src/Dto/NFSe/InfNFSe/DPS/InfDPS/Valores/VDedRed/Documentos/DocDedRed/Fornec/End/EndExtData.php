<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\End;

class EndExtData 
{
    /**
     * O código de país informado para o endereço no exterior do fornecedor deve existir e ser diferente
     * de Brasil (BR), conforme a tabela ISO2.
     */
    public ?string $cPais = null;

    /**
     * -
     */
    public ?string $cEndPost = null;

    /**
     * -
     */
    public ?string $xCidade = null;

    /**
     * -
     */
    public ?string $xEstProvReg = null;

}
