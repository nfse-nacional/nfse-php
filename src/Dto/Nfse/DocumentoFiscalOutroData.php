<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DocumentoFiscalOutroData extends Dto
{
    /**
     * Código do município emissor do documento fiscal.
     */
    #[MapFrom('cMunDocFiscal')]
    public ?string $codigoMunicipioDocumentoFiscal = null;

    /**
     * Número do documento fiscal.
     */
    #[MapFrom('nDocFiscal')]
    public ?string $numeroDocumentoFiscal = null;

    /**
     * Descrição do documento fiscal.
     */
    #[MapFrom('xDocFiscal')]
    public ?string $descricaoDocumentoFiscal = null;
}
