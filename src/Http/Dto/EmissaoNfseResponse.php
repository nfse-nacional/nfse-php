<?php

namespace Nfse\Http\Dto;

use Spatie\LaravelData\Data;

class EmissaoNfseResponse extends Data
{
    /**
     * @param MensagemProcessamentoDto[] $alertas
     * @param MensagemProcessamentoDto[] $erros
     */
    public function __construct(
        public ?int $tipoAmbiente = null,
        public ?string $versaoAplicativo = null,
        public ?string $dataHoraProcessamento = null,
        public ?string $idDps = null,
        public ?string $chaveAcesso = null,
        public ?string $nfseXmlGZipB64 = null,
        public array $alertas = [],
        public array $erros = [],
    ) {}
}
