<?php

namespace NFSe\Dto\V1_0_0;

/**
 * E105102Data
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TE105102
 */
class E105102Data 
{
    /**
     * Descrição do Evento: Descrição do evento: "Cancelamento de NFS-e por Substituição".
     */
    public string $xDesc;

    /**
     * Código de justificativa de cancelamento substituição
     */
    public string $cMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public ?string $xMotivo = null;

    /**
     * Chave de Acesso da NFS-e substituta.
     */
    public string $chSubstituta;

}
