<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\Emitente;

use NFSe\Dto\Attributes\MapFrom;

/**
 * EnderecoEmitente
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCEnderecoEmitente
 */
class EnderecoEmitente 
{
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
     * Código do município, conforme Tabela do IBGE
     */
    public string $cMun;

    /**
     * Sigla da unidade da federação do município do endereço do emitente.
     */
    public \Nfse\Enums\V1_0_1\TSUF $UF;

    /**
     * Número do CEP
     */
    public string $CEP;

}
