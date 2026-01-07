<?php

namespace Nfse\Dto\Nfse;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class PedRegEventoData extends Dto
{
    #[MapFrom('infPedReg')]
    public ?InfPedRegData $infPedReg = null;

    #[MapFrom('versao')]
    public string $versao = '1.01';
}
