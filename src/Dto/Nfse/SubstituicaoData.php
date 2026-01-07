<?php

namespace Nfse\Dto\Nfse;

use Nfse\Enums\MotivoSubstituicao;
use Nfse\Support\DTO\EnumCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Nfse\Dto\Dto;

class SubstituicaoData extends Dto
{
    /**
     * Chave de acesso da NFS-e a ser substituída.
     */
    #[MapFrom('chSubstda')]
    public ?string $chaveNfseSubstituida = null;

    /**
     * Código do motivo da substituição.
     * 01 - Desenquadramento de NFS-e do Simples Nacional
     * 02 - Enquadramento de NFS-e no Simples Nacional
     * 99 - Outros
     */
    #[MapFrom('cMotivo'), CastWith(EnumCaster::class, enumType: MotivoSubstituicao::class)]
    public ?MotivoSubstituicao $codigoMotivo = null;

    /**
     * Descrição do motivo da substituição.
     * Obrigatório se cMotivo = 99.
     */
    #[MapFrom('xMotivo')]
    public ?string $descricaoMotivo = null;
}
