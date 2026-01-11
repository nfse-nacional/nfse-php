<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos;

class DocDedRedData 
{
    /**
     * Chave de NFS-e inválida.
     * 
     * 1 - Verificar DV da chave de NFS-e informada neste campo desta DPS;
     */
    public ?string $chNFSe = null;

    /**
     * Chave de NF-e inválida.
     * 
     * 1 - Verificar DV da chave de NF-e informada neste campo desta DPS;
     */
    public ?string $chNFe = null;

    /**
     * 
     */
    public ?string $nDocFisc = null;

    /**
     * -
     */
    public ?string $nDoc = null;

    /**
     * -
     */
    public ?string $tpDedRed = null;

    /**
     * O campo de descrição deve ser informado no caso de tpDedRed igual a 99 – Outras deduções.
     */
    public ?string $xDescOutDed = null;

    /**
     * A data de emissão do documento informado na DPS não pode ser posterior à data de competência da
     * DPS.
     */
    public ?string $dEmiDoc = null;

    /**
     * -
     */
    public ?string $vDedutivelRedutivel = null;

    /**
     * O valor de dedução/redução não pode ser superior ao valor dedutível/redutível.
     */
    public ?string $vDeducaoReducao = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\NFSeMunData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\NFSeMunData $NFSeMun = null;

    /**
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\NFNFSData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\NFNFSData $NFNFS = null;

    /**
     * O grupo de informações para o fornecedor deve ser informado obrigatoriamente para todos os tipos
     * de documentos informados, exceto para os tipos de documentos NFS-e e NF-e padrões nacionais.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\FornecData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\FornecData $fornec = null;

}
