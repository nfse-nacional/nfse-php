<?php

namespace NFSe\Dto\V1_0_0;

/**
 * E105105Data
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TE105105
 */
class E105105Data 
{
    /**
     * Descrição do evento: "Cancelamento de NFS-e Indeferido por Análise Fiscal".
     */
    public string $xDesc;

    /**
     * CPF do agente da administração tributária municipal que efetuou o indeferimento da solicitação
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
     * 1 - Cancelamento de NFS-e Indeferido;
     * 2 - Cancelamento de NFS-e Indeferido Sem Análise de Mérito.
     */
    public string $cMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public string $xMotivo;

}
