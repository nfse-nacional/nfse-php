<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class InfEventoData extends Dto
{
    #[MapFrom('@attributes.Id')]
    public ?string $id = null;

    #[MapFrom('verAplic')]
    public ?string $versaoAplicativo = null;

    #[MapFrom('ambGer')]
    public ?int $ambiente = null;

    #[MapFrom('nSeqEvento')]
    public ?int $numeroSequencialEvento = null;

    #[MapFrom('dhProc')]
    public ?string $dataHoraProcessamento = null;

    #[MapFrom('nDFSe')]
    public ?string $numeroDfse = null;

    #[MapFrom('pedRegEvento')]
    public ?PedRegEventoData $pedRegEvento = null;
}
