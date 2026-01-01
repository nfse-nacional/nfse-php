<?php

namespace Nfse\Dto\Http;

class AliquotaDto
{
    public function __construct(
        public ?string $incidencia = null,
        public ?float $aliquota = null,
        public ?string $dataInicio = null,
        public ?string $dataFim = null,
    ) {}
}
