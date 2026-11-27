<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\TipoAjusteBaseCalculoLocacaoImovel;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class AjusteBaseCalculoLocacaoImovelData extends Dto
{
    /**
     * Tipo da parcela que não entra na base de cálculo.
     */
    #[MapFrom('tpAjusteBCLocImoveis'), CastWith(EnumCaster::class, enumType: TipoAjusteBaseCalculoLocacaoImovel::class)]
    public ?TipoAjusteBaseCalculoLocacaoImovel $tipoAjusteBaseCalculoLocacao = null;

    /**
     * Descrição da parcela quando o tipo é 99.
     */
    #[MapFrom('xTpAjusteBCLocImoveis')]
    public ?string $descricaoTipoAjusteBaseCalculoLocacao = null;

    /**
     * Valor da parcela que não entra na base (R$).
     */
    #[MapFrom('vAjusteBCLocImoveis')]
    public ?float $valorAjusteBaseCalculoLocacao = null;
}
