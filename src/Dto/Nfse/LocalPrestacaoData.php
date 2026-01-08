<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class LocalPrestacaoData extends Dto
{
    /**
     * Código do município onde o serviço foi prestado (IBGE).
     * Utilizar 0000000 para "Águas Marítimas".
     */
    #[MapFrom('cLocPrestacao')]
    public ?string $codigoLocalPrestacao = null;

    /**
     * Código do país onde o serviço foi prestado (ISO2).
     * Obrigatório se o serviço for prestado no exterior.
     */
    #[MapFrom('cPaisPrestacao')]
    public ?string $codigoPaisPrestacao = null;
}
