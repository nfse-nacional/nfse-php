<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores;

class VDescCondIncondData 
{
    /**
     * Verificar o valor do desconto incondicionado informado na DPS que deve ser menor que o valor do
     * serviço e maior que zero.
     */
    public ?string $vDescIncond = null;

    /**
     * Verificar se o valor do desconto condicionado informado na DPS deve ser menor que o valor do
     * serviço e maior que zero.
     */
    public ?string $vDescCond = null;

}
