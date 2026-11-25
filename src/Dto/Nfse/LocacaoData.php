<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class LocacaoData extends Dto
{
    /**
     * Percentual de copropriedade. Com um só locador, informar 100.
     */
    #[MapFrom('pCopropriedade')]
    public ?float $percentualCopropriedade = null;

    /**
     * Valor total da operação com bem imóvel (R$).
     */
    #[MapFrom('vTotOper')]
    public ?float $valorTotalOperacao = null;

    /**
     * Valor total do desconto incondicionado da operação (R$).
     */
    #[MapFrom('vDescIncondTot')]
    public ?float $valorDescontoIncondicionadoTotal = null;

    /**
     * Valor total do desconto condicionado da operação (R$).
     */
    #[MapFrom('vDescCondTot')]
    public ?float $valorDescontoCondicionadoTotal = null;

    /**
     * Data de vencimento original do aluguel (AAAA-MM-DD).
     */
    #[MapFrom('dVencOrig')]
    public ?string $dataVencimentoOriginal = null;
}
