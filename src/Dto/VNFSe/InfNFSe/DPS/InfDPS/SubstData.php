<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS;

class SubstData 
{
    /**
     * Chave de NFS-e a ser substituída é inválida.
     * 
     * 1 - Verificar DV da chave de NFS-e a ser substituída informada nesta DPS;
     * 2 - Verificar a correspondência exata dos campos (Cód.Mun. / Tipo de Inscrição / Inscrição) da
     * chave de NFS-e a ser substituída informada e o id desta DPS;
     */
    public ?string $chSubstda = null;

    /**
     * -
     */
    public ?string $cMotivo = null;

    /**
     * Quando o campo cMotivo = 99, o campo xMotivo deve informado obrigatoriamente.
     */
    public ?string $xMotivo = null;

}
