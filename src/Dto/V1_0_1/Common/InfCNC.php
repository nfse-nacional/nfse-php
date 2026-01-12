<?php

namespace NFSe\Dto\V1_0_1\Common;

use NFSe\Dto\Attributes\MapFrom;

/**
 * InfCNC
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCInfCNC
 */
class InfCNC 
{
    /**
     * Identificação do Ambiente: 1 - Produção; 2 - Homologação
     */
    public \Nfse\Enums\V1_0_1\TSTipoAmbiente $tpAmb;

    /**
     * Data e hora da geração do arquivo CNC. Data e hora no formato UTC (Universal Coordinated Time):
     * AAAA-MM-DDThh:mm:ssTZD
     */
    public string $dhGeracaoArquivo;

    /**
     * Versão do aplicativo que gerou Informações para cadastramento de novos contribuintes CNC
     */
    public string $verAplic;

    /**
     * Grupo de informações cadastramento de novos contribuintes CNC
     */
    public string $contribuintesCnc;

    /**
     * Grupo de informações cadastramento de novos contribuintes CNC
     */
    public array $contribuinteCnc = [];

}
