<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\InfoPrestador;

use NFSe\Dto\Attributes\MapFrom;

/**
 * Endereco
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCEndereco
 */
class Endereco 
{
    /**
     * Grupo de informações específicas de endereço nacional
     */
    public \NFSe\Dto\V1_0_0\DPS\InfDPS\InfoPrestador\Endereco\EnderNac $endNac;

    /**
     * Grupo de informações específicas de endereço no exterior
     */
    public \NFSe\Dto\V1_0_0\DPS\InfDPS\InfoPrestador\Endereco\EnderExt $endExt;

    /**
     * Tipo e nome do logradouro da localização do imóvel
     */
    public string $xLgr;

    /**
     * Número do imóvel
     */
    public string $nro;

    /**
     * Complemento do endereço
     */
    public ?string $xCpl = null;

    /**
     * Bairro
     */
    public string $xBairro;

}
