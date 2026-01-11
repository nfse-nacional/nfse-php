<?php

namespace NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS;

/**
 * CInfDPSData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
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
     * Motivo da Emissão da DPS pelo Tomador/Intermediário:
     * 1 - Importação de Serviço;
     * 2 - Tomador/Intermediário obrigado a emitir NFS-e por legislação municipal;
     * 3 - Tomador/Intermediário emitindo NFS-e por recusa de emissão pelo prestador;
     * 4 - Tomador/Intermediário emitindo por rejeitar a NFS-e emitida pelo prestador;
     */
    public ?string $cMotivoEmisTI = null;

    /**
     * Chave de Acesso da NFS-e rejeitada pelo Tomador/Intermediário.
     */
    public ?string $chNFSeRej = null;

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
    public ?\NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\CSubstituicaoData $subst = null;

    /**
     * Grupo de informações do DPS relativas ao Prestador de Serviços
     */
    public \NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\CInfoPrestadorData $prest;

    /**
     * Grupo de informações do DPS relativas ao Tomador de Serviços
     */
    public ?\NFSe\Dto\V1_0_1\CInfoPessoaData $toma = null;

    /**
     * Grupo de informações do DPS relativas ao Intermediário de Serviços
     */
    public ?\NFSe\Dto\V1_0_1\CInfoPessoaData $interm = null;

    /**
     * Grupo de informações do DPS relativas ao Serviço Prestado
     */
    public \NFSe\Dto\V1_0_1\NFSe\InfNFSe\DPS\InfDPS\CServData $serv;

    /**
     * Grupo de informações relativas à valores do serviço prestado
     */
    public \NFSe\Dto\V1_0_1\CInfoValoresData $valores;

    /**
     * Grupo de informações declaradas pelo emitente referentes ao IBS e à CBS
     */
    public ?\NFSe\Dto\V1_0_1\CRTCInfoIBSCBSData $IBSCBS = null;

    /**
     * Atributo XML
     */
    public string $Id;

}
