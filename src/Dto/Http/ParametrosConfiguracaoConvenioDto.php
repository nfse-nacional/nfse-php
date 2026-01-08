<?php

namespace Nfse\Dto\Http;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ParametrosConfiguracaoConvenioDto extends Dto
{
    #[MapFrom('aderenteAmbienteNacional')]
    public ?int $aderenteAmbienteNacional = null;

    #[MapFrom('aderenteEmissorNacional')]
    public ?int $aderenteEmissorNacional = null;

    #[MapFrom('situacaoEmissaoPadraoContribuintesRFB')]
    public ?int $situacaoEmissaoPadraoContribuintesRFB = null;

    #[MapFrom('aderenteMAN')]
    public ?int $aderenteMAN = null;

    #[MapFrom('permiteAproveitametoDeCreditos')]
    public ?bool $permiteAproveitametoDeCreditos = null;
}
