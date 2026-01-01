<?php

namespace Nfse\Dto\Http;

class ParametrosConfiguracaoConvenioDto
{
    public function __construct(
        public ?int $tipoConvenio = null,
        public ?int $aderenteAmbienteNacional = null,
        public ?int $aderenteEmissorNacional = null,
        public ?int $situacaoEmissaoPadraoContribuintesRFB = null,
        public ?int $aderenteMAN = null,
        public ?bool $permiteAproveitametoDeCreditos = null,
    ) {}
}
