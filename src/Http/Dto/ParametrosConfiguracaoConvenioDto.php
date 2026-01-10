<?php

namespace Nfse\Http\Dto;

use CuyZ\Valinor\Mapper\Source\Source;

class ParametrosConfiguracaoConvenioDto 
{
    #[Source('aderenteAmbienteNacional')]
    public ?int $aderenteAmbienteNacional = null;

    #[Source('aderenteEmissorNacional')]
    public ?int $aderenteEmissorNacional = null;

    #[Source('situacaoEmissaoPadraoContribuintesRFB')]
    public ?int $situacaoEmissaoPadraoContribuintesRFB = null;

    #[Source('aderenteMAN')]
    public ?int $aderenteMAN = null;

    #[Source('permiteAproveitametoDeCreditos')]
    public ?bool $permiteAproveitametoDeCreditos = null;

    #[Source('tipoConvenio')]
    public ?int $tipoConvenio = null;
}
