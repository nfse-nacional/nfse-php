<?php

namespace Nfse\Dto\Http;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class AliquotaDto extends Dto
{
    #[MapFrom('incid')]
    public ?string $incidencia = null;

    #[MapFrom('aliq')]
    public ?float $aliquota = null;

    #[MapFrom('tpRet')]
    public ?int $tipoRetencao = null;
}
