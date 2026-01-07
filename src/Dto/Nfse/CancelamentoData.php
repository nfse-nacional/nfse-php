<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class CancelamentoData extends Dto
{
    #[MapFrom('xDesc')]
    public ?string $descricao = null;

    #[MapFrom('cMotivo')]
    public ?string $codigoMotivo = null;

    #[MapFrom('xMotivo')]
    public ?string $motivo = null;
}
