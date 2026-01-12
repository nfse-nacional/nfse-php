<?php

namespace NFSe\Dto\V1_0_0\Common;

use NFSe\Dto\Attributes\MapFrom;

/**
 * EnderObraEvento
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCEnderObraEvento
 */
class EnderObraEvento 
{
    /**
     * Código de endereçamento postal
     */
    public string $cEndPost;

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

    /**
     * Cidade
     */
    public string $xCidade;

    /**
     * Estado, província ou região
     */
    public string $xEstProvReg;

}
