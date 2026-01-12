<?php

namespace NFSe\Dto\V1_0_1\DPS\InfDPS\Serv;

use NFSe\Dto\Attributes\MapFrom;

/**
 * AtvEvento
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCAtvEvento
 */
class AtvEvento 
{
    /**
     * Descrição do evento Artístico, Cultural, Esportivo, etc
     */
    public string $xNome;

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
    public string $idAtvEvt;

    /**
     * Grupo de informações relativas ao endereço da atividade, evento ou local do serviço prestado
     */
    public \NFSe\Dto\V1_0_1\DPS\InfDPS\Serv\AtvEvento\EnderecoSimples $end;

}
