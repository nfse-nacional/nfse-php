<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\Serv;

/**
 * CAtvEventoData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCAtvEvento
 */
class CAtvEventoData 
{
    /**
     * Descrição do evento Artístico, Cultural, Esportivo, etc
     */
    public string $desc;

    /**
     * Data de início da atividade de evento. Ano, Mês e Dia (AAAA-MM-DD)
     */
    public string $dtIni;

    /**
     * Data de fim da atividade de evento. Ano, Mês e Dia (AAAA-MM-DD)
     */
    public string $dtFim;

    /**
     * Identificação da Atividade de Evento (código identificador de evento determinado pela
     * Administração Tributária Municipal)
     */
    public string $id;

    /**
     * Grupo de informações relativas ao endereço da atividade, evento ou local do serviço prestado
     */
    public \NFSe\Dto\V1_0_0\CEnderecoSimplesData $end;

}
