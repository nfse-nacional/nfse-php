<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Support\DTO\ArrayCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DeducaoReducaoData extends Dto
{
    /**
     * Percentual de dedução/redução da base de cálculo.
     */
    #[MapFrom('pDR')]
    public ?float $percentualDeducaoReducao = null;

    /**
     * Valor monetário de dedução/redução da base de cálculo.
     */
    #[MapFrom('vDR')]
    public ?float $valorDeducaoReducao = null;

    /**
     * Documentos comprobatórios da dedução/redução.
     *
     * @var DocumentoDeducaoData[]|null
     */
    #[MapFrom('documentos'), CastWith(ArrayCaster::class, itemType: DocumentoDeducaoData::class)]
    public ?array $documentos = null;
}
