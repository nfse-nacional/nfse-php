<?php

namespace NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg;

use NFSe\Dto\Attributes\MapFrom;

/**
 * E101103
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TE101103
 */
class E101103 
{
    /**
     * Descrição do evento: "Solicitação de Análise Fiscal para Cancelamento de NFS-e"
     */
    public string $xDesc;

    /**
     * Código do motivo da solicitação de análise fiscal para cancelamento de NFS-e:
     */
    public \Nfse\Enums\V1_0_0\TSCodJustAnaliseFiscalCanc $cMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public string $xMotivo;

}
