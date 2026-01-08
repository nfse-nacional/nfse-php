<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class PedRegEventoData extends Dto
{
    #[MapFrom('infPedReg')]
    public ?InfPedRegData $infPedReg = null;

    #[MapFrom('versao')]
    public string $versao = '1.01';
}
