<?php

namespace Nfse\Http\Dto;


class RegistroEventoResponse 
{
    public ?int $tipoAmbiente = null;

    public ?string $versaoAplicativo = null;

    public ?string $dataHoraProcessamento = null;

    public ?string $eventoXmlGZipB64 = null;
}
