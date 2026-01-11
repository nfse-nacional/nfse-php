<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe\Emit;

/**
 * CEnderecoEmitenteData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCEnderecoEmitente
 */
class CEnderecoEmitenteData 
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
    public string $UF;

    /**
     * Número do CEP
     */
    public string $CEP;

}
