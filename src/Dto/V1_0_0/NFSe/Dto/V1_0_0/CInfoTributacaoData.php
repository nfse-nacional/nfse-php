<?php

namespace NFSe\Dto\V1_0_0;

/**
 * CInfoTributacaoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfoTributacao
 */
class CInfoTributacaoData 
{
    /**
     * Grupo de informações relacionados ao Imposto Sobre Serviços de Qualquer Natureza - ISSQN
     */
    public \NFSe\Dto\V1_0_0\CTribMunicipalData $tribMun;

    /**
     * Grupo de informações de outros tributos relacionados ao serviço prestado
     */
    public ?\NFSe\Dto\V1_0_0\CTribNacionalData $tribNac = null;

    /**
     * Grupo de informações para totais aproximados dos tributos relacionados ao serviço prestado
     */
    public \NFSe\Dto\V1_0_0\CTribTotalData $totTrib;

}
