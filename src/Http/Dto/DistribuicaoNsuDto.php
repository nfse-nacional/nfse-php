<?php

namespace Nfse\Http\Dto;

use CuyZ\Valinor\Mapper\Source\Source;

class DistribuicaoNsuDto 
{
    #[Source('NSU')]
    public ?int $nsu = null;

    #[Source('chAcesso')]
    public ?string $chaveAcesso = null;

    #[Source('dfeXmlGZipB64')]
    public ?string $dfeXmlGZipB64 = null;
}
