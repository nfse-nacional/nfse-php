<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;

class ConsultaDpsResponse extends Dto
{
    public ?int $tipoAmbiente = null;

    public ?string $versaoAplicativo = null;

    public ?string $dataHoraProcessamento = null;

    public ?string $idDps = null;

    public ?string $chaveAcesso = null;
}
