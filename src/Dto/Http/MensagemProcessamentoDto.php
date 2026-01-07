<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;

class MensagemProcessamentoDto extends Dto
{
    public ?string $mensagem = null;

    public ?array $parametros = null;

    public ?string $codigo = null;

    public ?string $descricao = null;

    public ?string $complemento = null;
}
