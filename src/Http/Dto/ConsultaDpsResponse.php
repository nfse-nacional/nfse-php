<?php

namespace Nfse\Http\Dto;

use Spatie\LaravelData\Data;

class ConsultaDpsResponse extends Data
{
    public function __construct(
        public ?int $tipoAmbiente = null,
        public ?string $versaoAplicativo = null,
        public ?string $dataHoraProcessamento = null,
        public ?string $idDps = null,
        public ?string $chaveAcesso = null,
    ) {}
}
