<?php

namespace NFSe\Dto\V1_0_1\PedRegEvt\InfPedReg;

use NFSe\Dto\Attributes\MapFrom;

/**
 * E105102
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TE105102
 */
class E105102 
{
    /**
     * Descrição do Evento: Descrição do evento: "Cancelamento de NFS-e por Substituição".
     */
    public string $xDesc;

    /**
     * Código de justificativa de cancelamento substituição
     */
    public \Nfse\Enums\V1_0_1\TSCodJustSubst $cMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public ?string $xMotivo = null;

    /**
     * Chave de Acesso da NFS-e substituta.
     */
    public string $chSubstituta;

}
