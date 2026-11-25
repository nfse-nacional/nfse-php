<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Support\DTO\ArrayCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class ImovelData extends Dto
{
    /**
     * Código do município do imóvel (tabela do IBGE).
     */
    #[MapFrom('cMun')]
    public ?string $codigoMunicipio = null;

    /**
     * Locação, cessão onerosa ou arrendamento.
     */
    #[MapFrom('gLocacao')]
    public ?LocacaoData $locacao = null;

    /**
     * Unidades imobiliárias objeto da operação.
     *
     * @var UnidadeImovelData[]|null
     */
    #[MapFrom('gUnidImob'), CastWith(ArrayCaster::class, itemType: UnidadeImovelData::class)]
    public ?array $unidadesImovel = null;
}
