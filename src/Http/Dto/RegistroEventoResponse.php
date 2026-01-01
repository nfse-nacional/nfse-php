<?php

namespace Nfse\Http\Dto;

use Spatie\LaravelData\Data;

class RegistroEventoResponse extends Data
{
    public function __construct(
        public ?int $tipoAmbiente = null,
        public ?string $versaoAplicativo = null,
        public ?string $dataHoraProcessamento = null,
        public ?string $eventoXmlGZipB64 = null,
    ) {}
}
