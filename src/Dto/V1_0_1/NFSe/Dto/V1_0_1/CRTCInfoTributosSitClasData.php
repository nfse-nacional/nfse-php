<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCInfoTributosSitClasData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCInfoTributosSitClas
 */
class CRTCInfoTributosSitClasData 
{
    /**
     * Código de Situação Tributária do IBS e da CBS
     */
    public string $CST;

    /**
     * Código de Classificação Tributária do IBS e da CBS
     */
    public string $cClassTrib;

    /**
     * Código e Classificação do Crédito Presumido: IBS e CBS
     */
    public ?string $cCredPres = null;

    /**
     * Grupo de informações da Tributação Regular
     */
    public ?\NFSe\Dto\V1_0_1\CRTCInfoTributosTribRegularData $gTribRegular = null;

    /**
     * Grupo de informações relacionadas ao diferimento para IBS e CBS
     */
    public ?\NFSe\Dto\V1_0_1\CRTCInfoTributosDifData $gDif = null;

}
