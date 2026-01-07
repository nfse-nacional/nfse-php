<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;

class RegistroEventoResponse extends Dto
{
    public ?int $tipoAmbiente = null;

    public ?string $versaoAplicativo = null;

    public ?string $dataHoraProcessamento = null;

    public ?string $eventoXmlGZipB64 = null;
}
