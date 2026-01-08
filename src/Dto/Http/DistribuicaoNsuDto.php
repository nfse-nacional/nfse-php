<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DistribuicaoNsuDto extends Dto
{
    #[MapFrom('NSU')]
    public ?int $nsu = null;

    #[MapFrom('chAcesso')]
    public ?string $chaveAcesso = null;

    #[MapFrom('dfeXmlGZipB64')]
    public ?string $dfeXmlGZipB64 = null;
}
