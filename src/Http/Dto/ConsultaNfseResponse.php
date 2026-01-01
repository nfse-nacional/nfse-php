<?php

namespace Nfse\Http\Dto;

use Spatie\LaravelData\Data;

class ConsultaNfseResponse extends Data
{
    public function __construct(
        public ?int $tipoAmbiente = null,
        public ?string $versaoAplicativo = null,
        public ?string $dataHoraProcessamento = null,
        public ?string $chaveAcesso = null,
        public ?string $nfseXmlGZipB64 = null,
    ) {}
}
