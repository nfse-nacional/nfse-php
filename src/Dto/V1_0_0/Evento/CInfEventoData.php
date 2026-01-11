<?php

namespace NFSe\Dto\V1_0_0\Evento;

/**
 * CInfEventoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfEvento
 */
class CInfEventoData 
{
    /**
     * Versão do aplicativo que gerou o pedido do evento.
     */
    public ?string $verAplic = null;

    /**
     * Ambiente gerador do evento
     */
    public string $ambGer;

    /**
     * Sequencial do evento para o mesmo tipo de evento. Para maioria dos eventos nSeqEvento=1. Nos casos
     * em que possa existir mais de um evento do mesmo tipo o ambiente gerador deverá numerar de forma
     * sequencial.
     */
    public string $nSeqEvento;

    /**
     * Data/Hora do registro do evento.
     * Data e hora no formato UTC (Universal Coordinated Time): AAAA-MM-DDThh:mm:ssTZD"
     */
    public string $dhProc;

    /**
     * Ambiente gerador do evento
     */
    public string $nDFe;

    /**
     * Leiaute do pedido de registro do evento gerado pelo autor do evento
     */
    public \NFSe\Dto\V1_0_0\CPedRegEvtData $pedRegEvento;

    /**
     * Atributo XML
     */
    public string $Id;

}
