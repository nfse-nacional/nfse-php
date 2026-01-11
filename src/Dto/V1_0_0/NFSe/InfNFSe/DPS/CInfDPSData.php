<?php

namespace NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS;

/**
 * CInfDPSData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfDPS
 */
class CInfDPSData 
{
    /**
     * Identificação do Ambiente: 1 - Produção; 2 - Homologação
     */
    public string $tpAmb;

    /**
     * Data e hora da emissão do DPS. Data e hora no formato UTC (Universal Coordinated Time):
     * AAAA-MM-DDThh:mm:ssTZD
     */
    public string $dhEmi;

    /**
     * Versão do aplicativo que gerou o DPS
     */
    public string $verAplic;

    /**
     * Número do equipamento emissor do DPS ou série do DPS
     */
    public string $serie;

    /**
     * Número do DPS
     */
    public string $nDPS;

    /**
     * Data em que se iniciou a prestação do serviço: Dia, mês e ano (AAAAMMDD)
     */
    public string $dCompet;

    /**
     * Emitente da DPS: 1 - Prestador; 2 - Tomador; 3 - Intermediário
     */
    public string $tpEmit;

    /**
     * O código de município utilizado pelo Sistema Nacional NFS-e é o código definido para cada
     * município pertencente ao ""Anexo V – Tabela de Código de Municípios do IBGE"", que consta ao
     * final do Manual de Orientação ao Contribuinte do ISSQN para a Sefin Nacional NFS-e.
     * O município emissor da NFS-e é aquele município em que o emitente da DPS está
     * cadastrado e autorizado a "emitir uma NFS-e", ou seja, emitir uma DPS para que o sistema nacional
     * valide as informações nela prestadas e gere a NFS-e correspondente para o emitente.
     * Para que o sistema nacional emita a NFS-e o município emissor deve ser conveniado e
     * estar ativo no sistema nacional. Além disso o convênio do município deve permitir que os
     * contribuintes do município utilize os emissores públicos do Sistema Nacional NFS-e
     */
    public string $cLocEmi;

    /**
     * Dados da NFS-e a ser substituída
     */
    public ?\NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\CSubstituicaoData $subst = null;

    /**
     * Grupo de informações do DPS relativas ao Prestador de Serviços
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\CInfoPrestadorData $prest;

    /**
     * Grupo de informações do DPS relativas ao Tomador de Serviços
     */
    public ?\NFSe\Dto\V1_0_0\CInfoPessoaData $toma = null;

    /**
     * Grupo de informações do DPS relativas ao Intermediário de Serviços
     */
    public ?\NFSe\Dto\V1_0_0\CInfoPessoaData $interm = null;

    /**
     * Grupo de informações do DPS relativas ao Serviço Prestado
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\DPS\InfDPS\CServData $serv;

    /**
     * Grupo de informações relativas à valores do serviço prestado
     */
    public \NFSe\Dto\V1_0_0\CInfoValoresData $valores;

    /**
     * Atributo XML
     */
    public string $Id;

}
