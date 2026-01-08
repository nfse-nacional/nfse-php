<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class EnderecoExteriorData extends Dto
{
    /**
     * Código do país (ISO2).
     */
    #[MapFrom('cPais')]
    public ?string $codigoPais = null;

    /**
     * Código de endereçamento postal.
     */
    #[MapFrom('cEndPost')]
    public ?string $codigoEnderecamentoPostal = null;

    /**
     * Nome da cidade.
     */
    #[MapFrom('xCidade')]
    public ?string $cidade = null;

    /**
     * Estado, província ou região.
     */
    #[MapFrom('xEstProvReg')]
    public ?string $estadoProvinciaRegiao = null;
}
