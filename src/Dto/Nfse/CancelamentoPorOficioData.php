<?php

namespace Nfse\Dto\Nfse;

use Nfse\Dto\Dto;
use Spatie\DataTransferObject\Attributes\MapFrom;

/**
 * DTO para evento e305101 - Cancelamento de NFS-e Por Ofício
 * Baseado em TE305101 do schema tiposEventos_v1.01.xsd
 * Cancelamento iniciado por determinação ou ordem oficial da administração tributária
 */
class CancelamentoPorOficioData extends Dto
{
    /**
     * Descrição do Evento: "Cancelamento de NFS-e por Ofício"
     */
    #[MapFrom('xDesc')]
    public ?string $descricao = null;

    /**
     * CPF do agente da administração tributária municipal que efetuou
     * o cancelamento por ofício de NFS-e
     */
    #[MapFrom('CPFAgTrib')]
    public ?string $cpfAgenteTributario = null;

    /**
     * Número do processo administrativo municipal vinculado ao
     * cancelamento de NFS-e por ofício
     */
    #[MapFrom('nProcAdm')]
    public ?string $numeroProcessoAdministrativo = null;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    #[MapFrom('xProcAdm')]
    public ?string $descricaoProcessoAdministrativo = null;
}
