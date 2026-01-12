<?php

namespace NFSe\Dto\V1_0_1\PedRegEvt\InfPedReg\E202205;

use NFSe\Dto\Attributes\MapFrom;

/**
 * InfoEventoRejeicao
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCInfoEventoRejeicao
 */
class InfoEventoRejeicao 
{
    /**
     * Motivo da Rejeição da NFS-e:
     * 1 - NFS-e em duplicidade;
     * 2 - NFS-e já emitida pelo tomador;
     * 3 - Não ocorrência do fato gerador;
     * 4 - Erro quanto a responsabilidade tributária;
     * 5 - Erro quanto ao valor do serviço, valor das deduções ou serviço prestado ou data
     * do fato gerador;
     * 9 - Outros;
     */
    public \Nfse\Enums\V1_0_1\TSCodMotivoRejeicao $cMotivo;

    /**
     * Descrição para explicitar o motivo indicado neste evento
     */
    public ?string $xMotivo = null;

}
