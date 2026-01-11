<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe;

/**
 * CValoresNFSeData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCValoresNFSe
 */
class CValoresNFSeData 
{
    /**
     * Valor monetário (R$) de dedução/redução da base de cálculo (BC) do ISSQN.
     */
    public ?string $vCalcDR = null;

    /**
     * Tipo Benefício Municipal (BM):
     * 
     * 1) Isenção;
     * 2) Redução da BC em 'ppBM' %;
     * 3) Redução da BC em R$ 'vInfoBM';
     * 4) Alíquota Diferenciada de 'aliqDifBM' %;
     */
    public ?string $tpBM = null;

    /**
     * Valor monetário (R$) do percentual de redução da base de cálculo (BC) do ISSQN devido a um
     * benefício municipal (BM).
     */
    public ?string $vCalcBM = null;

    /**
     * Valor da Base de Cálculo do ISSQN (R$) = Valor do Serviço - Desconto Incondicionado -
     * Deduções/Reduções - Benefício Municipal
     * vBC = vServ - descIncond - (vDR ou vCalcDR + vCalcReeRepRes) - (vRedBCBM ou VCalcBM)
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

}
