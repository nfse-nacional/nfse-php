<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Support\DTO\ArrayCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class AjusteBaseCalculoData extends Dto
{
    /**
     * Percentual padrão para ajuste da base de cálculo do ISSQN.
     */
    #[MapFrom('pAjusteBCISSQN')]
    public ?float $percentualAjusteBaseCalculoIssqn = null;

    /**
     * Valor monetário padrão para ajuste da base de cálculo do ISSQN (R$).
     */
    #[MapFrom('vAjusteBCISSQN')]
    public ?float $valorAjusteBaseCalculoIssqn = null;

    /**
     * Documentos utilizados para o ajuste da base de cálculo.
     *
     * @var DocumentoAjusteBaseCalculoData[]|null
     */
    #[MapFrom('documentos.docAjusteBC'), CastWith(ArrayCaster::class, itemType: DocumentoAjusteBaseCalculoData::class)]
    public ?array $documentos = null;

    /**
     * Ajuste da base de cálculo do IBS e da CBS no comércio exterior. Schema 20261124.
     */
    #[MapFrom('vAjusteBCIBSCBSComExt')]
    public ?float $valorAjusteBaseCalculoIbscbsComercioExterior = null;
}
