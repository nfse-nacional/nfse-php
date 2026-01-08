<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class CancelamentoData extends Dto
{
    #[MapFrom('xDesc')]
    public ?string $descricao = null;

    #[MapFrom('cMotivo')]
    public ?string $codigoMotivo = null;

    #[MapFrom('xMotivo')]
    public ?string $motivo = null;
}
