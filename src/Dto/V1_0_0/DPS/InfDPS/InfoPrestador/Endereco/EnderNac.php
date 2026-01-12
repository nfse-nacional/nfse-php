<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\InfoPrestador\Endereco;

use NFSe\Dto\Attributes\MapFrom;

/**
 * EnderNac
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCEnderNac
 */
class EnderNac 
{
    /**
     * Código do município, conforme Tabela do IBGE
     */
    public string $cMun;

    /**
     * Número do CEP
     */
    public string $CEP;

}
