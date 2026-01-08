<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class InfEventoData extends Dto
{
    #[MapFrom('verAplic')]
    public ?string $versaoAplicativo = null;

    #[MapFrom('ambGer')]
    public ?int $ambiente = null;

    #[MapFrom('nSeqEvento')]
    public ?int $numeroSequencialEvento = null;

    #[MapFrom('dhProc')]
    public ?string $dataHoraProcessamento = null;

    #[MapFrom('nDFe')]
    public ?string $numeroDfe = null;

    #[MapFrom('pedRegEvento')]
    public ?PedRegEventoData $pedRegEvento = null;
}
