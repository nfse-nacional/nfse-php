<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Toma\End;

class EndNacData 
{
    /**
     * O código do município informado para o endereço do tomador do serviço não existe, conforme
     * tabela de municípios do IBGE.
     */
    public ?string $cMun = null;

    /**
     * O CEP informado deve existir e pertencer ao município correspondente ao código do município
     * informado para o endereço do tomador do serviço.
     */
    public ?string $CEP = null;

}
