<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\Serv;

/**
 * CLocPrestData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCLocPrest
 */
class CLocPrestData 
{
    /**
     * Código do município onde o serviço foi prestado (tabela do IBGE)
     */
    public string $cLocPrestacao;

    /**
     * Código do país onde o serviço foi prestado (Tabela de Países ISO)
     */
    public string $cPaisPrestacao;

}
