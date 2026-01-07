<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;

class ConsultaNfseResponse extends Dto
{
    public ?int $tipoAmbiente = null;

    public ?string $versaoAplicativo = null;

    public ?string $dataHoraProcessamento = null;

    public ?string $chaveAcesso = null;

    public ?string $nfseXmlGZipB64 = null;
}
