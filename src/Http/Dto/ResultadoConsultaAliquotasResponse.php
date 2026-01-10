<?php

namespace Nfse\Http\Dto;


class ResultadoConsultaAliquotasResponse 
{
    public ?string $mensagem = null;

    /**
     * @var AliquotaDto[]
     */
    public array $aliquotas = [];
}
