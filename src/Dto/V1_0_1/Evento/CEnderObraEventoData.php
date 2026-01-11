<?php

namespace NFSe\Dto\V1_0_1\Evento;

/**
 * CEnderObraEventoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCEnderObraEvento
 */
class CEnderObraEventoData 
{
    /**
     * Número do CEP
     */
    public string $CEP;

    /**
     * Grupo de informações específicas de endereço no exterior
     */
    public \NFSe\Dto\V1_0_1\CEnderExtSimplesData $endExt;

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
