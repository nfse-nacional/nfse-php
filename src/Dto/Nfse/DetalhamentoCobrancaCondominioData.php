<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\TipoDetalhamentoCobrancaCondominio;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DetalhamentoCobrancaCondominioData extends Dto
{
    /**
     * Tipo de detalhamento da cobrança.
     */
    #[MapFrom('tpDetCobranca'), CastWith(EnumCaster::class, enumType: TipoDetalhamentoCobrancaCondominio::class)]
    public ?TipoDetalhamentoCobrancaCondominio $tipoDetalhamento = null;

    /**
     * Descrição do detalhamento. Somente quando o tipo é 999.
     */
    #[MapFrom('xTpDetCobranca')]
    public ?string $descricaoTipoDetalhamento = null;

    /**
     * Valor detalhado da cobrança.
     */
    #[MapFrom('vDetCobranca')]
    public ?float $valorDetalhamento = null;
}
