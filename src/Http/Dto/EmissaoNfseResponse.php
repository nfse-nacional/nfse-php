<?php

namespace Nfse\Http\Dto;


class EmissaoNfseResponse 
{
    public ?int $tipoAmbiente = null;

    public ?string $versaoAplicativo = null;

    public ?string $dataHoraProcessamento = null;

    public ?string $idDps = null;

    public ?string $chaveAcesso = null;

    public ?string $nfseXmlGZipB64 = null;

    /** @var \Nfse\Http\Dto\MensagemProcessamentoDto[] */
    public array $alertas = [];

    /** @var \Nfse\Http\Dto\MensagemProcessamentoDto[] */
    public array $erros = [];
}
