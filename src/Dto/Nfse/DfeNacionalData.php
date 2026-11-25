<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Nfse\Enums\TipoChaveDFe;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;

class DfeNacionalData extends Dto
{
    /**
     * Documento fiscal da chave: 1 NFS-e, 2 NF-e, 3 CT-e, 9 outro.
     */
    #[MapFrom('tipoChaveDFe'), CastWith(EnumCaster::class, enumType: TipoChaveDFe::class)]
    public ?TipoChaveDFe $tipoChaveDfe = null;

    /**
     * Descrição do documento quando o tipo da chave é 9.
     */
    #[MapFrom('xTipoChaveDFe')]
    public ?string $descricaoTipoChaveDfe = null;

    /**
     * Chave de acesso do documento fiscal eletrônico.
     */
    #[MapFrom('chaveDFe')]
    public ?string $chaveDfe = null;
}
