<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec;

class EndData 
{
    /**
     * Se CNPJ ou CPF do fornecedor for informado, então o grupo de informaçoes de endereço nacional do
     * fornecedor deve ser informado obrigatoriamente.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\End\EndNacData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\End\EndNacData $endNac = null;

    /**
     * Se o NIF do fornecedor foi informado, então o grupo de informações de endereço no exterior do
     * fornecedor deve ser informado obrigatoriamente.
     * @var \Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\End\EndExtData|null
     */
    public ?\Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\End\EndExtData $endExt = null;

}
