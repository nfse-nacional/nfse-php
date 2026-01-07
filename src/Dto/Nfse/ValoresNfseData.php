<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class ValoresNfseData extends Dto
{
    /**
     * Valor calculado de Dedução/Redução.
     */
    #[MapFrom('vCalcDR')]
    public ?float $valorCalculadoDeducaoReducao = null;

    /**
     * Tipo de Benefício Municipal.
     */
    #[MapFrom('tpBM')]
    public ?int $tipoBeneficioMunicipal = null;

    /**
     * Valor calculado de Benefício Municipal.
     */
    #[MapFrom('vCalcBM')]
    public ?float $valorCalculadoBeneficioMunicipal = null;

    /**
     * Valor da Base de Cálculo.
     */
    #[MapFrom('vBC')]
    public ?float $baseCalculo = null;

    /**
     * Alíquota Aplicada.
     */
    #[MapFrom('pAliqAplic')]
    public ?float $aliquotaAplicada = null;

    /**
     * Valor do ISSQN.
     */
    #[MapFrom('vISSQN')]
    public ?float $valorIssqn = null;

    /**
     * Valor Total Retido.
     */
    #[MapFrom('vTotalRet')]
    public ?float $valorTotalRetido = null;

    /**
     * Valor Líquido da NFS-e.
     */
    #[MapFrom('vLiq')]
    public ?float $valorLiquido = null;
}
