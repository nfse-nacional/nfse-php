<?php

namespace NFSe\Dto\V1_0_0\Evento;

/**
 * CInfoEventoRejeicaoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfoEventoRejeicao
 */
class CInfoEventoRejeicaoData 
{
    /**
     * Motivo da Rejeição da NFS-e:
     * 
     * 1 - NFS-e em duplicidade;
     * 2 - NFS-e já emitida pelo tomador;
     * 3 - Não ocorrência do fato gerador;
     * 4 - Erro quanto a responsabilidade tributária;
     * 5 - Erro quanto ao valor do serviço, valor das deduções ou serviço prestado ou data
     * do fato gerador;
     * 9 - Outros;
     */
    public string $cMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public ?string $xMotivo = null;

}
