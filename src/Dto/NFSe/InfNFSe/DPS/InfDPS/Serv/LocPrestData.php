<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Serv;

class LocPrestData 
{
    /**
     * Se informado, o código do município deve existir na tabela de municípios do IBGE ou possuir a
     * codificação 0000000, que representa "Águas Marítimas".
     */
    public ?string $cLocPrestacao = null;

    /**
     * Se informado, o código do país deve existir na tabela de país ISO2 e ser diferente de Brasil
     * (BR).
     */
    public ?string $cPaisPrestacao = null;

}
