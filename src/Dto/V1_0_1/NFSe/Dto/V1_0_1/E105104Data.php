<?php

namespace NFSe\Dto\V1_0_1;

/**
 * E105104Data
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TE105104
 */
class E105104Data 
{
    /**
     * Descrição do evento: "Cancelamento de NFS-e Deferido por Análise Fiscal"
     */
    public string $xDesc;

    /**
     * CPF do agente da administração tributária municipal que efetuou o deferimento da  solicitação
     * de análise fiscal para cancelamento de NFS-e.
     */
    public string $CPFAgTrib;

    /**
     * Número do processo administrativo municipal vinculado à solicitação de análise fiscal para
     * cancelamento de NFS-e.
     */
    public ?string $nProcAdm = null;

    /**
     * Resposta da solicitação de análise fiscal para cancelamento de NFS-e:
     * 1 - Cancelamento de NFS-e Deferido.
     */
    public string $cMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public string $xMotivo;

}
