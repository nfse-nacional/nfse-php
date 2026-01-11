<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe;

/**
 * CEmitenteData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCEmitente
 */
class CEmitenteData 
{
    /**
     * Número do CNPJ do emitente da NFS-e.
     */
    public string $CNPJ;

    /**
     * Número do CPF do emitente da NFS-e.
     */
    public string $CPF;

    /**
     * Número da inscrição municipal
     */
    public ?string $IM = null;

    /**
     * Nome / Razão Social do emitente.
     */
    public string $xNome;

    /**
     * Nome / Fantasia do emitente.
     */
    public ?string $xFant = null;

    /**
     * Grupo de informações do endereço nacional do Emitente da NFS-e
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\Emit\CEnderecoEmitenteData $enderNac;

    /**
     * Número do telefone do emitente.
     * (Preencher com o Código DDD + número do telefone.
     * Nas operações com exterior é permitido informar o código do país + código da
     * localidade + número do telefone)
     */
    public ?string $fone = null;

    /**
     * E-mail do emitente.
     */
    public ?string $email = null;

}
