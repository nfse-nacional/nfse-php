<?php

namespace Nfse\Http\Dto;


class ConsultaNfseResponse 
{
    public ?int $tipoAmbiente = null;

    public ?string $versaoAplicativo = null;

    public ?string $dataHoraProcessamento = null;

    public ?string $chaveAcesso = null;

    public ?string $nfseXmlGZipB64 = null;
}
