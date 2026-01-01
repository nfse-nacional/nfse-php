<?php

namespace Nfse\Http\Dto;

use Spatie\LaravelData\Data;

class DistribuicaoNsuDto extends Data
{
    public function __construct(
        public ?int $nsu = null,
        public ?string $chaveAcesso = null,
        public ?string $dfeXmlGZipB64 = null,
    ) {}
}
