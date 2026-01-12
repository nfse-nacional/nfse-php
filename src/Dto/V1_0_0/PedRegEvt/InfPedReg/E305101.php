<?php

namespace NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg;

use NFSe\Dto\Attributes\MapFrom;

/**
 * E305101
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TE305101
 */
class E305101 
{
    /**
     * Descrição do evento: "Cancelamento de NFS-e por Ofício".
     */
    public string $xDesc;

    /**
     * CPF do agente da administração tributária municipal que efetuou o cancelamento por ofício de
     * NFS-e.
     */
    public string $CPFAgTrib;

    /**
     * Número do processo administrativo municipal vinculado ao cancelamento de NFS-e por ofício.
     */
    public string $nProcAdm;

    /**
     * Descrição para explicitar o motivo indicado neste evento.
     */
    public string $xProcAdm;

}
