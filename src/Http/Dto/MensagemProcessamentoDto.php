<?php

namespace Nfse\Http\Dto;

use Spatie\LaravelData\Data;

class MensagemProcessamentoDto extends Data
{
    public function __construct(
        public ?string $mensagem = null,
        public ?array $parametros = null,
        public ?string $codigo = null,
        public ?string $descricao = null,
        public ?string $complemento = null,
    ) {}
}
