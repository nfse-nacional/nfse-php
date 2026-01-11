<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS;

/**
 * CEnderecoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCEndereco
 */
class CEnderecoData 
{
    /**
     * Grupo de informações específicas de endereço nacional
     */
    public \NFSe\Dto\V1_0_0\CEnderNacData $endNac;

    /**
     * Grupo de informações específicas de endereço no exterior
     */
    public \NFSe\Dto\V1_0_0\CEnderExtData $endExt;

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
