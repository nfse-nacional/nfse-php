<?php

namespace Nfse\Dto\Http;

class ResultadoConsultaConfiguracoesConvenioResponse
{
    public function __construct(
        public ?string $mensagem = null,
        public ?ParametrosConfiguracaoConvenioDto $parametrosConvenio = null,
    ) {}
}
