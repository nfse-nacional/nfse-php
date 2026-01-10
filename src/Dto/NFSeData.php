<?php

namespace Nfse\Dto;

class NFSeData 
{
    /**
     * Prazo de aceitação da versão do leiaute NFS-e ultrapassado.
     */
    public ?string $versao = null;

    /**
     * A assinatura da NFS-e deve ser válida.
     */
    public ?string $Signature = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSeData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSeData $infNFSe = null;

}
