<?php

namespace NFSe\Dto\V1_0_0\DPS\InfDPS\InfoValores\InfoTributacao\TribNacional;

use NFSe\Dto\Attributes\MapFrom;

/**
 * TribOutrosPisCofins
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCTribOutrosPisCofins
 */
class TribOutrosPisCofins 
{
    /**
     * Código de Situação Tributária do PIS/COFINS (CST):
     * 00 - Nenhum;
     * 01 - Operação Tributável com Alíquota Básica;
     * 02 - Operação Tributável com Alíquota Diferenciada;
     * 03 - Operação Tributável com Alíquota por Unidade de Medida de Produto;
     * 04 - Operação Tributável monofásica - Revenda a Alíquota Zero;
     * 05 - Operação Tributável por Substituição Tributária;
     * 06 - Operação Tributável a Alíquota Zero;
     * 07 - Operação Tributável da Contribuição;
     * 08 - Operação sem Incidência da Contribuição;
     * 09 - Operação com Suspensão da Contribuição;
     */
    public \Nfse\Enums\V1_0_0\TSTipoCST $CST;

    /**
     * Valor da Base de Cálculo do PIS/COFINS (R$).
     */
    public ?string $vBCPisCofins = null;

    /**
     * Valor da Alíquota do PIS (%).
     */
    public ?string $pAliqPis = null;

    /**
     * Valor da Alíquota da COFINS (%).
     */
    public ?string $pAliqCofins = null;

    /**
     * Valor monetário do PIS (R$).
     */
    public ?string $vPis = null;

    /**
     * Valor monetário do COFINS (R$).
     */
    public ?string $vCofins = null;

    /**
     * Tipo de retencao do Pis/Cofins:
     * 1 - Retido;
     * 2 - Não Retido;
     */
    public ?\Nfse\Enums\V1_0_0\TSTipoRetPISCofins $tpRetPisCofins = null;

}
