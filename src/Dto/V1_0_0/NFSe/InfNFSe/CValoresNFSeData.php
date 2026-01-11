<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe;

/**
 * CValoresNFSeData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCValoresNFSe
 */
class CValoresNFSeData 
{
    /**
     * Valor monetário (R$) de dedução/redução da base de cálculo (BC) do ISSQN.
     */
    public ?string $vCalcDR = null;

    /**
     * Tipo de Benefício Municipal (BM)
     */
    public ?string $tpBM = null;

    /**
     * Valor monetário (R$) do percentual de redução da base de cálculo (BC) do ISSQN devido a um
     * benefício municipal (BM).
     */
    public ?string $vCalcBM = null;

    /**
     * Valor monetário (R$) do percentual de redução da base de cálculo (BC) do ISSQN devido a um
     * benefício municipal (BM).
     */
    public ?string $vBC = null;

    /**
     * Alíquota aplicada sobre a base de cálculo para apuração do ISSQN.
     */
    public ?string $pAliqAplic = null;

    /**
     * Valor do ISSQN (R$) = Valor da Base de Cálculo x Alíquota ISSQN = vBC x pAliqAplic
     */
    public ?string $vISSQN = null;

    /**
     * Valor total de retenções = Σ(CP + IRRF + CSLL  + ISSQN* +  (PIS + COFINS)**)
     * vTotalRet (R$) = (vRetCP + vRetIRRF + vRetCSLL) + vISSQN* + (vPIS + vCOFINS)**
     */
    public ?string $vTotalRet = null;

    /**
     * Valor líquido = Valor do serviço - Desconto condicionado - Desconto incondicionado - Valores
     * retidos (CP, IRRF, CSLL)* - Valores, se retidos (ISSQN, PIS, COFINS)**
     * Valor Líquido (R$) = vServ – vDescIncond – vDescCond – (vRetCP + vRetIRRF +
     * vRetCSLL)* – (vISSQN - vPIS + vCOFINS)**
     */
    public string $vLiq;

    /**
     * Uso da Administração Tributária Municipal.
     */
    public ?string $xOutInf = null;

}
