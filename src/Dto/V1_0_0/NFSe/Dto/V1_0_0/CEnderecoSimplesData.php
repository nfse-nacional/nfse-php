<?php

namespace NFSe\Dto\V1_0_0;

/**
 * CEnderecoSimplesData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCEnderecoSimples
 */
class CEnderecoSimplesData 
{
    /**
     * Número do CEP
     */
    public string $CEP;

    /**
     * Grupo de informações específicas de endereço no exterior
     */
    public \NFSe\Dto\V1_0_0\CEnderExtSimplesData $endExt;

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
