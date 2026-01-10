<?php

namespace Nfse\Dto\NFSe\InfNFSe;

class EmitData 
{
    /**
     * Verificar se o CNPJ informado para o emitente da NFS-e é válido (verificar DV).
     */
    public ?string $CNPJ = null;

    /**
     * Verificar se o CPF informado para o emitente da NFS-e é válido (verificar DV).
     */
    public ?string $CPF = null;

    /**
     * -
     */
    public ?string $IM = null;

    /**
     * -
     */
    public ?string $xNome = null;

    /**
     * -
     */
    public ?string $xFant = null;

    /**
     * -
     */
    public ?string $fone = null;

    /**
     * -
     */
    public ?string $email = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\Emit\EnderNacData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\Emit\EnderNacData $enderNac = null;

}
