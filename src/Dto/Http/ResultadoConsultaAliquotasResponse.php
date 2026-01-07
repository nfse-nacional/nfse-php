<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;

class ResultadoConsultaAliquotasResponse extends Dto
{
    public ?string $mensagem = null;

    /**
     * @var AliquotaDto[]
     */
    public array $aliquotas = [];
}
