<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\TipoCobrancaCondominio;
use Nfse\Support\DTO\ArrayCaster;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class CobrancaCondominioData extends Dto
{
    /**
     * Tipo da cobrança.
     */
    #[MapFrom('tpCobranca'), CastWith(EnumCaster::class, enumType: TipoCobrancaCondominio::class)]
    public ?TipoCobrancaCondominio $tipoCobranca = null;

    /**
     * Descrição do tipo da cobrança. Somente quando o tipo é 99.
     */
    #[MapFrom('xTpCobranca')]
    public ?string $descricaoTipoCobranca = null;

    /**
     * Valor da cobrança.
     */
    #[MapFrom('vCobranca')]
    public ?float $valorCobranca = null;

    /**
     * Detalhamento da cobrança.
     *
     * @var DetalhamentoCobrancaCondominioData[]|null
     */
    #[MapFrom('gDetCobranca'), CastWith(ArrayCaster::class, itemType: DetalhamentoCobrancaCondominioData::class)]
    public ?array $detalhamentos = null;
}
