<?php

namespace NFSe\Dto\V1_0_1;

/**
 * CDocDedRedData
 * 
 * Gerado automaticamente do schema XSD versão 1.0.1
 * Tipo original: TCDocDedRed
 */
class CDocDedRedData 
{
    /**
     * Chave de Acesso da NFS-e (Padrão Nacional)
     */
    public string $chNFSe;

    /**
     * Chave de Acesso da NF-e
     */
    public string $chNFe;

    /**
     * Grupo de informações de Outras NFS-e (Padrão anterior de NFS-e)
     */
    public \NFSe\Dto\V1_0_1\NFSe\InfNFSe\CDocOutNFSeData $NFSeMun;

    /**
     * Grupo de informações de NF ou NFS (Modelo não eletrônico)
     */
    public \NFSe\Dto\V1_0_1\CDocNFNFSData $NFNFS;

    /**
     * Número de documento fiscal
     */
    public string $nDocFisc;

    /**
     * Número de documento não fiscal
     */
    public string $nDoc;

    /**
     * Identificação da Dedução/Redução:
     * 1 – Alimentação e bebidas/frigobar;
     * 2 – Materiais;
     * 5 – Repasse consorciado;
     * 6 – Repasse plano de saúde;
     * 7 – Serviços;
     * 8 – Subempreitada de mão de obra;
     * 99 – Outras deduções;
     */
    public string $tpDedRed;

    /**
     * Descrição da Dedução/Redução quando a opção é "99 – Outras Deduções"
     */
    public ?string $xDescOutDed = null;

    /**
     * Data da emissão do documento dedutível. Ano, mês e dia (AAAA-MM-DD)
     */
    public string $dtEmiDoc;

    /**
     * Valor monetário total dedutível/redutível no documento informado (R$).
     * Este é o valor total no documento informado que é passível de dedução/redução.
     */
    public string $vDedutivelRedutivel;

    /**
     * Valor monetário utilizado para dedução/redução do valor do serviço da NFS-e que está sendo
     * emitida (R$).
     * Deve ser menor ou igual ao valor deduzível/redutível (vDedutivelRedutivel).
     */
    public string $vDeducaoReducao;

    /**
     * Grupo de informações do Fornecedor em Deduções de Serviços
     */
    public ?\NFSe\Dto\V1_0_1\CInfoPessoaData $fornec = null;

}
