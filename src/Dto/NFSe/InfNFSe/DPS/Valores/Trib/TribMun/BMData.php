<?php

namespace Nfse\Dto\NFSe\InfNFSe\DPS\Valores\Trib\TribMun;

class BMData 
{
    /**
     * O código de identificação do Benefício Municipal não existente para municipio de incidência do
     * ISSQN.
     */
    public ?string $nBM = null;

    /**
     * Somente é permitido informar vRedBCBM quando o código de identificação do Benefício Municipal
     * (nBM) for um benefício do tipo Redução de Base de Cálculo por Valor Monetário.
     */
    public ?string $vRedBCBM = null;

    /**
     * Somente é permitido informar pRedBCBM quando o código de identificação do Benefício Municipal
     * (nBM) for um benefício do tipo Redução de Base de Cálculo por percentual.
     */
    public ?string $pRedBCBM = null;

}
