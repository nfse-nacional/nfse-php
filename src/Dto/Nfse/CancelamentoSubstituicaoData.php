<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

/**
 * DTO para evento e105102 - Cancelamento de NFS-e por Substituição
 * Baseado em TE105102 do schema tiposEventos_v1.01.xsd
 */
class CancelamentoSubstituicaoData extends Dto
{
    /**
     * Descrição do Evento: "Cancelamento de NFS-e por Substituicao"
     */
    #[MapFrom('xDesc')]
    public ?string $descricao = null;

    /**
     * Código de justificativa de cancelamento substituição
     */
    #[MapFrom('cMotivo')]
    public ?string $codigoMotivo = null;

    /**
     * Descrição para explicitar o motivo indicado neste evento (opcional)
     */
    #[MapFrom('xMotivo')]
    public ?string $descricaoMotivo = null;

    /**
     * Chave de Acesso da NFS-e substituta
     */
    #[MapFrom('chSubstituta')]
    public ?string $chaveNfseSubstituta = null;
}
