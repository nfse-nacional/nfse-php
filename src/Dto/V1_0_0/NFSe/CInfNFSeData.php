<?php

namespace NFSe\Dto\V1_0_0\NFSe;

/**
 * CInfNFSeData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.0
 * Tipo original: TCInfNFSe
 */
class CInfNFSeData 
{
    /**
     * Descrição do código do IBGE do município emissor da NFS-e.
     */
    public string $xLocEmi;

    /**
     * Descrição do local da prestação do serviço.
     */
    public string $xLocPrestacao;

    /**
     * Número sequencial por tipo de emitente da NFS-e.
     * A Sefin Nacional NFS-e irá gerar o número da NFS-e de forma sequencial por emitente.
     * Por se tratar de um ambiente altamente transacional, a Sefin Nacional NFS-e não irá reutilizar
     * números inutilizados durante a geração da NFS-e.
     */
    public string $nNFSe;

    /**
     * O código de município utilizado pelo Sistema Nacional NFS-e é o código definido para cada
     * município pertencente ao ""Anexo V – Tabela de Código de Municípios do IBGE"", que consta ao
     * final do Manual de Orientação ao Contribuinte do ISSQN para a Sefin Nacional NFS-e.
     * O município de incidência do ISSQN é determinado automaticamente pelo sistema,
     * conforme regras do aspecto espacial da lei complementar federal (LC 116/03) que são válidas para
     * todos  os municípios.
     * http://www.planalto.gov.br/ccivil_03/Leis/LCP/Lcp116.htm
     */
    public ?string $cLocIncid = null;

    /**
     * A descrição do código de município utilizado pelo Sistema Nacional NFS-e é o nome de cada
     * município pertencente ao "Anexo V – Tabela de Código de Municípios do IBGE", que consta ao
     * final do Manual de Orientação ao Contribuinte do ISSQN para a Sefin Nacional NFS-e.
     */
    public ?string $xLocIncid = null;

    /**
     * Descrição do código de tributação nacional do ISSQN.
     */
    public string $xTribNac;

    /**
     * Descrição do código de tributação municipal do ISSQN.
     */
    public ?string $xTribMun = null;

    /**
     * Descrição do código da NBS.
     */
    public ?string $xNBS = null;

    /**
     * Versão do aplicativo que gerou a NFS-e
     */
    public string $verAplic;

    /**
     * Ambiente gerador da NFS-e
     */
    public string $ambGer;

    /**
     * Processo de Emissão da DPS:
     * 1 - Emissão com aplicativo do contribuinte (via Web Service);
     * 2 - Emissão com aplicativo disponibilizado pelo fisco (Web);
     * 3 - Emissão com aplicativo disponibilizado pelo fisco (App);
     */
    public string $tpEmis;

    /**
     * Processo de Emissão da DPS:
     * 1 - Emissão com aplicativo do contribuinte (via Web Service);
     * 2 - Emissão com aplicativo disponibilizado pelo fisco (Web);
     * 3 - Emissão com aplicativo disponibilizado pelo fisco (App);
     */
    public string $procEmi;

    /**
     * Código do Status da mensagem
     */
    public string $cStat;

    /**
     * Data/Hora da validação da DPS e geração da NFS-e. Data e hora no formato UTC (Universal
     * Coordinated Time):AAAA-MM-DDThh:mm:ssTZD
     */
    public string $dhProc;

    /**
     * Número sequencial do documento gerado por ambiente gerador de DFSe do múnicípio.
     */
    public string $nDFSe;

    /**
     * Grupo de informações da DPS relativas ao emitente da NFS-e
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\CEmitenteData $emit;

    /**
     * Grupo de valores referentes ao Serviço Prestado
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\CValoresNFSeData $valores;

    /**
     * Grupo de informações da DPS relativas ao serviço prestado
     */
    public \NFSe\Dto\V1_0_0\NFSe\InfNFSe\CDPSData $DPS;

    /**
     * Atributo XML
     */
    public string $Id;

}
