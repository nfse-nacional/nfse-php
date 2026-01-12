<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\InfoValores\InfoTributacao;

use NFSe\Dto\Attributes\MapFrom;

/**
 * TribTotal
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCTribTotal
 */
class TribTotal 
{
    /**
     * Valor monetário total aproximado dos tributos, em conformidade com o artigo 1o da Lei no
     * 12.741/2012
     */
    public \NFSe\Dto\V1_0_1\DPS\InfDPS\InfoValores\InfoTributacao\TribTotal\TribTotalMonet $vTotTrib;

    /**
     * Valor percentual total aproximado dos tributos, em conformidade com o artigo 1o da Lei no
     * 12.741/2012
     */
    public \NFSe\Dto\V1_0_1\DPS\InfDPS\InfoValores\InfoTributacao\TribTotal\TribTotalPercent $pTotTrib;

    /**
     * Indicador de informação de valor total de tributos. Possui valor fixo igual a zero (indTotTrib=0).
     * Não informar nenhum valor estimado para os Tributos (Decreto 8.264/2014).
     * 0 - Não;
     */
    public \Nfse\Enums\V1_0_1\TSTipoIndTotTrib $indTotTrib;

    /**
     * Valor percentual aproximado do total dos tributos da alíquota do Simples Nacional (%)
     */
    public string $pTotTribSN;

}
