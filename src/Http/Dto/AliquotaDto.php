<?php

namespace Nfse\Http\Dto;

use CuyZ\Valinor\Mapper\Source\Source;

class AliquotaDto 
{
    #[Source('Incidencia')]
    public ?string $incidencia = null;

    #[Source('Aliq')]
    public ?float $aliquota = null;

    #[Source('DtIni')]
    public ?string $dataInicio = null;

    #[Source('DtFim')]
    public ?string $dataFim = null;
}
