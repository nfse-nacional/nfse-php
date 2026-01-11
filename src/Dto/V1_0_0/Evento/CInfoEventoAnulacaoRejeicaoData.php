<?php

namespace NFSe\Dto\V1_0_0\Evento;

/**
 * CInfoEventoAnulacaoRejeicaoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfoEventoAnulacaoRejeicao
 */
class CInfoEventoAnulacaoRejeicaoData 
{
    /**
     * CPF do agente da administração tributária municipal que efetuou o anulação da manifestação de
     * rejeição da NFS-e.
     */
    public string $CPFAgTrib;

    /**
     * Referência ao Id da "Manifestação de rejeição da NFS-e" que originou o presente evento de
     * anulação.
     */
    public string $idEvManifRej;

    /**
     * Descrição para explicitar o motivo da anluação
     */
    public string $xMotivo;

}
