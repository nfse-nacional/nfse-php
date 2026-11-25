<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class BemMovelData extends Dto
{
    /**
     * Código NCM do bem móvel.
     */
    #[MapFrom('cNCMBemMovel')]
    public ?string $codigoNcmBemMovel = null;

    /**
     * Descrição do bem móvel.
     */
    #[MapFrom('xNCMBemMovel')]
    public ?string $descricaoNcmBemMovel = null;

    /**
     * Quantidade do bem móvel.
     */
    #[MapFrom('qtdNCMBemMovel')]
    public ?int $quantidadeNcmBemMovel = null;
}
