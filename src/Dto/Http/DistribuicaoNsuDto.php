<?php

namespace Nfse\Dto\Http;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class DistribuicaoNsuDto extends Dto
{
    #[MapFrom('NSU')]
    public ?int $nsu = null;

    #[MapFrom('chAcesso')]
    public ?string $chaveAcesso = null;

    #[MapFrom('dfeXmlGZipB64')]
    public ?string $dfeXmlGZipB64 = null;
}
