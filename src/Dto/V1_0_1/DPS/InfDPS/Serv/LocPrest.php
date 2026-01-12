<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\Serv;

use NFSe\Dto\Attributes\MapFrom;

/**
 * LocPrest
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCLocPrest
 */
class LocPrest 
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
