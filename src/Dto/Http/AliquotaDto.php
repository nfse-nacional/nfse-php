<?php

namespace Nfse\Dto\Http;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class AliquotaDto extends Dto
{
    #[MapFrom('Incidencia')]
    public ?string $incidencia = null;

    #[MapFrom('Aliq')]
    public ?float $aliquota = null;

    #[MapFrom('DtIni')]
    public ?string $dataInicio = null;

    #[MapFrom('DtFim')]
    public ?string $dataFim = null;
}
