<?php

namespace NFSe\Dto\V1_0_1\PedRegEvt\InfPedReg;

use NFSe\Dto\Attributes\MapFrom;

/**
 * E305102
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TE305102
 */
class E305102 
{
    /**
     * Descrição do evento: "Bloqueio de NFS-e por Ofício".
     */
    public string $xDesc;

    /**
     * CPF do agente da administração tributária municipal que efetuou o cancelamento por ofício de
     * NFS-e.
     */
    public string $CPFAgTrib;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public string $xMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public \Nfse\Enums\V1_0_1\TSCodigoEventoNFSe $codEvento;

}
