<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFed;

class PiscofinsData 
{
    /**
     * -
     */
    public ?string $CST = null;

    /**
     * O valor da BC para Pis/Cofins deve ser menor ou igual ao valor do serviço informado na DPS.
     */
    public ?string $vBCPisCofins = null;

    /**
     * Se o valor da base de cálculo do Pis/Cofins (vBCPisCofins) for informado, então a alíquota do Pis
     * deve ser informada.
     */
    public ?string $pAliqPis = null;

    /**
     * 
     */
    public ?string $pAliqCofins = null;

    /**
     * Se o valor da alíquota do Pis (pAliqPis) for informado, então o valor do Pis informado na DPS deve
     * ser igual ao valor da base de cálculo do Pis/Cofins x alíquota do Pis, que foram informados na
     * DPS.
     */
    public ?string $vPis = null;

    /**
     * Se o valor da alíquota do Cofins (pAliqCofins) for informado, então o valor Cofins informado na
     * DPS deve ser igual ao valor da base de cálculo do Pis/Cofins x alíquota do Cofins , que foram
     * informados na DPS.
     */
    public ?string $vCofins = null;

    /**
     * Se CST for diferende de "0 - Nenhum", "8 - Operação sem Incidência da Contribuição", "9 -
     * Operação com Suspensão da Contribuição", o tipo de retenção para Pis/Cofins deve ser
     * informado.
     */
    public ?string $tpRetPisCofins = null;

}
