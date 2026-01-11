<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Serv;

/**
 * CLocPrestData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCLocPrest
 */
class CLocPrestData 
{
    /**
     * Código do município onde o serviço foi prestado (tabela do IBGE)
     */
    public ?string $cLocPrestacao = null;

    /**
     * Código do país onde o serviço foi prestado (Tabela de Países ISO)
     */
    public ?string $cPaisPrestacao = null;

    /**
     * Opção para que o emitente informe onde ocorreu o consumo do serviço prestado.
     * 0 - Consumo do serviço prestado ocorrido no município do local da prestação;
     * 1 - Consumo do serviço prestado ocorrido ocorrido no exterior ;
     */
    public ?string $opConsumServ = null;

}
