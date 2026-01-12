<?php

namespace NFSe\Dto\V1_0_0\PedRegEvt;

use NFSe\Dto\Attributes\MapFrom;

/**
 * InfPedReg
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfPedReg
 */
class InfPedReg 
{
    /**
     * Identificação do Ambiente: 1 - Produção; 2 - Homologação
     */
    public \Nfse\Enums\V1_0_0\TSTipoAmbiente $tpAmb;

    /**
     * Versão do aplicativo que gerou o pedido de registro de evento.
     */
    public string $verAplic;

    /**
     * Data e hora do evento no formato AAAA-MM-DDThh:mm:ssTZD (UTC - Universal Coordinated Time, onde TZD
     * pode ser -02:00 (Fernando de Noronha), -03:00 (Brasília) ou -04:00 (Manaus), no horário de verão
     * serão -01:00, -02:00 e -03:00.
     * Ex.: 2010-08-19T13:00:15-03:00.
     */
    public string $dhEvento;

    /**
     * CNPJ do autor do evento.
     */
    public string $CNPJAutor;

    /**
     * CPF do autor do evento.
     */
    public string $CPFAutor;

    /**
     * Chave de Acesso da NFS-e vinculada ao Evento
     */
    public string $chNFSe;

    /**
     * Número do pedido do registro de evento para o mesmo tipo de evento.
     * Para os eventos que ocorrem somente uma vez, como é o caso do cancelamento, o
     * nPedRegEvento deve ser igual a 1.
     * Os eventos que podem ocorrer mais de uma vez devem ter o nPedRegEvento único.
     */
    public string $nPedRegEvento;

    /**
     * Evento de cancelamento
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E101101 $e101101;

    /**
     * Evento de cancelamento por substituição
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E105102 $e105102;

    /**
     * Solicitação de Análise Fiscal para Cancelamento de NFS-e
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E101103 $e101103;

    /**
     * Cancelamento de NFS-e Deferido por Análise Fiscal
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E105104 $e105104;

    /**
     * Cancelamento de NFS-e Indeferido por Análise Fiscal
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E105105 $e105105;

    /**
     * Confirmação do Prestador
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E202201 $e202201;

    /**
     * Confirmação do Tomador
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E203202 $e203202;

    /**
     * Confirmação do Intermediário
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E204203 $e204203;

    /**
     * Confirmação Tácita
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E205204 $e205204;

    /**
     * Rejeição do Prestador
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E202205 $e202205;

    /**
     * Rejeição do Tomador
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E203206 $e203206;

    /**
     * Rejeição do Intermediário
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E204207 $e204207;

    /**
     * Anulação da Rejeição
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E205208 $e205208;

    /**
     * Cancelamento de NFS-e por Ofício
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E305101 $e305101;

    /**
     * Bloqueio de NFS-e por Ofício
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E305102 $e305102;

    /**
     * Desbloqueio de NFS-e por Ofício
     */
    public \NFSe\Dto\V1_0_0\PedRegEvt\InfPedReg\E305103 $e305103;

    /**
     * Atributo XML
     */
    public string $Id;

}
