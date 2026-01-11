<?php

namespace NFSe\Dto\V1_0_0;

/**
 * CTribNacionalData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCTribNacional
 */
class CTribNacionalData 
{
    /**
     * Grupo de informações dos tributos PIS/COFINS
     */
    public ?\NFSe\Dto\V1_0_0\CTribOutrosPisCofinsData $piscofins = null;

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
