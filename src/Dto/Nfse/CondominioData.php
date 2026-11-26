<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Support\DTO\ArrayCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class CondominioData extends Dto
{
    /**
     * Data de vencimento original das taxas condominiais.
     */
    #[MapFrom('dVencOrig')]
    public ?string $dataVencimentoOriginal = null;

    /**
     * Cobranças das taxas e demais valores condominiais.
     *
     * @var CobrancaCondominioData[]|null
     */
    #[MapFrom('gCobranca'), CastWith(ArrayCaster::class, itemType: CobrancaCondominioData::class)]
    public ?array $cobrancas = null;

    /**
     * Descontos concedidos nas taxas condominiais.
     *
     * @var DescontoCondominioData[]|null
     */
    #[MapFrom('gDesconto'), CastWith(ArrayCaster::class, itemType: DescontoCondominioData::class)]
    public ?array $descontos = null;
}
