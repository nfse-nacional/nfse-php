<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DocumentoOutroData extends Dto
{
    /**
     * Número do documento não fiscal.
     */
    #[MapFrom('nDoc')]
    public ?string $numeroDocumento = null;

    /**
     * Descrição do documento não fiscal.
     */
    #[MapFrom('xDoc')]
    public ?string $descricaoDocumento = null;
}
