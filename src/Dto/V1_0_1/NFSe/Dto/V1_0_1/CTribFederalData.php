<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CTribFederalData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCTribFederal
 */
class CTribFederalData 
{
    /**
     * Grupo de informações dos tributos PIS/COFINS
     */
    public ?\NFSe\Dto\V1_0_1\CTribOutrosPisCofinsData $piscofins = null;

    /**
     * Valor monetário do CP(R$).
     */
    public ?string $vRetCP = null;

    /**
     * Valor monetário do IRRF (R$).
     */
    public ?string $vRetIRRF = null;

    /**
     * Valor monetário do CSLL (R$).
     */
    public ?string $vRetCSLL = null;

}
