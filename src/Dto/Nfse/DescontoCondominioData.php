<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\TipoDescontoCondominio;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DescontoCondominioData extends Dto
{
    /**
     * Tipo do desconto.
     */
    #[MapFrom('tpDesconto'), CastWith(EnumCaster::class, enumType: TipoDescontoCondominio::class)]
    public ?TipoDescontoCondominio $tipoDesconto = null;

    /**
     * Valor do desconto.
     */
    #[MapFrom('vDesconto')]
    public ?float $valorDesconto = null;

    /**
     * Descrição do desconto aplicado pelo condomínio.
     */
    #[MapFrom('xTpDesconto')]
    public ?string $descricaoTipoDesconto = null;
}
