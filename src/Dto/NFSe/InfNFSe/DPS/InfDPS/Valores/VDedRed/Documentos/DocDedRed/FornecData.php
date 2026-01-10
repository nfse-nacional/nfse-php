<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed;

class FornecData 
{
    /**
     * CNPJ informado na DPS é inválido (verificar DV).
     */
    public ?string $CNPJ = null;

    /**
     * CPF informado na DPS é inválido (verificar DV).
     */
    public ?string $CPF = null;

    /**
     * -
     */
    public ?string $NIF = null;

    /**
     * 
     */
    public ?string $cNaoNIF = null;

    /**
     * -
     */
    public ?string $CAEPF = null;

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
    public ?string $fone = null;

    /**
     * -
     */
    public ?string $email = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\EndData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\EndData $end = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\EndFornecData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\EndFornecData $endFornec = null;

}
