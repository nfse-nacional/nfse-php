<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Prest\End;

class EndNacData 
{
    /**
     * O código do município para o endereço do prestador do serviço não existe, conforme TAB.MUN_IBGE
     * do ANEXO_A-MUNICIPIO_IBGE-PAISES_ISO2-SNNFSe.
     */
    public ?string $cMun = null;

    /**
     * O CEP informado deve existir e pertencer ao município correspondente ao código do município
     * informado para o endereço do prestador do serviço.
     */
    public ?string $CEP = null;

}
