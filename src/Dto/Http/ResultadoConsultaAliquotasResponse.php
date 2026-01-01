<?php

namespace Nfse\Dto\Http;

class ResultadoConsultaAliquotasResponse
{
    /**
     * @param array<string, AliquotaDto[]> $aliquotas
     */
    public function __construct(
        public ?string $mensagem = null,
        public array $aliquotas = [],
    ) {}
}
