<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CRTCTotalCIBSData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCRTCTotalCIBS
 */
class CRTCTotalCIBSData 
{
    /**
     * Valor Total da NF considerando os impostos por fora: IBS e CBS
     * O IBS e a CBS são por fora, por isso seus valores devem ser adicionados ao valor total
     * da NF
     * vTotNF = vLiq (em 2026)
     * vTotNF = vLiq + vCBS + vIBSTot (a partir de 2027)
     */
    public string $vTotNF;

    /**
     * Grupo de valores referentes ao IBS
     */
    public \NFSe\Dto\V1_0_1\CRTCTotalIBSData $gIBS;

    /**
     * Grupo de valores referentes à CBS
     */
    public \NFSe\Dto\V1_0_1\CRTCTotalCBSData $gCBS;

    /**
     * Grupo de informações de tributação regular
     */
    public ?\NFSe\Dto\V1_0_1\CRTCTotalTribRegularData $gTribRegular = null;

    /**
     * Grupo de informações da composição do valor do IBS e da CBS em compras governamentais
     */
    public ?\NFSe\Dto\V1_0_1\CRTCTotalTribCompraGovData $gTribCompraGov = null;

}
