<?php

namespace Nfse\Dto\NFSe\InfNFSe;

class ValoresData 
{
    /**
     * vCalcDR é o valor monetário calculado a partir do percentual de dedução/redução da BC do
     * ISSQN, informado pelo emitente no campo pDR da DPS. Este percentual é calculado sobre valor do
     * serviço informado na DPS e o resultado calculado é o valor deste campo do leiaute NFS-e
     * ou
     * a soma dos valores de dedução/redução da BC do ISSQN, quando um ou mais documentos são
     * informados nos campos vDeducaoReducao pelo emitente na DPS. Neste caso, o resultado do somatório é
     * o valor deste campo do leiaute NFS-e.
     */
    public ?string $vCalcDR = null;

    /**
     * -
     */
    public ?string $tpBM = null;

    /**
     * vCalcBM é o valor mmonetário calculado a partir do percentual de BM, que foi informada no campo
     * pRedBCBM da DPS. Neste caso o percentual é aplicado sobre o valor do serviço informado na DPS e o
     * resultado calculado é o valor deste campo do leiaute NFS-e.
     */
    public ?string $vCalcBM = null;

    /**
     * O valor da base de cálculo do ISSQN (vBC) é calculado a partir de valores informados na NFS-e:
     * 
     * Valor da BC = Valor do serviço - Desconto incondicionado - Valores monetário de Dedução
     * Redução - Valor monetário de Benerfício Municipal.
     * 
     * vBC = vServ - vDescIncond - (vDR ou vDeducaoReducao ou vCalcDR) - (vRedBCBM ou vCalcBM)
     */
    public ?string $vBC = null;

    /**
     * Não é permitido informar alíquota aplicada superior a 5%.
     */
    public ?string $pAliqAplic = null;

    /**
     * O valor do ISSQN informado na NFS-e (vISSQN) deve ser igual ao produto da base de cálculo pela
     * alíquota aplicada (vBC x pAliqAPlic).
     */
    public ?string $vISSQN = null;

    /**
     * -
     */
    public ?string $vTotalRet = null;

    /**
     * O valor líquido da NFS-e não pode ser inferior a zero.
     * 
     * O valor líquido da NFS-e é calculado a partir de valores que constam na DPS através do seguinte
     * cálculo:
     * 
     * Valor líquido = Valor do serviço - Desconto condicionado - Desconto incondicionado - Valores
     * retidos (CP, IRRF, CSLL) -
     * Valores (ISSQN, PIS, COFINS), se retidos.
     */
    public ?string $vLiq = null;

}
