<?php

namespace NFSe\Dto\V1_0_1\PedRegEvt\InfPedReg;

use NFSe\Dto\Attributes\MapFrom;

/**
 * E101101
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TE101101
 */
class E101101 
{
    /**
     * Descrição do Evento: Descrição do evento: "Cancelamento de NFS-e".
     */
    public string $xDesc;

    /**
     * Código de justificativa de cancelamento
     */
    public \Nfse\Enums\V1_0_1\TSCodJustCanc $cMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public string $xMotivo;

}
